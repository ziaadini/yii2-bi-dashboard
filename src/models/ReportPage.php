<?php

namespace sadi01\bidashboard\models;

use Yii;
use yii\behaviors\BlameableBehavior;
use yii\behaviors\TimestampBehavior;
use yii\db\ActiveQuery;
use yii\db\ActiveRecord;
use yii2tech\ar\softdelete\SoftDeleteBehavior;

/**
 * This is the model class for table "report_page".
 *
 * @property int $id
 * @property int $slave_id
 * @property string $title
 * @property int $status
 * @property int|null $range_type
 * @property string|null $add_on
 * @property int $created_at
 * @property int $updated_at
 * @property int $deleted_at
 * @property int|null $updated_by
 * @property int|null $created_by
 *
 * @property ReportPageWidget $reportPageWidgets
 * @property ReportWidget[] $widgets
 *
 * @mixin SoftDeleteBehavior
 */
class ReportPage extends ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    const STATUS_ACTIVE = 1;
    const STATUS_DELETED = 0;
    const STATUS_INACTIVE = 2;
    const RANGE_DAY = 1;
    const RANGE_MONTH = 2;

    const FORMAT_NUMBER = 1;
    const FORMAT_CURRENCY = 2;
    const FORMAT_GRAM = 3;
    const FORMAT_KILOGRAM= 4;

    public static function getDb()
    {
        return Yii::$app->biDB;
    }

    public static function tableName()
    {
        return '{{%report_page}}';
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
            [['title', 'slave_id'], 'required'],
            [['status', 'range_type', 'created_at', 'updated_at', 'deleted_at', 'updated_by', 'created_by', 'slave_id'], 'integer'],
            [['add_on'], 'safe'],
            [['title'], 'string', 'max' => 128]
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
            'range_type' => Yii::t('biDashboard', 'Range Type'),
            'add_on' => Yii::t('biDashboard', 'Add On'),
            'created_at' => Yii::t('biDashboard', 'Created At'),
            'updated_at' => Yii::t('biDashboard', 'Updated At'),
            'deleted_at' => Yii::t('biDashboard', 'Deleted At'),
            'updated_by' => Yii::t('biDashboard', 'Updated By'),
            'created_by' => Yii::t('biDashboard', 'Created By'),
            'report_widget_field_format' => Yii::t('biDashboard', 'Report Widget Field Format'),
        ];
    }

    /**
     * Gets query for [[ReportPageWidgets]].
     *
     * @return ActiveQuery|ReportPageWidgetQuery
     */
    public function getReportPageWidgets()
    {
        return $this->hasMany(ReportPageWidget::class, ['page_id' => 'id'])->orderBy('display_order');
    }

    public function getWidgets()
    {
        return $this->hasMany(ReportWidget::class, ['id' => 'widget_id'])->via('reportPageWidgets');
    }

    public function getSharingKeys()
    {
        return $this->hasMany(SharingPage::class, ['page_id' => 'id']);
    }

    public function afterDelete()
    {
        $sharingKeys = $this->sharingKeys;
        foreach ($sharingKeys as $value) {
            $value->softDelete();
        }
        return parent::afterDelete();
    }

    public function canDelete()
    {
        return true;
    }

    /**
     * {@inheritdoc}
     * @return ReportPageQuery the active query used by this AR class.
     */
    public static function find()
    {
        $query = new ReportPageQuery(get_called_class());
        return $query->bySlaveId()->notDeleted();
    }

    public static function itemAlias($type, $code = NULL)
    {
        $_items = [
            'RangeType' => [
                self::RANGE_DAY => Yii::t('biDashboard', 'روزانه'),
                self::RANGE_MONTH => Yii::t('biDashboard', 'ماهانه'),
            ],
            'Format' => [
                self::FORMAT_CURRENCY => Yii::t('biDashboard', 'Currency'),
                self::FORMAT_NUMBER => Yii::t('biDashboard', 'Number'),
                self::FORMAT_GRAM => Yii::t('biDashboard', 'Gram'),
                self::FORMAT_KILOGRAM => Yii::t('biDashboard', 'Kilo Gram'),
            ],
            'Status' => [
                self::STATUS_ACTIVE => Yii::t('biDashboard', 'Active'),
                self::STATUS_INACTIVE => Yii::t('biDashboard', 'InActive'),
                self::STATUS_DELETED => Yii::t('biDashboard', 'Deleted'),
            ],
            'StatusClass' => [
                self::STATUS_DELETED => 'danger',
                self::STATUS_ACTIVE => 'success',
                self::STATUS_INACTIVE => 'warning',
            ],
            'StatusColor' => [
                self::STATUS_DELETED => '#ff5050',
                self::STATUS_ACTIVE => '#04AA6D',
                self::STATUS_INACTIVE => '#eea236',
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