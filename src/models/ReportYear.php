<?php

namespace sadi01\bidashboard\models;

use sadi01\bidashboard\behaviors\Jsonable;
use Yii;
use yii\behaviors\BlameableBehavior;
use yii\behaviors\TimestampBehavior;
use yii2tech\ar\softdelete\SoftDeleteBehavior;

/**
 * This is the model class for table "report_year".
 *
 * @property int $id
 * @property int $year
 * @property int $created_at
 * @property int|null $created_by
 * @property int $updated_at
 * @property int|null $updated_by
 * @property int $deleted_at
 *
 * @mixin SoftDeleteBehavior
 * @mixin BlameableBehavior
 * @mixin TimestampBehavior
 */
class ReportYear extends \yii\db\ActiveRecord
{

    const STATUS_ACTIVE = 1;
    const STATUS_DELETED = 0;
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'report_year';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['year'], 'required'],
            [['year'], 'unique'],
            [['year', 'created_at', 'created_by', 'updated_at', 'updated_by', 'deleted_at'], 'integer'],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => Yii::t('biDashboard', 'ID'),
            'year' => Yii::t('biDashboard', 'Year'),
            'created_at' => Yii::t('biDashboard', 'Created At'),
            'created_by' => Yii::t('biDashboard', 'Created By'),
            'updated_at' => Yii::t('biDashboard', 'Updated At'),
            'updated_by' => Yii::t('biDashboard', 'Updated By'),
            'deleted_at' => Yii::t('biDashboard', 'Deleted At'),
        ];
    }

    /**
     * {@inheritdoc}
     * @return ReportYearQuery the active query used by this AR class.
     */
    public static function find()
    {
        $query = new ReportYearQuery(get_called_class());
        $query->notDeleted();
        return $query;
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
                'replaceRegularDelete' => false, // mutate native `delete()` method
                'invokeDeleteEvents' => false
            ],
        ];
    }
}