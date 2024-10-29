<?php

namespace ziaadini\bidashboard\models;

use phpseclib3\Crypt\EC\Curves\secp112r1;
use yii\behaviors\BlameableBehavior;
use yii\behaviors\TimestampBehavior;
use yii\db\ActiveRecord;
use yii\helpers\VarDumper;
use ziaadini\bidashboard\models\ReportWidget;
use yii2tech\ar\softdelete\SoftDeleteBehavior;
use Yii;
use ziaadini\bidashboard\traits\CoreTrait;

/**
 * This is the model class for table "report_dashboard".
 *
 * @property int $id
 * @property int $slave_id
 * @property int $widget_id
 * @property string $widget_field
 * @property string $notification_type
 * @property string $state
 * @property string $title
 * @property string $description
 * @property decimal $ceiling
 * @property decimal $floor
 * @property int $status
 * @property int $created_at
 * @property int $updated_at
 * @property int $deleted_at
 * @property int|null $updated_by
 * @property int|null $created_by
 *
 *
 *
 * @mixin SoftDeleteBehavior
 */

class ReportAlert extends ActiveRecord
{
    use CoreTrait;

    const STATUS_ACTIVE = 1;
    const STATUS_DELETED = 0;
    const STATUS_INACTIVE = 2;

    const NOTIFICATION_NONE = 0;
    const NOTIFICATION_SMS = 1;
    const NOTIFICATION_EMAIL = 2;
    const NOTIFICATION_BOTH = 3;

    const NOT_SEEN = 0;
    const SEEN = 1;

    const STATE_NORMAL = 0;
    const STATE_ALERTING = 1;

    public $users = [];

    public function __construct()
    {
        $this->users = $this->usersList();
    }

    public static function getDb()
    {
        return Yii::$app->noSlaveBiDB ?? Yii::$app->biDB;
    }

    public static function tableName()
    {
        return '{{%report_alert}}';
    }

    public function rules()
    {
        return [
            [['slave_id'], 'default', 'value' => function () {
                return Yii::$app->params['bi_slave_id'] ?? null;
            }],
            [['title', 'description', 'slave_id', 'widget_id', 'widget_field'], 'required'],
            [['ceiling', 'floor'], 'validateFloorOrCeiling', 'skipOnError' => false, 'skipOnEmpty' => false],
            [['widget_id', 'widget_field'], 'validateUniqueWidgetFieldCombination', 'skipOnError' => false, 'skipOnEmpty' => false],
            [['status', 'notification_type', 'seen', 'state', 'created_at', 'updated_at', 'deleted_at', 'updated_by', 'created_by', 'slave_id', 'ceiling', 'floor'], 'integer'],
            [['users'], 'validateUsersRequired', 'skipOnError' => false, 'skipOnEmpty' => false],
            [['title'], 'string', 'max' => 128],
            [['description'], 'string', 'max' => 255],
            [['widget_id'], 'exist', 'skipOnError' => true, 'targetClass' => ReportWidget::class, 'targetAttribute' => ['widget_id' => 'id']],
        ];
    }

    public function attributeLabels()
    {
        return [
            'id' => Yii::t('biDashboard', 'ID'),
            'title' => Yii::t('biDashboard', 'Title'),
            'description' => Yii::t('biDashboard', 'Description'),
            'notification_type' => Yii::t('biDashboard', 'Notification Type'),
            'widget_id' => Yii::t('biDashboard', 'Widget'),
            'widget_field' => Yii::t('biDashboard', 'Widget Field'),
            'status' => Yii::t('biDashboard', 'Status'),
            'state' => Yii::t('biDashboard', 'State'),
            'ceiling' => Yii::t('biDashboard', 'Ceiling Amount'),
            'floor' => Yii::t('biDashboard', 'Floor Amount'),
            'seen' => Yii::t('biDashboard', 'Seen'),
            'created_at' => Yii::t('biDashboard', 'Created At'),
            'updated_at' => Yii::t('biDashboard', 'Updated At'),
            'deleted_at' => Yii::t('biDashboard', 'Deleted At'),
            'updated_by' => Yii::t('biDashboard', 'Updated By'),
            'created_by' => Yii::t('biDashboard', 'Created By'),
        ];
    }

    public function validateFloorOrCeiling($attribute, $params)
    {
        if (!$this->hasErrors()) {
            if (empty($this->floor) && empty($this->ceiling) || $this->floor == '' && $this->ceiling == '') {
                return $this->addError('floor', 'حداقل یکی از مقادیر کف یا سقف باید وارد شوند.');
            }
        }
    }

    public function validateUniqueWidgetFieldCombination($attribute, $params)
    {
        if (!$this->hasErrors()) {

            $query = self::find()
                ->where(['widget_id' => $this->widget_id])
                ->andWhere(['widget_field' => $this->widget_field]);

            if (!empty($this->id) && $this->id != null) {
                $query->andWhere(['!=', 'id', $this->id]);
            }

            $exists = $query->exists();

            if ($exists) {
                $this->addError($attribute, 'ترکیب ویجت و فیلد خروجی ویجت باید منحصر به فرد باشد.');
            }
        }
    }

    public function validateUsersRequired($attribute, $params)
    {
        if (in_array($this->notification_type, [self::NOTIFICATION_SMS, self::NOTIFICATION_EMAIL, self::NOTIFICATION_BOTH])) {
            if (!is_array($this->$attribute) || count($this->$attribute) === 0) {
                return $this->addError('users', 'حداقل یک کاربر را باید انتخاب کنید.');
            }
        }
    }

    public function canDelete()
    {
        return true;
    }

    public function getWidget()
    {
        return $this->hasOne(ReportWidget::class, ['id' => 'widget_id']);
    }

    public function getAlertUsers()
    {
        return $this->hasMany(ReportAlertUser::class, ['alert_id' => 'id']);
    }

    public function usersList(): array
    {
        $userIds = [];
        foreach ($this->alertUsers as $user)
        {
            $userIds[] = $user->user_id;
        }

        return array_unique($userIds);
    }

    public static function find()
    {
        $query = new ReportAlertQuery(get_called_class());
        return $query->bySlaveId()->notDeleted();
    }

    /**
    [
        0 => [
            'id' => 16
            'widget_id' => 75
            'widget_field' => 'profit_or_loss'
        ]
        1 => [
            'id' => 22
            'widget_id' => 116
            'widget_field' => 'profit_or_loss'
        ]

    ]
    ****/
    public static function boxAlerts(int $boxId)
    {
        $boxWidgets = ReportBoxWidgets::find()
            ->select(['widget_id', 'widget_field'])
            ->where(['box_id' => $boxId])
            ->asArray()
            ->all();

        $conditions = [];
        foreach ($boxWidgets as $boxWidget) {
            $conditions[] = ['and',
                ['widget_id' => $boxWidget['widget_id']],
                ['widget_field' => $boxWidget['widget_field']]
            ];
        }

        $boxWidgetsAlerts = self::find()
            ->select(['id', 'widget_id', 'widget_field'])
            ->where(['or', ...$conditions])
            ->asArray()
            ->all();

        return $boxWidgetsAlerts;
    }

    public static function checkForAlert(int $boxId, int $widgetId, string $widgetField, int $widgetResultId, array $widgetResults)
    {
        $alerts = self::find()
            ->widgetAlerts($widgetId, $widgetField)
            ->all();

        $box = ReportBox::findOne($boxId);

        if (empty($alerts) || empty($widgetResults)) {
            return;
        }

        $transaction = self::getDb()->beginTransaction();

        try {
            foreach ($alerts as $alert) {

                foreach ($widgetResults as $widgetResult) {

                    // Check if the widget result is outside the alert's thresholds
                    if ($widgetResult[$alert->widget_field] > $alert->ceiling && $alert->ceiling != null
                        || $widgetResult[$alert->widget_field] < $alert->floor && $alert->floor != null)
                    {

                        $resultExist = ReportFiredAlert::firedAlertResultAlreadyExist($boxId, $widgetId, $widgetField, $widgetResult);

                        if (!$resultExist) {
                            $firedAlert = new ReportFiredAlert();
                            $firedAlert->result = $widgetResult;
                            $firedAlert->setAttributes([
                                'alert_id' => $alert->id,
                                'box_id' => $boxId,
                                'dashboard_id' => $box->dashboard->id,
                                'widget_id' => $alert->widget_id,
                                'widget_result_id' => $widgetResultId,
                                'widget_field' => $alert->widget_field,
                            ]);

                            if (!$firedAlert->save()) {
                                throw new \Exception('Failed to save FiredAlert: ' . implode(', ', $firedAlert->getFirstErrors()));
                            }
                        }
                    }
                }
            }

            $transaction->commit();
        } catch (\Throwable $e) {
            $transaction->rollBack();
            throw $e;
        }
    }

    public static function firedAlertNotificationsList(int $notificationType): array
    {
        $firingAlertIds = self::find()
            ->select(['id'])
            ->where([
                'state' => self::STATE_ALERTING
            ])
            ->andWhere(['in', 'notification_type', [$notificationType, self::NOTIFICATION_BOTH]])
            ->column();

        $alertUsers = ReportAlertUser::find()
            ->select(['user_id', 'alert_id'])
            ->distinct()
            ->where(['alert_id' => $firingAlertIds])
            ->with('alert', 'user')
            ->all();

        $notificationsArray = [];

        foreach ($alertUsers as $alertUser)
        {
            $notification = [
                'text' => $alertUser->alert->description .' (شناسه هشدار:'. $alertUser->alert->id .')',
                'model_class' => self::class,
                'model_id' => $alertUser->alert->id,
            ];

            if ($notificationType === self::NOTIFICATION_SMS)
            {
                $notification['phone_number'] = $alertUser->user->phone_number;
            }

            elseif ($notificationType === self::NOTIFICATION_EMAIL)
            {
                $notification['email'] = $alertUser->user->email;
            }

            $notificationsArray[] = $notification;
        }

        return $notificationsArray;
    }

    public static function itemAlias($type, $code = NULL)
    {
        $_items = [
            'Status' => [
                self::STATUS_ACTIVE => Yii::t('biDashboard', 'Active'),
                self::STATUS_INACTIVE => Yii::t('biDashboard', 'InActive'),
                self::STATUS_DELETED => Yii::t('biDashboard', 'Deleted'),
            ],
            'Notification' => [
                self::NOTIFICATION_NONE => Yii::t('biDashboard', 'No Notification'),
                self::NOTIFICATION_SMS => Yii::t('biDashboard', 'SMS'),
                self::NOTIFICATION_EMAIL => Yii::t('biDashboard', 'Email'),
                self::NOTIFICATION_BOTH => Yii::t('biDashboard', 'SMS & Email'),
            ],
            'Seen' => [
                self::SEEN => 'دیده شده',
                self::NOT_SEEN => 'دیده نشده',
            ],
            'State' => [
                self::STATE_NORMAL => 'عادی',
                self::STATE_ALERTING => 'هشدار',
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
        ];
    }
}
