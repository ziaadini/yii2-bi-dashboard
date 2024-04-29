<?php

namespace sadi01\bidashboard\controllers;

use PhpOffice\PhpSpreadsheet\IOFactory;
use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;
use sadi01\bidashboard\components\ExcelReport;
use sadi01\bidashboard\helpers\CoreHelper;
use sadi01\bidashboard\models\ReportBaseModel;
use sadi01\bidashboard\models\ReportBox;
use sadi01\bidashboard\models\ReportBoxWidgets;
use sadi01\bidashboard\models\ReportWidget;
use sadi01\bidashboard\traits\AjaxValidationTrait;
use sadi01\bidashboard\traits\CoreTrait;
use yii\base\Model;
use yii\filters\AccessControl;
use yii\filters\VerbFilter;
use yii\web\Controller;
use yii\web\Response;
use Yii;
use function PHPUnit\Framework\returnArgument;

class ReportBoxController extends Controller
{
    use AjaxValidationTrait;
    use CoreTrait;

    public function behaviors()
    {
        return array_merge(
            parent::behaviors(),
            [
                'access' => [
                    'class' => AccessControl::class,
                    'rules' =>
                        [
                            [
                                'allow' => true,
                                'roles' => ['BI/ReportBox/create'],
                                'actions' => [
                                    'create','chart-types','range-types','date-types','get-widgets-by-range','run','run-box','inc-order', 'dec-order','export-excel'
                                ]
                            ],
                            [
                                'allow' => true,
                                'roles' => ['BI/ReportBox/update'],
                                'actions' => [
                                    'update','chart-types','range-types','date-types','get-widgets-by-range','run','run-box','export-excel','inc-order', 'dec-order','export-table'
                                ]
                            ],
                            [
                                'allow' => true,
                                'roles' => ['BI/ReportBox/delete'],
                                'actions' => [
                                    'delete'
                                ]
                            ],
                        ]
                ],
                'verbs' => [
                    'class' => VerbFilter::class,
                    'actions' => [
                        'create' => ['GET', 'POST'],
                        'update' => ['GET', 'POST'],
                        'delete' => ['POST', 'DELETE'],
                    ],
                ],
            ]
        );
    }

    public function actionCreate($dashboardId)
    {
        $model = new ReportBox();
        $model->scenario = $model::SCENARIO_CREATE;

        if ($model->load($this->request->post())) {

            $model->dashboard_id = $dashboardId;
            $model->last_date_set = time();
            $valid = $model->validate();

            if ($valid) {
                try {
                    $model->save(false);
                    return $this->asJson([
                        'status' => true,
                        'message' => Yii::t("biDashboard", 'Box Saved Successfully')
                    ]);

                } catch (Exception $e) {
                    Yii::error($e->getMessage() .PHP_EOL. $e->getTraceAsString(), Yii::$app->controller->id . '/' . Yii::$app->controller->action->id);
                    return $this->asJson([
                        'status' => false,
                        'message' => $e->getMessage() .PHP_EOL. Yii::t("biDashboard", 'Error In Save Box'),
                    ]);
                }
            }

            else {
                return $this->asJson([
                    'status' => false,
                    'message' => $model->errors,
                ]);
            }
        }

        $this->performAjaxValidation($model);
        return $this->renderAjax('create', [
            'model' => $model,
        ]);

    }

    public function actionUpdate($id)
    {
        $model = $this->findModel($id);
        $model->scenario = $model::SCENARIO_UPDATE;

        if ($model->load($this->request->post()) && $model->validate()) {

            if ($model->save(false)) {
                return $this->asJson([
                    'status' => true,
                    'message' => Yii::t("biDashboard", 'The Operation Was Successful')
                ]);
            }
            else {
                return $this->asJson([
                    'status' => false,
                    'message' => $model->errors,
                ]);
            }
        }

        $this->performAjaxValidation($model);
        return $this->renderAjax('update', [
            'model' => $model,
        ]);

    }

    public function actionRunBox($id, $year = null, $month = null, $day = null)
    {
        $box = $this->findModel($id);
        $date_array = null;

        foreach ($box->boxWidgets as $index => $widget) {
            $widget->setWidgetProperties();
            if ($year) {
                $date_array = $widget->getStartAndEndTimestamps($widget, $year, $month, $day);
            } else {
                $date_array = $box->getStartAndEndTimeStampsForStaticDate($box->date_type);
            }

            $widget->widget->runWidget($date_array['start'], $date_array['end']);

            $lastResult = $widget->widget->lastResult($date_array['start'], $date_array['end']);
            $widgetLastResult = $lastResult ? $lastResult->add_on['result'] : [];
            $results = array_reverse($widgetLastResult);

            if (!empty($results)) {
                $widget->collectResults($widget, $results);
            }
        }

        if ($date_array) {
            $box->last_date_set = $date_array['start'];
            $box->lastDateSet = $box->getLastDateSet($box->last_date_set);
        }

        $box->last_run = time();
        $status = $box->save();
        $message = Yii::t("biDashboard", $status ? 'The Operation Was Successful' : 'The Operation Failed');

        return $this->asJson([
            'status' => $status,
            'message' => $message
        ]);
    }

    /**
     * @param $id
     * @param $addOrder
     * @return Response
     */
    public function actionIncOrder($id)
    {
        $box = $this->findModel($id);

        if ($box->display_order >= $box->getDisplayOrderExtreme('max')) {
            return $this->asJson([
                'status' => false,
                'message' => Yii::t("biDashboard", 'It is not possible to move')
            ]);
        }

        $result = $box->changeBoxOrder('inc');
        return $this->asJson($result);
    }

    public function actionDecOrder($id)
    {
        $box = $this->findModel($id);

        if ($box->display_order <= $box->getDisplayOrderExtreme('min')) {
            return $this->asJson([
                'status' => false,
                'message' => Yii::t("biDashboard", 'It is not possible to move')
            ]);
        }

        $result = $box->changeBoxOrder('dec');
        return $this->asJson($result);
    }

    public function actionExportExcel(int $id)
    {
        $box = $this->findModel($id);
        $excel = new ExcelReport();
        $pdate = Yii::$app->pdate;

        if (!$box->boxWidgets) {
            return $this->asJson([
                'status' => false,
                'message' => Yii::t("biDashboard", 'The Operation Failed')
            ]);
        }

        $box->lastDateSet = $box->getLastDateSet($box->last_date_set);

        if ($box->range_type == ReportBox::RANGE_TYPE_DAILY)
        {
            if ($box->date_type == ReportBox::DATE_TYPE_FLEXIBLE)
                $box->rangeDateCount = count($this->getMonthDays($box->lastDateSet['year']."/".$box->lastDateSet['month']));
            else
                $box->rangeDateCount = count($this->getMonthDaysByDateArray($box->getStartAndEndTimeStampsForStaticDate($box->date_type)));
        }

        foreach ($box->boxWidgets as $boxWidget){

            $boxWidget->setWidgetProperties();
            if ($box->date_type == ReportBox::DATE_TYPE_FLEXIBLE)
                $date_array = $boxWidget->getStartAndEndTimestamps($boxWidget, $box->lastDateSet['year'], $box->lastDateSet['month'], $box->lastDateSet['day']);
            else
                $date_array = $box->getStartAndEndTimeStampsForStaticDate($box->date_type);

            $lastResult = $boxWidget->widget->lastResult($date_array['start'], $date_array['end']);
            $widgetLastResult = $lastResult ? $lastResult->add_on['result'] : [];
            $results = array_reverse($widgetLastResult);

            if (!empty($results)) {
                $boxWidget->collectResults($boxWidget, $results);
            }

            if ($boxWidget->errors) {
                $errors[] = $boxWidget->errors;
            }
        }

        if (!empty($errors)) {
            return $this->asJson([
                'status' => false,
                'message' => $errors
            ]);
        }

        $rangeDateNumber = $box->boxWidgets[0]->rangeDateCount;
        $columnNames = $excel->getColumnNames($rangeDateNumber);
        $excel->setCellValuesOfFirstRow($box, $columnNames, $rangeDateNumber, $pdate);

        $excel->setCellValues($excel, $box->boxWidgets, $columnNames, $rangeDateNumber, true);
        return $excel->save();
    }

    public function actionDelete(int $id)
    {
        $model = $this->findModel($id);

        if ($model->softDelete()) {
            return $this->asJson([
                'status' => true,
                'message' => Yii::t("biDashboard", 'The Operation Was Successful')
            ]);
        }
        else {
            return $this->asJson([
                'status' => false,
                'message' => Yii::t("biDashboard", 'Error In Delete Action')
            ]);
        }
    }

    public function actionChartTypes() {

        $out = [];

        if (isset($_POST['depdrop_parents'])) {
            $display_type = $_POST['depdrop_parents'][0];
            if ($display_type == ReportBox::DISPLAY_CHART) {

                $charts = ReportBox::itemAlias('ChartNames');
                foreach ($charts as $key => $chart){
                    $out[] = [
                        "id" => $key,
                        "name" => $chart
                    ];
                }

                return $this->asJson([
                    'output' => $out,
                    'selected' => '',
                ]);
            }
        }

        return $this->asJson([
            'output' => '',
            'selected' => '',
        ]);
    }

    public function actionDateTypes()
    {
        $out = [];

        if (isset($_POST['depdrop_parents'])) {

            $display_type = $_POST['depdrop_parents'][0];
            $chart_type = $_POST['depdrop_parents'][1];

            if ($display_type == ReportBox::DISPLAY_CARD || $chart_type == ReportBox::CHART_PIE || $chart_type == ReportBox::CHART_WORD_CLOUD)
            {
                $dateTypes = ReportBox::itemAlias('DateTypes');
                foreach ($dateTypes as $key => $dateType){
                    $out[] = [
                        "id" => $key,
                        "name" => $dateType
                    ];
                }
            }
            elseif ($display_type == ReportBox::DISPLAY_CHART && $chart_type != ReportBox::CHART_PIE && $chart_type != ReportBox::CHART_WORD_CLOUD || $display_type == ReportBox::DISPLAY_TABLE)
            {
                $out[] = [
                    "id" => ReportBox::DATE_TYPE_FLEXIBLE,
                    "name" => ReportBox::itemAlias('DateTypes', ReportBox::DATE_TYPE_FLEXIBLE)
                ];
            }

            return $this->asJson([
                'output' => $out,
                'selected' => '',
            ]);
        }

        return $this->asJson([
            'output' => '',
            'selected' => '',
        ]);
    }

    public function actionRangeTypes()
    {
        $out = [];

        if (isset($_POST['depdrop_parents'])) {

            $date_type = $_POST['depdrop_parents'][0];

            if ($date_type == ReportBox::DATE_TYPE_FLEXIBLE)
            {
                $rangTypes = ReportBox::itemAlias('RangeType');
                foreach ($rangTypes as $key => $rangType){
                    $out[] = [
                        "id" => $key,
                        "name" => $rangType
                    ];
                }
            }

            return $this->asJson([
                'output' => $out,
                'selected' => '',
            ]);
        }

        return $this->asJson([
            'output' => '',
            'selected' => '',
        ]);
    }

    public function actionGetWidgetsByRange(){

        $out = [];

        if (isset($_POST['depdrop_parents'])) {
            $parents = $_POST['depdrop_parents'];
            if ($parents != null){
                $range_type = $parents[0];
                $widgets = ReportWidget::itemAlias('List', $range_type);
                foreach ($widgets as $key => $widget){
                    $out[] = [
                        "id" => $key,
                        "name" => $widget
                    ];
                }
                return $this->asJson([
                    'output' => $out,
                    'selected' => '',
                ]);
            }
        }

        return $this->asJson([
            'output' => '',
            'selected' => '',
        ]);
    }

    protected function findModel(int $id): ReportBox
    {
        if (($model = ReportBox::findOne(['id' => $id])) !== null) {
            return $model;
        }

        throw new NotFoundHttpException(Yii::t('app', 'The requested page does not exist.'));
    }

}