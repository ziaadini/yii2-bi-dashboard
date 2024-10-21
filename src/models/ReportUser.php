<?php

namespace ziaadini\bidashboard\models;

use yii\behaviors\BlameableBehavior;
use yii\behaviors\TimestampBehavior;
use yii\db\ActiveRecord;
use yii2tech\ar\softdelete\SoftDeleteBehavior;
use Yii;
use ziaadini\bidashboard\traits\CoreTrait;

/**
 * This is the model class for table "report_dashboard".
 *
 * @property int $id
 * @property int $slave_id
 * @property string $first_name
 * @property string $last_name
 * @property string $phone_number
 * @property string $email
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

class ReportUser extends ActiveRecord
{
    use CoreTrait;

    const STATUS_ACTIVE = 1;
    const STATUS_DELETED = 0;
    const STATUS_INACTIVE = 2;

    public static function getDb()
    {
        return Yii::$app->noSlaveBiDB ?? Yii::$app->biDB;
    }

    public static function tableName()
    {
        return '{{%report_user}}';
    }

    public function rules()
    {
        return [
            [['slave_id'], 'default', 'value' => function () {
                return Yii::$app->params['bi_slave_id'] ?? null;
            }],
            [['first_name', 'last_name', 'phone_number', 'email', 'slave_id'], 'required'],
            [['status', 'created_at', 'updated_at', 'deleted_at', 'updated_by', 'created_by', 'slave_id'], 'integer'],
            [['first_name', 'last_name', 'phone_number', 'email'], 'string', 'max' => 64],
            ['email', 'email'],
        ];
    }

    public function attributeLabels()
    {
        return [
            'id' => Yii::t('biDashboard', 'ID'),
            'first_name' => Yii::t('biDashboard', 'First Name'),
            'last_name' => Yii::t('biDashboard', 'Last Name'),
            'phone_number' => Yii::t('biDashboard', 'Phone Number'),
            'email' => Yii::t('biDashboard', 'Email'),
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

    public function fullName()
    {
        return $this->first_name .' '. $this->last_name;
    }

    public static function find()
    {
        $query = new ReportUserQuery(get_called_class());
        return $query->bySlaveId()->notDeleted();
    }

    public static function itemAlias($type, $code = NULL)
    {
        $_items = [
            'Status' => [
                self::STATUS_ACTIVE => Yii::t('biDashboard', 'Active'),
                self::STATUS_INACTIVE => Yii::t('biDashboard', 'InActive'),
                self::STATUS_DELETED => Yii::t('biDashboard', 'Deleted'),
            ]
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
