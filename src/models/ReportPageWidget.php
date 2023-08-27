<?php

namespace sadi01\bidashboard\models;

use Yii;
use yii\behaviors\BlameableBehavior;
use yii\behaviors\TimestampBehavior;
use yii\db\ActiveRecord;
use yii2tech\ar\softdelete\SoftDeleteBehavior;

/**
 * This is the model class for table "report_page_widget".
 *
 * @property int $id
 * @property int $bi_client_id
 * @property int $page_id
 * @property int $widget_id
 * @property string|null $report_widget_field
 * @property int|null $report_widget_field_format
 * @property int $status
 * @property int $created_at
 * @property int $updated_at
 * @property int $deleted_at
 * @property int|null $updated_by
 * @property int|null $created_by
 *
 * @property ReportPage $page
 * @property ReportWidget $widget
 */
class ReportPageWidget extends ActiveRecord
{
    const STATUS_ACTIVE = 1;
    const STATUS_DELETED = 0;
    const STATUS_INACTIVE = 2;
    const FORMAT_NUMBER = 1;
    const FORMAT_CURRENCY = 2;

    public static function getDb()
    {
        return Yii::$app->biDB;
    }

    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return '{{%report_page_widget}}';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['bi_client_id'], 'default', 'value' => Yii::$app->params['bi_client_id']],
            [['page_id', 'widget_id', 'report_widget_field', 'bi_client_id'], 'required'],
            [['page_id', 'widget_id', 'report_widget_field_format', 'status', 'bi_client_id'], 'integer'],
            [['report_widget_field'], 'string', 'max' => 64],
            [['page_id'], 'exist', 'skipOnError' => true, 'targetClass' => ReportPage::class, 'targetAttribute' => ['page_id' => 'id']],
            [['widget_id'], 'exist', 'skipOnError' => true, 'targetClass' => ReportWidget::class, 'targetAttribute' => ['widget_id' => 'id']],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => Yii::t('biDashboard', 'ID'),
            'page_id' => Yii::t('biDashboard', 'Page ID'),
            'widget_id' => Yii::t('biDashboard', 'Widget'),
            'report_widget_field' => Yii::t('biDashboard', 'Report Widget Field'),
            'report_widget_field_format' => Yii::t('biDashboard', 'Report Widget Field Format'),
            'status' => Yii::t('biDashboard', 'Status'),
            'created_at' => Yii::t('biDashboard', 'Created At'),
            'updated_at' => Yii::t('biDashboard', 'Updated At'),
            'deleted_at' => Yii::t('biDashboard', 'Deleted At'),
            'updated_by' => Yii::t('biDashboard', 'Updated By'),
            'created_by' => Yii::t('biDashboard', 'Created By'),
        ];
    }

    /**
     * Gets query for [[Page]].
     *
     * @return \yii\db\ActiveQuery|ReportPageQuery
     */
    public function getPage()
    {
        return $this->hasOne(ReportPage::class, ['id' => 'page_id']);
    }

    /**
     * Gets query for [[Widget]].
     *
     * @return \yii\db\ActiveQuery|ReportWidgetQuery
     */
    public function getWidget()
    {
        return $this->hasOne(ReportWidget::class, ['id' => 'widget_id']);
    }

    public function canDelete()
    {
        return true;
    }

    /**
     * {@inheritdoc}
     * @return ReportPageWidgetQuery the active query used by this AR class.
     */
    public static function find()
    {
        $query = new ReportPageWidgetQuery(get_called_class());
        $query->byClentId();
        $query->notDeleted();
        return $query;
    }

    public static function itemAlias($type, $code = NULL)
    {
        $_items = [
            'Status' => [
                self::STATUS_DELETED => Yii::t('biDashboard', 'DELETED'),
                self::STATUS_ACTIVE => Yii::t('biDashboard', 'ACTIVE'),
                self::STATUS_INACTIVE => Yii::t('biDashboard', 'INACTIVE'),
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
            ],];
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
