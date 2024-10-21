<?php

namespace ziaadini\bidashboard\models;

use yii\behaviors\BlameableBehavior;
use yii\behaviors\TimestampBehavior;
use yii\db\ActiveRecord;
use ziaadini\bidashboard\behaviors\Jsonable;
use ziaadini\bidashboard\models\ReportWidget;
use yii2tech\ar\softdelete\SoftDeleteBehavior;
use Yii;
use ziaadini\bidashboard\traits\CoreTrait;

/**
 * This is the model class for table "report_dashboard".
 *
 * @property int $id
 * @property int $slave_id
 * @property int $alert_id
 * @property int $box_id
 * @property int $dashboard_id
 * @property string|null $widget_result_alerting
 * @property int $widget_result_id
 * @property int $widget_id
 * @property string $widget_field
 * @property int $seen_status
 * @property int $seen_time
 * @property int $seen_by_id
 * @property string $seen_by_name
 * @property int $status
 * @property int $created_at
 * @property int $updated_at
 * @property int $deleted_at
 * @property int|null $updated_by
 * @property int|null $created_by
 *
 * @mixin SoftDeleteBehavior
 */

class ReportFiredAlert extends ActiveRecord
{
    use CoreTrait;

    const STATUS_ACTIVE = 1;
    const STATUS_DELETED = 0;
    const STATUS_INACTIVE = 2;

    const NOT_SEEN = 0;
    const SEEN = 1;

    public $result;

    public static function getDb()
    {
        return Yii::$app->noSlaveBiDB ?? Yii::$app->biDB;
    }

    public static function tableName()
    {
        return '{{%report_fired_alert}}';
    }

    public function rules()
    {
        return [
            [['slave_id'], 'default', 'value' => function () {
                return Yii::$app->params['bi_slave_id'] ?? null;
            }],
            [['slave_id', 'alert_id', 'box_id', 'dashboard_id', 'widget_result_id', 'widget_id', 'widget_field'], 'required'],
            [['slave_id', 'alert_id', 'box_id', 'dashboard_id', 'widget_result_id', 'widget_id', 'status', 'seen_status', 'seen_time', 'seen_by_id', 'created_at', 'updated_at', 'deleted_at', 'updated_by', 'created_by'], 'integer'],
            [['widget_field', 'seen_by_name'], 'string', 'max' => 64],
            [['widget_result_alerting'], 'safe'],
            [['alert_id'], 'exist', 'skipOnError' => true, 'targetClass' => ReportAlert::class, 'targetAttribute' => ['alert_id' => 'id']],
            [['box_id'], 'exist', 'skipOnError' => true, 'targetClass' => ReportBox::class, 'targetAttribute' => ['box_id' => 'id']],
            [['dashboard_id'], 'exist', 'skipOnError' => true, 'targetClass' => ReportDashboard::class, 'targetAttribute' => ['dashboard_id' => 'id']],
            [['widget_result_id'], 'exist', 'skipOnError' => true, 'targetClass' => ReportWidgetResult::class, 'targetAttribute' => ['widget_result_id' => 'id']],
            [['widget_id'], 'exist', 'skipOnError' => true, 'targetClass' => ReportWidget::class, 'targetAttribute' => ['widget_id' => 'id']],
        ];
    }

    public function attributeLabels()
    {
        return [
            'id' => Yii::t('biDashboard', 'ID'),
            'alert_id' => Yii::t('biDashboard', 'Alert Title'),
            'box_id' => Yii::t('biDashboard', 'Box'),
            'dashboard_id' => Yii::t('biDashboard', 'Dashboard'),
            'widget_result_id' => Yii::t('biDashboard', 'Widget'),
            'widget_id' => Yii::t('biDashboard', 'Widget'),
            'widget_field_name' => Yii::t('biDashboard', 'Widget Field'),
            'widget_field_title' => Yii::t('biDashboard', 'Widget Field'),
            'seen_status' => Yii::t('biDashboard', 'Seen'),
            'seen_time' => Yii::t('biDashboard', 'Seen'),
            'seen_by_id' => Yii::t('biDashboard', 'Seen'),
            'seen_by_name' => Yii::t('biDashboard', 'Seen'),
            'status' => Yii::t('biDashboard', 'Status'),
            'created_at' => Yii::t('biDashboard', 'Created At'),
            'updated_at' => Yii::t('biDashboard', 'Updated At'),
            'deleted_at' => Yii::t('biDashboard', 'Deleted At'),
            'updated_by' => Yii::t('biDashboard', 'Updated By'),
            'created_by' => Yii::t('biDashboard', 'Created By'),
        ];
    }

    public function canDelete()
    {
        return true;
    }

    public function afterSave($insert, $changedAttributes)
    {
        parent::afterSave($insert, $changedAttributes);

        $existFiredAlert = self::find()->where([
            'alert_id' => $this->alert_id,
            'seen_status' => self::NOT_SEEN
        ])->exists();

        $alert = ReportAlert::findOne($this->alert_id);

        if ($existFiredAlert)
        {
            if ($alert->state == ReportAlert::STATE_NORMAL) {
                $alert->state = ReportAlert::STATE_ALERTING;
                $flag = $alert->save(false);
            }
        }
        elseif (!$existFiredAlert)
        {
            if ($alert->state == ReportAlert::STATE_ALERTING) {
                $alert->state = ReportAlert::STATE_NORMAL;
                $flag = $alert->save(false);
            }
        }
    }

    public function getAlert()
    {
        return $this->hasOne(ReportAlert::class, ['id' => 'alert_id']);
    }

    /*public function getUser()
    {
        return $this->hasOne(Yii::getAlias('@userModel'), ['id' => 'seen_by']);
    }*/

    public function getBox()
    {
        return $this->hasOne(ReportBox::class, ['id' => 'box_id']);
    }

    public function getDashboard()
    {
        return $this->hasOne(ReportDashboard::class, ['id' => 'dashboard_id']);
    }

    public function getWidgetResult()
    {
        return $this->hasOne(ReportWidgetResult::class, ['id' => 'widget_result_id']);
    }

    public function getWidget()
    {
        return $this->hasOne(ReportWidget::class, ['id' => 'widget_id']);
    }

    public static function showFiredAlertResult(array $results, string $widgetField, int $widgetId) : string
    {
        $resultString = '';
        foreach ($results as $key => $value)
        {
            if ((int)$value > 1500)
                $value = number_format((float)$value);

            $widgetFieldTitle = ReportWidget::getWidgetFieldTitle($widgetId, $key);

            if ($key == $widgetField)
                $resultString .= "<span class='bg-danger font-bold d-inline-block py-1 px-2 rounded-md text-white m-1'>$widgetFieldTitle : $value</span>";
            else
                $resultString .= "<span class='bg-secondary font-bold d-inline-block py-1 px-2 rounded-md text-white m-1'>$widgetFieldTitle : $value</span>";
        }
        return $resultString;
    }

    public static function firedAlertResultAlreadyExist(int $boxId, int $widgetId, string $widgetField, array $result) : bool
    {
        $exist = false;
        $boxFiredAlertResults = self::find()
            ->select('widget_result_alerting')
            ->where([
                'box_id' => $boxId,
                'widget_id' => $widgetId,
                'widget_field' => $widgetField
            ])->all();

        foreach ($boxFiredAlertResults as $boxFiredAlertResult)
        {
            if ($boxFiredAlertResult->widget_result_alerting['result'] == $result){
                $exist = true;
                break;
            }
        }

        return $exist;
    }

    public static function find()
    {
        $query = new ReportFiredAlertQuery(get_called_class());
        return $query->bySlaveId()->notDeleted();
    }

    public static function itemAlias($type, $code = NULL)
    {
        $_items = [
            'Status' => [
                self::STATUS_ACTIVE => Yii::t('biDashboard', 'Active'),
                self::STATUS_INACTIVE => Yii::t('biDashboard', 'InActive'),
                self::STATUS_DELETED => Yii::t('biDashboard', 'Deleted'),
            ],
            'seen_status' => [
                self::SEEN => 'دیده شده',
                self::NOT_SEEN => 'دیده نشده',
            ],
        ];

        if (isset($code))
            return isset($_items[$type][$code]) ? $_items[$type][$code] : false;
        else
            return isset($_items[$type]) ? $_items[$type] : false;
    }

    public function behaviors()
    {
        return [
            'timestamp' => [
                'class' => TimestampBehavior::class
            ],
            [
                'class' => BlameableBehavior::class,
                'createdByAttribute' => 'created_by',
                'updatedByAttribute' => 'updated_by',
            ],
            'softDeleteBehavior' => [
                'class' => SoftDeleteBehavior::class,
                'softDeleteAttributeValues' => [
                    'deleted_at' => time(),
                    'status' => self::STATUS_DELETED
                ],
                'restoreAttributeValues' => [
                    'deleted_at' => 0,
                    'status' => self::STATUS_ACTIVE
                ],
                'replaceRegularDelete' => false,
                'invokeDeleteEvents' => true
            ],
            'jsonable' => [
                'class' => Jsonable::class,
                'jsonAttributes' => [
                    'widget_result_alerting' => [
                        'result',
                    ],
                ],
            ],
        ];
    }
}
