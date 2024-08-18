<?php

namespace ziaadini\bidashboard\models;

use ziaadini\bidashboard\traits\CoreTrait;
use Yii;
use yii\db\ActiveRecord;
use yii\behaviors\BlameableBehavior;
use yii\behaviors\TimestampBehavior;
use yii2tech\ar\softdelete\SoftDeleteBehavior;
use yii\db\ActiveQuery;

/**
 * This is the model class for table "{{%bid_external_data_value}}".
 *
 * @property int $id
 * @property int slave_id
 * @property int $external_data_id
 * @property float $value
 * @property int $status
 * @property int $created_at
 * @property int $created_by
 * @property int $updated_at
 * @property int $updated_by
 * @property int $deleted_at
 *
 * @property ExternalData $externalData
 *
 * @mixin SoftDeleteBehavior
 * @mixin BlameableBehavior
 * @mixin TimestampBehavior
 */
class ExternalDataValue extends ActiveRecord
{
    use CoreTrait;

    const STATUS_ACTIVE = 1;
    const STATUS_DELETED = 2;

    public static function getDb()
    {
        return Yii::$app->biDB;
    }

    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return '{{%external_data_value}}';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['slave_id'], 'default', 'value' => function () {
                return Yii::$app->params['bi_slave_id'] ?? null;
            }],
            [['external_data_id', 'value', 'slave_id'], 'required'],
            [['external_data_id', 'status', 'created_at', 'created_by', 'updated_at', 'updated_by', 'deleted_at', 'slave_id'], 'integer'],
            [['value'], 'number'],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => Yii::t('biDashboard', 'ID'),
            'external_data_id' => Yii::t('biDashboard', 'External Data ID'),
            'value' => Yii::t('biDashboard', 'Value'),
            'status' => Yii::t('biDashboard', 'Status'),
            'created_at' => Yii::t('biDashboard', 'Created At'),
            'created_by' => Yii::t('biDashboard', 'Created By'),
            'updated_at' => Yii::t('biDashboard', 'Updated At'),
            'updated_by' => Yii::t('biDashboard', 'Updated By'),
            'deleted_at' => Yii::t('biDashboard', 'Deleted At'),
        ];
    }

    /**
     * Gets query for [[ExternalData]].
     *
     * @return ActiveQuery|ExternalDataQuery
     */
    public function getExternalData()
    {
        return $this->hasOne(ExternalData::class, ['id' => 'external_data_id']);
    }

    public function beforeValidate()
    {
        $this->created_at = $this->jalaliToTimestamp($this->created_at, "Y/m/d H:i:s");
        return parent::beforeValidate();
    }

    /**
     * {@inheritdoc}
     * @return ExternalDataValueQuery the active query used by this AR class.
     */
    public static function find()
    {
        $query = new ExternalDataValueQuery(get_called_class());
        return $query->bySlaveId()->notDeleted();
    }

    public static function itemAlias($type, $code = NULL)
    {
        $_items = [
            'Status' => [
                self::STATUS_ACTIVE => Yii::t('biDashboard', 'Active'),
                self::STATUS_DELETED => Yii::t('biDashboard', 'Deleted')
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
            'TimestampBehavior' => [
                'class' => TimestampBehavior::class,
                'createdAtAttribute' => null,
                'updatedAtAttribute' => 'updated_at',
                //'value' => new Expression('NOW()'),
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
                'replaceRegularDelete' => false, // mutate native `delete()` method
                'invokeDeleteEvents' => false
            ],
        ];
    }
}
