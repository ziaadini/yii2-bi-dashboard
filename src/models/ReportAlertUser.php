<?php

namespace ziaadini\bidashboard\models;

use ziaadini\bidashboard\helpers\FormatHelper;
use ziaadini\bidashboard\traits\AjaxValidationTrait;
use yii2tech\ar\softdelete\SoftDeleteBehavior;
use ziaadini\bidashboard\traits\CoreTrait;
use yii\behaviors\BlameableBehavior;
use yii\behaviors\TimestampBehavior;
use yii\db\ActiveRecord;
use Yii;

/**
 * This is the model class for table "report_dashboard_widget".
 *
 * @property int $id
 * @property int $slave_id
 * @property int $alert_id
 * @property int $user_id
 * @property int $status
 * @property int $created_at
 * @property int $updated_at
 * @property int $deleted_at
 * @property int|null $updated_by
 * @property int|null $created_by
 *
 * @property ReportUser $user
 * @property ReportAlert $alert
 */

class ReportAlertUser extends ActiveRecord
{
    use AjaxValidationTrait;
    use CoreTrait;

    const STATUS_DELETED = 0;
    const STATUS_ACTIVE = 1;
    const STATUS_INACTIVE = 2;

    public static function getDb()
    {
        return Yii::$app->biDB;
    }

    public static function tableName()
    {
        return '{{%report_alert_user}}';
    }

    public function rules()
    {
        return [
            [['slave_id'], 'default', 'value' => function () {
                return Yii::$app->params['bi_slave_id'] ?? null;
            }],
            [['alert_id', 'user_id', 'slave_id'], 'required'],
            [['alert_id', 'user_id', 'status', 'slave_id', 'id'], 'integer'],
            [['alert_id'], 'exist', 'skipOnError' => true, 'targetClass' => ReportAlert::class, 'targetAttribute' => ['alert_id' => 'id']],
            [['user_id'], 'exist', 'skipOnError' => true, 'targetClass' => ReportUser::class, 'targetAttribute' => ['user_id' => 'id']],
        ];
    }

    public function attributeLabels()
    {
        return [
            'id' => Yii::t('biDashboard', 'ID'),
            'alert_id' => Yii::t('biDashboard', 'Alert'),
            'user_id' => Yii::t('biDashboard', 'User'),
            'status' => Yii::t('biDashboard', 'Status'),
            'created_at' => Yii::t('biDashboard', 'Created At'),
            'updated_at' => Yii::t('biDashboard', 'Updated At'),
            'deleted_at' => Yii::t('biDashboard', 'Deleted At'),
            'updated_by' => Yii::t('biDashboard', 'Updated By'),
            'created_by' => Yii::t('biDashboard', 'Created By'),
        ];
    }

    /**
     *
     * @return \yii\db\ActiveQuery|ReportUserxQuery
     */
    public function getUser()
    {
        return $this->hasOne(ReportUser::class, ['id' => 'user_id']);
    }

    /**
     * Gets query for [[alert]].
     *
     * @return \yii\db\ActiveQuery|ReportAlertQuery
     */
    public function getAlert()
    {
        return $this->hasOne(ReportAlert::class, ['id' => 'alert_id']);
    }

    /**
     * {@inheritdoc}
     * @return ReportAlertUserQuery the active query used by this AR class.
     */
    public static function find()
    {
        $query = new ReportAlertUserQuery(get_called_class());
        return $query->bySlaveId()->notDeleted();
    }

    public function canDelete()
    {
        return true;
    }

    public static function softDeleteAll($condition = null, $params = [])
    {
        $attributes = [
            'deleted_at' => time(),
            'status' => self::STATUS_DELETED,
        ];

        return static::updateAll($attributes, $condition, $params);
    }

    public static function itemAlias($type, $code = NULL)
    {
        $data = [];
        $_items = [
            'Status' => [
                self::STATUS_ACTIVE => Yii::t('biDashboard', 'Active'),
                self::STATUS_DELETED => Yii::t('biDashboard', 'Deleted'),
                self::STATUS_INACTIVE => Yii::t('biDashboard', 'InActive')
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
                'invokeDeleteEvents' => false
            ],
        ];
    }
}
