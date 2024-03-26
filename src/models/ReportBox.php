<?php

namespace sadi01\bidashboard\models;

use sadi01\bidashboard\helpers\CoreHelper;
use sadi01\bidashboard\traits\AjaxValidationTrait;
use sadi01\bidashboard\traits\CoreTrait;
use yii\behaviors\BlameableBehavior;
use yii\behaviors\TimestampBehavior;
use sadi01\bidashboard\models\ReportBoxWidgets;
use yii\db\ActiveRecord;
use yii2tech\ar\softdelete\SoftDeleteBehavior;
use Yii;

/**
 * This is the model class for table "report_dashboard".
 *
 * @property int $id
 * @property int $display_order
 * @property int $slave_id
 * @property string $title
 * @property string $description
 * @property int $dashboard_id
 * @property int $display_type
 * @property int $chart_type
 * @property int $range_type
 * @property int $date_type
 * @property int $last_run
 * @property int $last_date_set
 * @property int $status
 * @property int $created_at
 * @property int $updated_at
 * @property int $deleted_at
 * @property int $updated_by
 * @property int $created_by
 *
 * @property ReportBoxWidgets $boxWidgets
*
 * @mixin SoftDeleteBehavior
*/


class ReportBox extends ActiveRecord
{
    use AjaxValidationTrait;
    use CoreTrait;

    const STATUS_ACTIVE = 1;
    const STATUS_DELETED = 0;
    const STATUS_INACTIVE = 2;

    const SCENARIO_DEFAULT = 'default';
    const SCENARIO_CREATE = 'create';
    const SCENARIO_UPDATE = 'update';

    const DISPLAY_CARD = 1;
    const DISPLAY_CHART = 2;
    const DISPLAY_TABLE = 3;

    const DATE_TYPE_FLEXIBLE = 0;
    const DATE_TYPE_TODAY = 1;
    const DATE_TYPE_YESTERDAY = 2;
    const DATE_TYPE_THIS_WEEK = 3;
    const DATE_TYPE_LAST_WEEK = 4;
    const DATE_TYPE_THIS_MONTH = 5;
    const DATE_TYPE_LAST_MONTH = 6;
    const DATE_TYPE_THIS_YEAR = 7;
    const DATE_TYPE_LAST_YEAR = 8;

    const CHART_LINE = 1;
    const CHART_COLUMN = 2;
    const CHART_PIE = 3;
    const CHART_AREA = 4;
    const CHART_WORD_CLOUD = 5;

    const FORMAT_NUMBER = 1;
    const FORMAT_CURRENCY = 2;

    public $chartCategories = [];
    public $chartSeries = [];
    public $rangeDateCount = 12;
    public $lastRun = [];
    public $lastDateSet = [];

    const RANGE_TYPE_DAILY = 1;
    const RANGE_TYPE_MONTHLY = 2;

    public static function getDb()
    {
        return Yii::$app->noSlaveBiDB ?? Yii::$app->biDB;
    }

    public static function tableName()
    {
        return '{{%report_box}}';
    }

    public function rules()
    {
        return [
            [['slave_id'], 'default', 'value' => function () {
                return Yii::$app->params['bi_slave_id'] ?? null;
            }],
            [['dashboard_id', 'display_type', 'range_type', 'title', 'date_type', 'slave_id'], 'required', 'on' => self::SCENARIO_CREATE],
            [['dashboard_id', 'display_type', 'title', 'slave_id'], 'required', 'on' => self::SCENARIO_UPDATE],
            [['title'], 'string', 'max' => 128],
            [['description'], 'string', 'max' => 255],
            ['chart_type', 'required', 'when' => function($model) {
                return $model->display_type == self::DISPLAY_CHART;
            }],
            [['dashboard_id'], 'exist', 'skipOnError' => true, 'targetClass' => ReportDashboard::class, 'targetAttribute' => ['dashboard_id' => 'id']],
            [['display_order', 'dashboard_id', 'display_type', 'date_type', 'chart_type', 'status', 'created_at', 'updated_at', 'deleted_at', 'updated_by', 'created_by', 'slave_id'], 'integer'],
        ];
    }

    public function scenarios()
    {
        return [
            self::SCENARIO_DEFAULT => ['display_order', 'dashboard_id', 'display_type', 'range_type', 'title', 'description', 'slave_id', 'chart_type'],
            self::SCENARIO_CREATE => ['display_order', 'date_type', 'dashboard_id', 'display_type', 'range_type', 'title', 'description', 'slave_id', 'chart_type'],
            self::SCENARIO_UPDATE => ['display_order', 'dashboard_id', 'display_type', 'title', 'description', 'slave_id', 'chart_type'],
        ];
    }

    //beforeSave() is overridden to calculate the maximum display_order value for the current display_type and dashboard_id
    // before a new record is saved, and then increment that value by 1.
    public function beforeSave($insert)
    {
        if (parent::beforeSave($insert)) {
            if ($this->isNewRecord) {
                $maxdisplayOrder = $this->getDisplayOrderExtreme('max');
                $this->display_order = $maxdisplayOrder !== 0 ? $maxdisplayOrder + 1 : 1;
            }
            return true;
        }
        return false;
    }

    public function beforeValidate()
    {
        if (parent::beforeValidate())
        {
            if($this->isNewRecord)
            {
                if (in_array($this->date_type, self::itemAlias('DailyDateTypes'))) {
                    $this->range_type = self::RANGE_TYPE_DAILY;
                } elseif (in_array($this->date_type, self::itemAlias('MonthlyDateTypes'))) {
                    $this->range_type = self::RANGE_TYPE_MONTHLY;
                }
            }
            return true;
        }
        return false;
    }

    public function attributeLabels()
    {
        return [
            'id' => Yii::t('biDashboard', 'ID'),
            'display_order' => Yii::t('biDashboard', 'Order'),
            'title' => Yii::t('biDashboard', 'Title'),
            'description' => Yii::t('biDashboard', 'Description'),
            'dashboard_id' => Yii::t('biDashboard', 'Dashboard ID'),
            'display_type' => Yii::t('biDashboard', 'Display Type'),
            'chart_type' => Yii::t('biDashboard', 'Chart Type'),
            'range_type' => Yii::t('biDashboard', 'Range Type'),
            'date_type' => Yii::t('biDashboard', 'Date Type'),
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

    public function getBoxWidgets()
    {
        return $this->hasMany(ReportBoxWidgets::class, ['box_id' => 'id']);
    }

    //this find the maximum/minimum order value for the current display_type and dashboard_id
    public function getDisplayOrderExtreme($type)
    {
        if ($type == 'max') {
            return ReportBox::find()
                ->where([
                    'display_type' => $this->display_type,
                    'dashboard_id' => $this->dashboard_id
                ])->max('display_order');

        } elseif ($type == 'min') {
            return ReportBox::find()
                ->where([
                    'display_type' => $this->display_type,
                    'dashboard_id' => $this->dashboard_id
                ])->min('display_order');

        } else {
            throw new Exception("Invalid type: $type. Expected 'max' or 'min'.");
        }
    }

    public function changeBoxOrder($direction)
    {
        $transaction = self::getDb()->beginTransaction();
        $result = ['status' => false, 'message' => ''];

        try {

            if ($direction === 'inc') {
                $orderCondition = ['>', 'display_order', $this->display_order];
                $orderSort = SORT_ASC;
            }
            else if ($direction === 'dec') {
                $orderCondition = ['<', 'display_order', $this->display_order];
                $orderSort = SORT_DESC;
            }
            else {
                throw new \Exception('Invalid direction');
            }

            //find the next or previous display_order valuse based on direction
            $box = ReportBox::find()
                ->where(['dashboard_id' => $this->dashboard_id, 'display_type' => $this->display_type])
                ->andWhere($orderCondition)
                ->orderBy(['display_order' => $orderSort])
                ->one();

            if (!$box) {
                throw new \Exception('The Box not found!');
            }

            // Swap the orders
            list($this->display_order, $box->display_order) = [$box->display_order, $this->display_order];

            if ($box->save(false) && $this->save(false)) {
                $result['status'] = true;
                $result['message'] = Yii::t("biDashboard", 'The Operation Was Successful');
                $transaction->commit();
            } else {
                throw new \Exception(Yii::t("biDashboard", 'The Operation Failed'));
            }

        } catch (\Exception | \Throwable $e) {
            $transaction->rollBack();
            $result['message'] = $e->getMessage();
        }

        return $result;
    }

    public function getWidgets()
    {
        return $this->hasMany(ReportWidget::class, ['id' => 'widget_id'])
            ->viaTable('report_box_widgets', ['box_id' => 'id']);
    }

    /**
     *
     * @return \yii\db\ActiveQuery|ReportDashboardQuery
     */
    public function getDashboard()
    {
        return $this->hasOne(ReportDashboard::class, ['id' => 'dashboard_id']);
    }

    public static function find()
    {
        $query = new ReportBoxQuery(get_called_class());
        return $query->bySlaveId()->notDeleted();
    }

    public function getChartCategories($year, $month): Array {

        $categories = [];
        $pdate = Yii::$app->pdate;
        $monthDaysCount = count($this->getMonthDays($year . '/' . $month));

        if ($this->range_type == self::RANGE_TYPE_DAILY){
            for($i = 1; $i<= $monthDaysCount; $i++ ){
                $categories[] = $i;
            }
        }
        elseif($this->range_type == self::RANGE_TYPE_MONTHLY){
            for($i = 1; $i <= 12; $i++){
                $categories[] = $pdate->jdate_words(['mm' => $i])['mm'];
            }
        }

        return $categories;
    }

    public function getLastDateSet(int $last_date_set) : Array
    {
        if ($this->date_type == self::DATE_TYPE_FLEXIBLE){
            return [
                'day' => CoreHelper::getDay($last_date_set),
                'month' => CoreHelper::getMonth($last_date_set),
                'year' => CoreHelper::getYear($last_date_set),
            ];
        }
        return [
            'year' => null,
            'month' => null,
            'day' => null
        ];
    }



    public static function itemAlias($type, $code = NULL)
    {
        $_items = [
            'Status' => [
                self::STATUS_ACTIVE => Yii::t('biDashboard', 'Active'),
                self::STATUS_INACTIVE => Yii::t('biDashboard', 'InActive'),
                self::STATUS_DELETED => Yii::t('biDashboard', 'Deleted'),
            ],
            'DisplayTypes' => [
                self::DISPLAY_CHART => Yii::t('biDashboard', 'Chart'),
                self::DISPLAY_TABLE => Yii::t('biDashboard', 'Table'),
                self::DISPLAY_CARD => Yii::t('biDashboard', 'Card'),
            ],
            'DateTypes' => [
                self::DATE_TYPE_FLEXIBLE => Yii::t('biDashboard', 'Flexible'),
                self::DATE_TYPE_TODAY => Yii::t('biDashboard', 'Today'),
                self::DATE_TYPE_YESTERDAY => Yii::t('biDashboard', 'Yesterday'),
                self::DATE_TYPE_THIS_WEEK => Yii::t('biDashboard', 'This Week'),
                self::DATE_TYPE_LAST_WEEK => Yii::t('biDashboard', 'Last Week'),
                self::DATE_TYPE_THIS_MONTH => Yii::t('biDashboard', 'This Month'),
                self::DATE_TYPE_LAST_MONTH => Yii::t('biDashboard', 'Last Month'),
                self::DATE_TYPE_THIS_YEAR => Yii::t('biDashboard', 'This Year'),
                self::DATE_TYPE_LAST_YEAR => Yii::t('biDashboard', 'Last Year'),
            ],
            'DailyDateTypes' => [
                self::DATE_TYPE_TODAY,
                self::DATE_TYPE_YESTERDAY,
                self::DATE_TYPE_THIS_WEEK,
                self::DATE_TYPE_LAST_WEEK,
                self::DATE_TYPE_THIS_MONTH,
                self::DATE_TYPE_LAST_MONTH,
            ],
            'MonthlyDateTypes' => [
                self::DATE_TYPE_THIS_YEAR,
                self::DATE_TYPE_LAST_YEAR
            ],
            'ChartTypes' => [
                self::CHART_LINE => 'line',
                self::CHART_COLUMN => 'column',
                //self::CHART_PIE => 'pie',
                self::CHART_AREA => 'area',
                //self::CHART_WORD_CLOUD => 'worldcloud',
            ],
            'ChartNames' => [
                self::CHART_LINE => Yii::t('biDashboard', 'Chart line'),
                self::CHART_COLUMN => Yii::t('biDashboard', 'Chart column'),
                //self::CHART_PIE => Yii::t('biDashboard', 'Chart pie'),
                self::CHART_AREA => Yii::t('biDashboard', 'Chart area'),
                //self::CHART_WORD_CLOUD => Yii::t('biDashboard', 'Chart world cloud'),
            ],
            'RangeType' => [
                self::RANGE_TYPE_DAILY => Yii::t('biDashboard', 'Daily'),
                self::RANGE_TYPE_MONTHLY => Yii::t('biDashboard', 'Monthly'),
            ],
            'Format' => [
                self::FORMAT_CURRENCY => Yii::t('biDashboard', 'Currency'),
                self::FORMAT_NUMBER => Yii::t('biDashboard', 'Number'),
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