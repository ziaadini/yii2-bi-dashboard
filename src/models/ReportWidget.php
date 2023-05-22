<?php

namespace sadi01\bidashboard\models;

use app\models\search\InvoiceSearch;
use Yii;

/**
 * This is the model class for table "report_widget".
 *
 * @property int $id
 * @property string $title
 * @property string|null $description
 * @property int|null $search_model_class
 * @property string $search_model_method
 * @property int $status
 * @property int $deleted_at
 * @property string|null $search_model_run_result_view
 * @property int|null $range_type
 * @property int|null $visibility
 * @property string|null $add_on
 * @property int $updated_at
 * @property int $created_at
 * @property int $updated_by
 * @property int $created_by
 *
 * @property ReportPageWidget[] $reportPageWidgets
 * @property ReportWidgetResult[] $reportWidgetResults
 */
class ReportWidget extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public $params;
    public $class_method_number = [
      'app\models\search\InvoiceSearch' => 1,
    ];
    public static function tableName()
    {
        return 'report_widget';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['title', 'search_model_method'], 'required'],
            [['status', 'deleted_at', 'range_type', 'visibility', 'updated_at', 'created_at', 'updated_by', 'created_by'], 'integer'],
            [['add_on','search_model_class'], 'safe'],
            [['title', 'search_model_method', 'search_model_run_result_view'], 'string', 'max' => 128],
            [['description'], 'string', 'max' => 255],
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
            'description' => Yii::t('biDashboard', 'Description'),
            'search_model_class' => Yii::t('biDashboard', 'Search Model Class'),
            'search_model_method' => Yii::t('biDashboard', 'Search Model Method'),
            'status' => Yii::t('biDashboard', 'Status'),
            'deleted_at' => Yii::t('biDashboard', 'Deleted At'),
            'search_model_run_result_view' => Yii::t('biDashboard', 'Search Model Run Result View'),
            'range_type' => Yii::t('biDashboard', 'Range Type'),
            'visibility' => Yii::t('biDashboard', 'Visibility'),
            'add_on' => Yii::t('biDashboard', 'Add On'),
            'updated_at' => Yii::t('biDashboard', 'Updated At'),
            'created_at' => Yii::t('biDashboard', 'Created At'),
            'updated_by' => Yii::t('biDashboard', 'Updated By'),
            'created_by' => Yii::t('biDashboard', 'Created By'),
        ];
    }

    /**
     * Gets query for [[ReportPageWidgets]].
     *
     * @return \yii\db\ActiveQuery|\sadi01\bidashboard\models\query\ReportPageWidgetQuery
     */
    public function getReportPageWidgets()
    {
        return $this->hasMany(ReportPageWidget::class, ['widget_id' => 'id']);
    }

    /**
     * Gets query for [[ReportWidgetResults]].
     *
     * @return \yii\db\ActiveQuery|\sadi01\bidashboard\models\query\ReportWidgetResultQuery
     */
    public function getReportWidgetResults()
    {
        return $this->hasMany(ReportWidgetResult::class, ['widget_id' => 'id']);
    }

    /**
     * {@inheritdoc}
     * @return \sadi01\bidashboard\models\query\ReportWidgetQuery the active query used by this AR class.
     */
    public static function find()
    {
        return new \sadi01\bidashboard\models\query\ReportWidgetQuery(get_called_class());
    }
    
    public function beforeSave($insert)
    {
        $nowDate = new \DateTime('UTC');
        if ($this->isNewRecord){
            $this->created_by = Yii::$app->user->id;
            $this->created_at = $nowDate->getTimestamp();
        }
        $this->updated_at = $nowDate->getTimestamp();
        $this->updated_by = Yii::$app->user->id;

        if(key_exists($this->search_model_class,$this->class_method_number)){
            $this->search_model_class = $this->class_method_number[$this->search_model_class];
        }else{
            $this->search_model_class = null;
        }

        return parent::beforeSave($insert);
    }


    const STATUS_ACTIVE = 1;
    const STATUS_DELETED = 0;

//    ------------ SEARCH_MODEL_CLASS
    const SEARCH_MODEL_CLASS_INVOICE = 1;

    const RANGE_TYPE_DAILY = 1;
    const RANGE_TYPE_MONTHLY = 2;
    const VISIBILITY_PUBLIC = 1;
    const VISIBILITY_PRIVATE = 2;

    public static function itemAlias($type, $code = NULL)
    {
        $_items = [
            'Status' => [
                self::STATUS_ACTIVE => Yii::t('biDashboard', 'Active'),
                self::STATUS_DELETED => Yii::t('biDashboard', 'Deleted')
            ],
            'SearchModelClass' => [
                self::SEARCH_MODEL_CLASS_INVOICE => InvoiceSearch::class,
            ],
            'RangeTypes' => [
                self::RANGE_TYPE_DAILY => Yii::t('biDashboard', 'Daily'),
                self::RANGE_TYPE_MONTHLY => Yii::t('biDashboard', 'Monthly'),
            ],
            'Visibility' => [
                self::VISIBILITY_PUBLIC => Yii::t('biDashboard', 'Public'),
                self::VISIBILITY_PRIVATE => Yii::t('biDashboard', 'Private'),
            ],
        ];

        if (isset($code))
            return isset($_items[$type][$code]) ? $_items[$type][$code] : false;
        else
            return isset($_items[$type]) ? $_items[$type] : false;
    }


}
