<?php

namespace sadi01\bidashboard\models;

use sadi01\bidashboard\helpers\CoreHelper;
use sadi01\bidashboard\traits\AjaxValidationTrait;
use sadi01\bidashboard\traits\CoreTrait;
use yii\base\Widget;
use yii\behaviors\BlameableBehavior;
use yii\behaviors\TimestampBehavior;
use yii\db\ActiveRecord;
use yii\helpers\ArrayHelper;
use yii2tech\ar\softdelete\SoftDeleteBehavior;
use Yii;


/**
 * This is the model class for table "report_dashboard_widget".
 *
 * @property int $id
 * @property int $slave_id
 * @property int $dashboard_id
 * @property int $widget_id
 * @property int $display_type
 * @property int|null $chart_type
 * @property int $status
 * @property int widget_field_format
 * @property int $created_at
 * @property int $updated_at
 * @property int $deleted_at
 * @property int|null $updated_by
 * @property int|null $created_by
 *
 * @property ReportDashboard $dashboard
 * @property ReportWidget $widget
 */
class ReportDashboardWidget extends ActiveRecord
{
    use AjaxValidationTrait;
    use CoreTrait;

    const STATUS_DELETED = 0;
    const STATUS_ACTIVE = 1;
    const STATUS_INACTIVE = 2;

    const DISPLAY_CHART = 1;
    const DISPLAY_TABLE = 2;
    const DISPLAY_CARD = 3;

    const CHART_LINE = 1;
    const CHART_COLUMN = 2;
    const CHART_PIE = 3;
    const CHART_AREA = 4;
    const CHART_WORD_CLOUD = 5;

    const FORMAT_NUMBER = 1;
    const FORMAT_CURRENCY = 2;

    const SCENARIO_CREATE = 'create';
    const SCENARIO_UPDATE = 'update';

    const VALID = 1;
    const IN_VALID = 0;

    public $title;
    public $description;
    public $rangeType;
    public $isValid;
    public $rangeDateCount;
    public $results = [];

    public $cardResultCount;

    public static function getDb()
    {
        return Yii::$app->biDB;
    }

    public static function tableName()
    {
        return '{{%report_dashboard_widget}}';
    }

    public function rules()
    {
        return [
            [['slave_id'], 'default', 'value' => function () {
                return Yii::$app->params['bi_slave_id'] ?? null;
            }],
            /*[['widget_id', 'display_type', 'widget_field'], 'required', 'on' => self::SCENARIO_CREATE],
            [['widget_id', 'display_type', 'widget_field', 'widget_field_format'], 'required', 'on' => self::SCENARIO_UPDATE],*/
            [['widget_id', 'display_type', 'widget_field', 'widget_field_format'], 'required'],
            ['chart_type', 'required', 'when' => function($model) {
                return $model->display_type == self::DISPLAY_CHART;
            }],
            [['widget_field'], 'string', 'max' => 64],
            [['dashboard_id', 'widget_id', 'widget_field_format', 'status', 'display_type', 'chart_type', 'slave_id', 'id'], 'integer'],
            [['dashboard_id'], 'exist', 'skipOnError' => true, 'targetClass' => ReportDashboard::class, 'targetAttribute' => ['dashboard_id' => 'id']],
            [['widget_id'], 'exist', 'skipOnError' => true, 'targetClass' => ReportWidget::class, 'targetAttribute' => ['widget_id' => 'id']],
        ];
    }


    public function attributeLabels()
    {
        return [
            'id' => Yii::t('biDashboard', 'ID'),
            'dashboard_id' => Yii::t('biDashboard', 'Dashboard ID'),
            'widget_id' => Yii::t('biDashboard', 'Widget'),
            'widget_field' => Yii::t('biDashboard', 'Report Widget Field'),
            'widget_field_format' => Yii::t('biDashboard', 'Report Widget Field Format'),
            'display_type' => Yii::t('biDashboard', 'Display Type'),
            'chart_type' => Yii::t('biDashboard', 'Chart Type'),
            'status' => Yii::t('biDashboard', 'Status'),
            'created_at' => Yii::t('biDashboard', 'Created At'),
            'updated_at' => Yii::t('biDashboard', 'Updated At'),
            'deleted_at' => Yii::t('biDashboard', 'Deleted At'),
            'updated_by' => Yii::t('biDashboard', 'Updated By'),
            'created_by' => Yii::t('biDashboard', 'Created By'),
        ];
    }

    public static function getFormattedValue($format, $value)
    {
        return match ($format) {
            self::FORMAT_NUMBER => Yii::$app->formatter->asInteger($value),
            self::FORMAT_CURRENCY => Yii::$app->formatter->asCurrency($value),
            default => null,
        };
    }

    /**
     *
     * @return \yii\db\ActiveQuery|ReportDashboardQuery
     */
    public function getDashboard()
    {
        return $this->hasOne(ReportDashboard::class, ['id' => 'dashboard_id']);
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
     * @return ReportDashboardWidgetQuery the active query used by this AR class.
     */
    public static function find()
    {
        $query = new ReportDashboardWidgetQuery(get_called_class());
        return $query->bySlaveId()->notDeleted();
    }

    //TODO: must be enhanced!
    public static function getRandomCardClass()
    {
        $classes = ['bg-primary', 'bg-success', 'bg-secondary', 'bg-danger', 'bg-info', 'bg-warning'];

        $randomKey = array_rand($classes);
        return $classes[$randomKey];

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
            'DisplayTypes' => [
                self::DISPLAY_CHART => Yii::t('biDashboard', 'Chart'),
                self::DISPLAY_TABLE => Yii::t('biDashboard', 'Table'),
                self::DISPLAY_CARD => Yii::t('biDashboard', 'Card'),
            ],
            'ChartTypes' => [
                self::CHART_LINE => 'line',
                self::CHART_COLUMN => 'column',
                self::CHART_PIE => 'pie',
                self::CHART_AREA => 'area',
                self::CHART_WORD_CLOUD => 'worldcloud',
            ],
            'ChartNames' => [
                self::CHART_LINE => Yii::t('biDashboard', 'Chart line'),
                self::CHART_COLUMN => Yii::t('biDashboard', 'Chart column'),
                self::CHART_PIE => Yii::t('biDashboard', 'Chart pie'),
                self::CHART_AREA => Yii::t('biDashboard', 'Chart area'),
                self::CHART_WORD_CLOUD => Yii::t('biDashboard', 'Chart world cloud'),
            ],
            'Format' => [
                self::FORMAT_CURRENCY => Yii::t('biDashboard', 'Currency'),
                self::FORMAT_NUMBER => Yii::t('biDashboard', 'Number'),
            ],
            'List' => $data,
        ];

        if (isset($code))
            return isset($_items[$type][$code]) ? $_items[$type][$code] : false;
        else
            return isset($_items[$type]) ? $_items[$type] : false;
    }

    public function setWidgetProperties() {

        $this->title = $this->widget->title;
        $this->description = $this->widget->description;
        $this->rangeType = $this->widget->range_type;
        $this->rangeDateCount = 12;
        $this->cardResultCount = 0;
        $this->isValid = self::VALID;

    }

    public function getStartAndEndArray($widget, $year, $month, $day) : array
    {
        if ($widget->rangeType == ReportWidget::RANGE_TYPE_DAILY) {

            if ($widget->display_type == self::DISPLAY_CARD){
                $date_array = CoreHelper::getStartAndEndOfDay(time: $this->jalaliToTimestamp($year.'/'.$month.'/'.$day.' 00:00:00'));
            }
            else {
                $date_array = $this->getStartAndEndOfMonth($year . '/' . $month);
                //check below
                $widget->rangeDateCount = count($this->getMonthDays($year . '/' . $month));
            }
        }
        elseif ($widget->rangeType == ReportWidget::RANGE_TYPE_MONTHLY) {

            if ($widget->display_type == self::DISPLAY_CARD) {
                $date_array = $this->getStartAndEndOfMonth($year . '/' . $month);
            }
            else {
                $date_array = $this->getStartAndEndOfYear($year);
            }
        }

        return $date_array;
    }

    public function collectResults($widget, $results) {
        if ($widget->display_type == self::DISPLAY_CARD){
            foreach ($results as $result){
                if (isset($result[$widget->widget_field]))
                    $widget->cardResultCount += $result[$widget->widget_field];
                else
                    $widget->isValid = self::IN_VALID;
            }
        }
        else {
            $widget->results['data'] = array_map(function ($item) use ($widget) {
                return (int)$item[$widget->widget_field];
            }, $results);

            $widget->results['categories'] = array_map(function ($item) use ($widget) {
                if ($widget->rangeType == ReportWidget::RANGE_TYPE_DAILY) {
                    return $item["day"];
                } else {
                    return $item["month_name"];
                }
            }, $results);

            $widget->results['combine'] = array_combine($widget->results['categories'], $widget->results['data']);
        }
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