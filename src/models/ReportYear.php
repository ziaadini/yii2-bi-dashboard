<?php

namespace sadi01\bidashboard\models;

use sadi01\bidashboard\helpers\CoreHelper;
use Yii;
use yii\behaviors\BlameableBehavior;
use yii\behaviors\TimestampBehavior;
use yii2tech\ar\softdelete\SoftDeleteBehavior;

/**
 * This is the model class for table "report_year".
 *
 * @property int $id
 * @property int $slave_id
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

    public static function getDb()
    {
        return Yii::$app->noSlaveBiDB ?? Yii::$app->biDB;
    }

    /**
     * {@inheritdoc}
     */
    public static function tableName(): string
    {
        return '{{%report_year}}';
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
            [['year', 'slave_id'], 'required'],
            [['year', 'slave_id'], 'unique', 'targetAttribute' => ['year', 'slave_id']],
            ['year', 'compare', 'operator' => '>', 'compareValue' => (int)(CoreHelper::getCurrentYear()) - 100],
            ['year', 'compare', 'operator' => '<', 'compareValue' => (int)(CoreHelper::getCurrentYear()) + 100],
            [['year', 'created_at', 'created_by', 'updated_at', 'updated_by', 'deleted_at', 'slave_id'], 'integer'],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels(): array
    {
        return [
            'id' => Yii::t('biDashboard', 'ID'),
            'year' => Yii::t('biDashboard', 'Year'),
            'status' => Yii::t('biDashboard', 'Status'),
            'created_at' => Yii::t('biDashboard', 'Created At'),
            'created_by' => Yii::t('biDashboard', 'Created By'),
            'updated_at' => Yii::t('biDashboard', 'Updated At'),
            'updated_by' => Yii::t('biDashboard', 'Updated By'),
            'deleted_at' => Yii::t('biDashboard', 'Deleted At'),
            'status' => Yii::t('biDashboard', 'Status'),
        ];
    }

    public function canDelete(): bool
    {
        return true;
    }

    /**
     * {@inheritdoc}
     * @return ReportYearQuery the active query used by this AR class.
     */
    public static function find(): ReportYearQuery
    {
        $query = new ReportYearQuery(get_called_class());
        return $query->bySlaveId()->notDeleted();
    }

    public static function itemAlias($type, $code = NULL)
    {
        $data = [];
        if ($type == 'List') {
            $data = self::find()->select(['year'])->column();
        }

        $_items = [
            'Status' => [
                self::STATUS_DELETED => Yii::t('biDashboard', 'DELETED'),
                self::STATUS_ACTIVE => Yii::t('biDashboard', 'ACTIVE'),
            ],
            'StatusClass' => [
                self::STATUS_DELETED => 'danger',
                self::STATUS_ACTIVE => 'success',
            ],
            'StatusColor' => [
                self::STATUS_DELETED => '#ff5050',
                self::STATUS_ACTIVE => '#04AA6D',
            ],
            'List' => $data
        ];
        if (isset($code))
            return isset($_items[$type][$code]) ? $_items[$type][$code] : false;
        else
            return isset($_items[$type]) ? $_items[$type] : false;
    }

    public function behaviors(): array
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