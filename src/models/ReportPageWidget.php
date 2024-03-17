<?php

namespace sadi01\bidashboard\models;

use sadi01\bidashboard\helpers\FormatHelper;
use Yii;
use yii\behaviors\BlameableBehavior;
use yii\behaviors\TimestampBehavior;
use yii\db\ActiveRecord;
use yii2tech\ar\softdelete\SoftDeleteBehavior;

/**
 * This is the model class for table "report_page_widget".
 *
 * @property int $id
 * @property int $slave_id
 * @property int $page_id
 * @property int $widget_id
 * @property int $display_order
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
    const FORMAT_GRAM = 3;
    const FORMAT_KILOGRAM= 4;

    public $results = [];

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
            [['slave_id'], 'default', 'value' => function () {
                return Yii::$app->params['bi_slave_id'] ?? null;
            }],
            [['page_id', 'widget_id', 'report_widget_field', 'slave_id'], 'required'],
            [['page_id', 'display_order', 'widget_id', 'report_widget_field_format', 'status', 'slave_id'], 'integer'],
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

    public function getFormattedValue($value)
    {
        switch ($this->report_widget_field_format) {
            case self::FORMAT_NUMBER:
                return FormatHelper::formatNumber($value);
            case self::FORMAT_CURRENCY:
                return FormatHelper::formatCurrency($value);
            case self::FORMAT_GRAM:
                return FormatHelper::formatCurrency($value);
            case self::FORMAT_KILOGRAM:
                return FormatHelper::formatKiloGram($value);
        }
    }

    //beforeSave() is overridden to calculate the maximum display_order value for the current page_id
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

    //this find the maximum/minimum order value for the current display_type and dashboard_id
    public function getDisplayOrderExtreme($type)
    {
        if ($type == 'max') {
            return ReportPageWidget::find()
                ->where([
                    'page_id' => $this->page_id
                ])->max('display_order');

        } elseif ($type == 'min') {
            return ReportPageWidget::find()
                ->where([
                    'page_id' => $this->page_id
                ])->min('display_order');

        } else {
            throw new Exception("Invalid type: $type. Expected 'max' or 'min'.");
        }
    }

    public function changeWidgetOrder($direction)
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

            //find the next or previous display_order valuse
            $pageWidget = ReportPageWidget::find()
                ->where(['page_id' => $this->page_id])
                ->andWhere($orderCondition)
                ->orderBy(['display_order' => $orderSort])
                ->one();

            if (!$pageWidget) {
                throw new \Exception('The Widget not found!');
            }

            // Swap the orders
            list($this->display_order, $pageWidget->display_order) = [$pageWidget->display_order, $this->display_order];

            if ($pageWidget->save(false) && $this->save(false)) {
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

    public function collectResults($widget, $results)
    {
        $pdate = Yii::$app->pdate;

        $widget->results['data'] = array_map(function ($item) use ($widget) {
            return (int)$item[$widget->report_widget_field];
        }, $results);

        $widget->results['categories'] = array_map(function ($item) use ($widget) {
            if ($widget->page->range_type == ReportPage::RANGE_DAY) {
                return $item['day'];
            } else {
                return $item['month_name'];
            }
        }, $results);

        $widget->results['combine'] = array_combine($widget->results['categories'], $widget->results['data']);

        if ($widget->page->range_type == ReportPage::RANGE_DAY){
            for ($i = 0; $i <= 30; $i++) {
                if (array_key_exists($i+1, $widget->results['combine'])) {
                    $widget->results['final_result'][$i] = $widget->results['combine'][$i+1];
                }
                else {
                    $widget->results['final_result'][$i] = 0;
                }
            }
        }
        elseif($widget->page->range_type == ReportPage::RANGE_MONTH){
            for ($i = 0; $i <= 11; $i++){
                if (array_key_exists($pdate->jdate_words(['mm' => $i+1])['mm'], $widget->results['combine'])){
                    $widget->results['final_result'][$i] = $widget->results['combine'][$pdate->jdate_words(['mm' => $i+1])['mm']];
                }
                else {
                    $widget->results['final_result'][$i] = 0;
                }
            }
        }
    }

    /**
     * {@inheritdoc}
     * @return ReportPageWidgetQuery the active query used by this AR class.
     */
    public static function find()
    {
        $query = new ReportPageWidgetQuery(get_called_class());
        return $query->bySlaveId()->notDeleted();
    }

    public static function itemAlias($type, $code = NULL)
    {
        $_items = [
            'Status' => [
                self::STATUS_DELETED => Yii::t('biDashboard', 'DELETED'),
                self::STATUS_ACTIVE => Yii::t('biDashboard', 'ACTIVE'),
                self::STATUS_INACTIVE => Yii::t('biDashboard', 'INACTIVE'),
            ],
            'Format' => [
                self::FORMAT_CURRENCY => Yii::t('biDashboard', 'Currency'),
                self::FORMAT_NUMBER => Yii::t('biDashboard', 'Number'),
                self::FORMAT_GRAM => Yii::t('biDashboard', 'Gram'),
                self::FORMAT_KILOGRAM => Yii::t('biDashboard', 'Kilo Gram'),
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
                'invokeDeleteEvents' => false
            ],
        ];
    }
}