<?php

namespace sadi01\bidashboard\models;

use sadi01\bidashboard\traits\CoreTrait;
use Yii;
use yii\behaviors\BlameableBehavior;
use yii\behaviors\TimestampBehavior;
use yii\db\ActiveQuery;
use yii\db\ActiveRecord;
use yii2tech\ar\softdelete\SoftDeleteBehavior;

/**
 * This is the model class for table "external_data".
 *
 * @property int $id
 * @property int $slave_id
 * @property string $title
 * @property int $status
 * @property int $created_at
 * @property int $created_by
 * @property int $updated_at
 * @property int $updated_by
 * @property int $deleted_at
 *
 * @property ExternalDataValue[] $externalDataValues
 *
 * @mixin SoftDeleteBehavior
 * @mixin BlameableBehavior
 * @mixin TimestampBehavior
 */
class ExternalData extends ActiveRecord
{
    use CoreTrait;

    const STATUS_ACTIVE = 1;
    const STATUS_DELETED = 2;

    /**
     * {@inheritdoc}
     */

    public static function getDb()
    {
        return Yii::$app->biDB;
    }

    public static function tableName()
    {
        return '{{%external_data}}';
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
            [['title','slave_id'], 'required'],
            [['status', 'created_at', 'created_by', 'updated_at', 'updated_by', 'deleted_at', 'slave_id'], 'integer'],
            [['title'], 'string', 'max' => 128],
        ];
    }


    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => Yii::t('biDashboard', 'ID'),
            'title' => Yii::t('biDashboard', 'Title'),
            'status' => Yii::t('biDashboard', 'Status'),
            'created_at' => Yii::t('biDashboard', 'Created At'),
            'created_by' => Yii::t('biDashboard', 'Created By'),
            'updated_at' => Yii::t('biDashboard', 'Updated At'),
            'updated_by' => Yii::t('biDashboard', 'Updated By'),
            'deleted_at' => Yii::t('biDashboard', 'Deleted At'),
        ];
    }

    /**
     * Gets query for [[BidExternalDataValues]].
     *
     * @return ActiveQuery|ExternalDataValueQuery
     */
    public function getExternalDataValues()
    {
        return $this->hasMany(ExternalDataValue::class, ['external_data_id' => 'id']);
    }

    public function beforeValidate()
    {
        if ($this->isNewRecord) {
            $this->created_at = $this->jalaliToTimestamp($this->created_at, "Y/m/d H:i:s");
        }
        return parent::beforeValidate();
    }

    public function afterDelete()
    {
        foreach ($this->externalDataValues as $value) {
            $value->softDelete();
        }
        return parent::afterDelete();
    }

    /**
     * {@inheritdoc}
     * @return ExternalDataQuery the active query used by this AR class.
     */
    public static function find()
    {
        $query = new ExternalDataQuery(get_called_class());
        return $query->bySlaveId()->notDeleted();
    }

    public static function itemAlias($type, $code = NULL)
    {
        $_items = [
            'Status' => [
                self::STATUS_ACTIVE => Yii::t('biDashboard', 'Active'),
                self::STATUS_DELETED => Yii::t('biDashboard', 'Deleted'),
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