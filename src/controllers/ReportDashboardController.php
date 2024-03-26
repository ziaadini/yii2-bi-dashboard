<?php

namespace sadi01\bidashboard\controllers;

use common\models\BaseModel;
use sadi01\bidashboard\models\ReportBaseModel;
use sadi01\bidashboard\models\ReportBox;
use sadi01\bidashboard\models\ReportBoxWidgets;
use sadi01\bidashboard\models\ReportDashboard;
use sadi01\bidashboard\models\ReportDashboardWidget;
use sadi01\bidashboard\models\ReportWidget;
use sadi01\bidashboard\models\ReportDashboardSearch;
use sadi01\bidashboard\traits\AjaxValidationTrait;
use sadi01\bidashboard\traits\CoreTrait;
use yii\helpers\ArrayHelper;
use yii\base\Model;
use yii\db\Exception;
use yii\filters\AccessControl;
use yii\filters\VerbFilter;
use yii\web\Controller;
use yii\web\Response;
use Yii;

class ReportDashboardController extends Controller
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
                                'actions' => [
                                    'view-by-access-key'
                                ]
                            ],
                            [
                                'allow' => true,
                                'roles' => ['BI/ReportDashboard/index'],
                                'actions' => [
                                    'index',
                                ]
                            ],
                            [
                                'allow' => true,
                                'roles' => ['BI/ReportDashboard/view'],
                                'actions' => [
                                    'view',
                                ]
                            ],
                            [
                                'allow' => true,
                                'roles' => ['BI/ReportDashboard/create'],
                                'actions' => [
                                    'create',
                                ]
                            ],
                            [
                                'allow' => true,
                                'roles' => ['BI/ReportDashboard/update'],
                                'actions' => [
                                    'update',
                                ]
                            ],
                            [
                                'allow' => true,
                                'roles' => ['BI/ReportDashboard/delete'],
                                'actions' => [
                                    'delete',
                                ]
                            ],
                        ]
                ],
                'verbs' => [
                    'class' => VerbFilter::class,
                    'actions' => [
                        'index' => ['GET'],
                        'view' => ['GET', 'POST'],
                        'create' => ['GET', 'POST'],
                        'update' => ['GET', 'POST'],
                        'delete' => ['POST', 'DELETE'],
                    ],
                ],
            ]
        );
    }

    public function actionIndex(): string
    {
        $searchModel = new ReportDashboardSearch();
        $dataProvider = $searchModel->search($this->request->queryParams);

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * @param $id
     * @param $mustBeUpdated
     * @return string|Response
     *
     *
     */
    public function actionView($id)
    {
        $model = $this->findModel($id);
        $boxes = $model->dashboardBoxes;

        $errors = [];
        $charts = [];
        $cards = [];
        $tables = [];

        foreach ($boxes as $index => $box){

            $box->lastDateSet = $box->getLastDateSet($box->last_date_set);

            if ($box->display_type == ReportBox::DISPLAY_CHART)
                $box->chartCategories = $box->getChartCategories($box->lastDateSet['year'],$box->lastDateSet['month']);

            if ($box->range_type == ReportBox::RANGE_TYPE_DAILY){
                if ($box->date_type == ReportBox::DATE_TYPE_FLEXIBLE)
                    $box->rangeDateCount = count($this->getMonthDays($box->lastDateSet['year']."/".$box->lastDateSet['month']));
                else
                    $box->rangeDateCount = count($this->getMonthDaysByDateArray($box->getStartAndEndTimeStampsForStaticDate($box->date_type)));
            }

            foreach ($box->boxWidgets as $widget){

                $widget->setWidgetProperties();
                if ($box->date_type == ReportBox::DATE_TYPE_FLEXIBLE)
                    $date_array = $widget->getStartAndEndTimestamps($widget, $box->lastDateSet['year'], $box->lastDateSet['month'], $box->lastDateSet['day']);
                else
                    $date_array = $box->getStartAndEndTimeStampsForStaticDate($box->date_type);

                $lastResult = $widget->widget->lastResult($date_array['start'], $date_array['end']);
                $widgetLastResult = $lastResult ? $lastResult->add_on['result'] : [];
                $results = array_reverse($widgetLastResult);

                if (!empty($results)) {
                    $widget->collectResults($widget, $results);
                }

                if ($widget->errors) {
                    $errors[] = $widget->errors;
                }
            }

            // Separate Boxes based on display_type
            match ($box->display_type)
            {
                ReportBox::DISPLAY_CARD => $cards[] = $box,
                ReportBox::DISPLAY_CHART => $charts[] = $box,
                ReportBox::DISPLAY_TABLE => $tables[] = $box,
            };
        }

        // Collect chart series data
        foreach ($charts as $chart) {
            foreach ($chart->boxWidgets as $boxWidget){
                $chart->chartSeries[] = ['name' => $boxWidget->title ?? $boxWidget->widget->title, 'data' => $boxWidget->results['chartData'] ?? ''];
            }
        }

        return $this->render('view', [
            'model' => $model,
            'boxes' => $boxes,
            'charts' => $charts,
            'tables' => $tables,
            'cards' => $cards,
        ]);

    }

    public function actionCreate()
    {
        $model = new ReportDashboard();

        if ($model->load($this->request->post()) && $model->validate()) {

            if($model->save())
                return $this->redirect(['view', 'id' => $model->id]);

            else {
                return $this->asJson([
                    'status' => false,
                    'message' => Yii::t("biDashboard", 'Error In Save Page')
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

        if ($model->load($this->request->post()) && $model->validate()) {
            if ($model->save(false)) {
                return $this->asJson([
                    'status' => true,
                    'message' => Yii::t("biDashboard", 'The Operation Was Successful')
                ]);
            } else {
                return $this->asJson([
                    'status' => false,
                    'message' => Yii::t("biDashboard", 'Error In Update Dashboard')
                ]);
            }
        }

        $this->performAjaxValidation($model);
        return $this->renderAjax('update', [
            'model' => $model,
        ]);

    }

    public function actionDelete(int $id): Response
    {
        $model = $this->findModel($id);

        if ($model->softDelete()) {
            return $this->asJson([
                'status' => true,
                'message' => Yii::t("biDashboard", 'The Operation Was Successful')
            ]);
        } else {
            return $this->asJson([
                'status' => false,
                'message' => Yii::t("biDashboard", 'Error In Delete Action')
            ]);
        }
    }

    protected function findModel(int $id): ReportDashboard
    {
        if (($model = ReportDashboard::findOne(['id' => $id])) !== null) {
            return $model;
        }

        throw new NotFoundHttpException(Yii::t('app', 'The requested page does not exist.'));
    }



}