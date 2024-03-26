<?php

namespace sadi01\bidashboard\controllers;

use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;
use sadi01\bidashboard\components\ExcelReport;
use sadi01\bidashboard\helpers\CoreHelper;
use sadi01\bidashboard\models\ReportPage;
use sadi01\bidashboard\models\ReportPageSearch;
use sadi01\bidashboard\models\ReportPageWidget;
use sadi01\bidashboard\models\ReportWidget;
use sadi01\bidashboard\models\SharingPage;
use sadi01\bidashboard\traits\AjaxValidationTrait;
use sadi01\bidashboard\traits\CoreTrait;
use Yii;
use yii\filters\AccessControl;
use yii\filters\VerbFilter;
use yii\helpers\ArrayHelper;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\web\Response;

/**
 * ReportPageController implements the CRUD actions for ReportPage model.
 */
class ReportPageController extends Controller
{
    use AjaxValidationTrait;
    use CoreTrait;

    /**
     * @inheritDoc
     */
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
                                'roles' => ['BI/ReportPage/index'],
                                'actions' => [
                                    'index','export-excel'
                                ]
                            ],
                            [
                                'allow' => true,
                                'roles' => ['BI/ReportPage/view'],
                                'actions' => [
                                    'view'
                                ]
                            ],
                            [
                                'allow' => true,
                                'roles' => ['BI/ReportPage/create'],
                                'actions' => [
                                    'create','inc-order','dec-order'
                                ]
                            ],
                            [
                                'allow' => true,
                                'roles' => ['BI/ReportPage/update'],
                                'actions' => [
                                    'update',
                                ]
                            ],
                            [
                                'allow' => true,
                                'roles' => ['BI/ReportPage/delete'],
                                'actions' => [
                                    'delete'
                                ]
                            ],
                            [
                                'allow' => true,
                                'roles' => ['BI/ReportPage/update-widget'],
                                'actions' => [
                                    'update-widget'
                                ]
                            ],
                            [
                                'allow' => true,
                                'roles' => ['BI/ReportPage/add'],
                                'actions' => [
                                    'add'
                                ]
                            ],
                            [
                                'allow' => true,
                                'roles' => ['BI/ReportPage/get-widget-column'],
                                'actions' => [
                                    'get-widget-column'
                                ]
                            ],
                            [
                                'allow' => true,
                                'roles' => ['BI/ReportPage/run-all-widgets'],
                                'actions' => [
                                    'run-all-widgets'
                                ]
                            ],

                        ]
                ],
                'verbs' => [
                    'class' => VerbFilter::class,
                    'actions' => [
                        'index' => ['GET'],
                        'view' => ['GET'],
                        'create' => ['GET', 'POST'],
                        'update' => ['GET', 'POST'],
                        'delete' => ['POST', 'DELETE'],
                        'update-widget' => ['POST'],
                        'add' => ['GET', 'POST'],
                        'get-widget-column' => ['POST'],
                        'run-all-widgets' => ['POST'],
                        'view-by-access-key' => ['GET'],
                    ],
                ],
            ]
        );
    }

    /**
     * Lists all ReportPage models.
     *
     * @return string
     */
    public function actionIndex(): string
    {
        $searchModel = new ReportPageSearch();
        $dataProvider = $searchModel->search($this->request->queryParams);

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Displays a single ReportPage model.
     * @param int $id ID
     * @return string
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionViewByAccessKey(string $access_key): string
    {

        $model = $this->findPage($access_key);

        $month = CoreHelper::getCurrentMonth();
        $year = CoreHelper::getCurrentYear();

        if ($model->range_type == $model::RANGE_DAY) {
            if ($month) {
                $date_array = $this->getStartAndEndOfMonth($year . '/' . $month);
            } else {
                $date_array = $this->getStartAndEndOfMonth();
            }
        } else {
            if ($year) {
                $date_array = $this->getStartAndEndOfYear($year);
            } else {
                $date_array = $this->getStartAndEndOfYear();
            }
        }

        if ($model->range_type == $model::RANGE_DAY) {
            $rangeDateNumber = count($this->getCurrentMonthDays());
        } else {
            $rangeDateNumber = 12;
        }

        return $this->render('view', [
            'model' => $model,
            'pageWidgets' => $model->reportPageWidgets,
            'startRange' => $date_array['start'],
            'endRange' => $date_array['end'],
            'rangeDateNumber' => $rangeDateNumber,
            'month' => $month,
            'year' => $year,
        ]);
    }

    public function actionView($id, $year = null, $month = null)
    {
        /*$slaves = ReportPageWidget::find()->select(['slave_id'])->distinct()->all();
        foreach ($slaves as $slave)
        {
            $slaveIds[] = $slave['slave_id'];
        }
        dd($slaveIds);*/

        $model = $this->findModel($id);

        $month = $month ?: CoreHelper::getCurrentMonth();
        $year = $year ?: CoreHelper::getCurrentYear();

        if ($model->range_type == $model::RANGE_DAY) {
            if ($month) {
                $date_array = $this->getStartAndEndOfMonth($year . '/' . $month);
            } else {
                $date_array = $this->getStartAndEndOfMonth();
            }
        } else {
            if ($year) {
                $date_array = $this->getStartAndEndOfYear($year);
            } else {
                $date_array = $this->getStartAndEndOfYear();
            }
        }

        if ($model->range_type == $model::RANGE_DAY) {
            $rangeDateNumber = count($this->getMonthDaysByDateArray($date_array));
        } else {
            $rangeDateNumber = 12;
        }

        return $this->render('view', [
            'model' => $model,
            'pageWidgets' => $model->reportPageWidgets,
            'startRange' => $date_array['start'],
            'endRange' => $date_array['end'],
            'rangeDateNumber' => $rangeDateNumber,
            'month' => $month,
            'year' => $year,
        ]);
    }

    /**
     * Creates a new ReportPage model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return string|Response
     */
    public function actionCreate(): Response|string
    {
        $model = new ReportPage();
        if ($model->load($this->request->post()) && $model->validate()) {
            if ($model->save(false)) {
                return $this->asJson([
                    'status' => true,
                    'message' => Yii::t("biDashboard", 'The Operation Was Successful')
                ]);
            } else {
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

    /**
     * Updates an existing ReportPage model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param int $id ID
     * @return string|\yii\web\Response
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionUpdate($id): Response|string
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
                    'message' => Yii::t("biDashboard", 'Error In Update Page')
                ]);
            }
        }

        $this->performAjaxValidation($model);
        return $this->renderAjax('update', [
            'model' => $model,
        ]);
    }

    /**
     * Deletes an existing ReportPage model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param int $id ID
     * @return \yii\web\Response
     * @throws NotFoundHttpException if the model cannot be found
     */
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

    public function actionUpdateWidget(int $id): Response|string
    {
        $model = ReportPageWidget::find()->where(['widget_id' => $id])->one();
        $add_on = $model->widget->add_on["outputColumn"];

        foreach ($add_on as $value) {
            $column_name[$value->column_name] = $value->column_title;
        }
        if ($model->load($this->request->post()) && $model->validate()) {
            if ($model->save(false)) {
                return $this->asJson([
                    'status' => true,
                    'message' => Yii::t("biDashboard", 'The Operation Was Successful')
                ]);
            } else {
                return $this->asJson([
                    'status' => false,
                    'message' => Yii::t("biDashboard", 'Error In Update Widget')
                ]);
            }
        }

        $this->performAjaxValidation($model);
        return $this->renderAjax('_edit', [
            'model' => $model,
            'column_name' => $column_name,
        ]);
    }

    public function actionAdd(int $id): Response|string
    {
        $model = new ReportPageWidget();
        $page = $this->findModel($id);
        $model->page_id = $id;

        if ($model->load($this->request->post()) && $model->validate()) {
            if ($model->save(false)) {
                return $this->asJson([
                    'status' => true,
                    'message' => Yii::t("biDashboard", 'The Operation Was Successful')
                ]);

            } else {
                return $this->asJson([
                    'status' => false,
                    'message' => Yii::t("biDashboard", 'Error In Add Widget')
                ]);
            }
        }

        $this->performAjaxValidation($model);

        return $this->renderAjax('_add', [
            'model' => $model,
            'page' => $page,
        ]);
    }

    /** @var $widget ReportWidget */
    public function actionGetWidgetColumn()
    {
        Yii::$app->response->format = Response::FORMAT_JSON;
        $out = [];
        if (isset($_POST['depdrop_parents'])) {
            $parents = $_POST['depdrop_parents'];
            if ($parents != null) {
                $widget_id = $parents[0];
                $widget = ReportWidget::findOne(['id' => $widget_id]);
                if (!$widget) {
                    return ['output' => [], 'selected' => ''];
                }
                $outputColumns = $widget->outputColumn;
                foreach ($outputColumns as $item) {
                    $out[] = ['id' => $item['column_name'], 'name' => $item['column_title']];
                }
                return ['output' => $out, 'selected' => ''];
            }
        }
        return ['output' => '', 'selected' => ''];
    }

    /**
     * @param $id
     * @param $start_range
     * @param $end_range
     * @return mixed
     * @var $widget ReportWidget
     */
    public function actionRunAllWidgets($id, $start_range = null, $end_range = null)
    {
        $model = $this->findModel($id);
        $start_range = $start_range ? (int)$start_range : null;
        $end_range = $end_range ? (int)$end_range : null;
        $errors = [];
        foreach ($model->widgets as $widget) {
            $widget->runWidget($start_range, $end_range);
            if ($widget->errors) {
                $errors[] = $widget->errors;
            }
        }
        return $this->asJson([
            'status' => true,
            'success' => true,
            'message' => $errors ? Yii::t('biDashboard', 'Error In Run Widget') : Yii::t("biDashboard", 'Success'),
        ]);
    }

    public function actionExportExcel($id, $start_range = null, $end_range = null)
    {
        $page = $this->findModel($id);
        $excel = new ExcelReport();
        $pdate = Yii::$app->pdate;

        $date_array = [];
        $date_array['start'] = $start_range ? (int)$start_range : null;
        $date_array['end'] = $end_range ? (int)$end_range : null;

        if (!$page->widgets) {
            return $this->asJson([
                'status' => false,
                'message' => Yii::t("biDashboard", 'The Operation Failed')
            ]);
        }

        if ($page->range_type == $page::RANGE_DAY) {
            $rangeDateNumber = count($this->getMonthDaysByDateArray($date_array));
        } else {
            $rangeDateNumber = 12;
        }

        $results = [];
        foreach ($page->reportPageWidgets as $pageWidget) {
            $lastResult = $pageWidget->widget->lastResult($date_array['start'], $date_array['end']);
            $widgetLastResult = $lastResult ? $lastResult->add_on['result'] : [];
            $results = array_reverse($widgetLastResult);
            if (!empty($results)) {
                $array [] = $pageWidget->collectResults($pageWidget, $results);
            }
        }

        $columnNames = $excel->getColumnNames($rangeDateNumber);
        $excel->setCellValuesOfFirstRow($page, $columnNames, $rangeDateNumber, $pdate);
        $excel->setCellValues($excel, $page->reportPageWidgets, $columnNames, $rangeDateNumber);
        return $excel->save();
    }

    /**
     * Finds the ReportPage model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param int $id ID
     * @return ReportPage the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel(int $id): ReportPage
    {
        if (($model = ReportPage::findOne(['id' => $id])) !== null) {
            return $model;
        }

        throw new NotFoundHttpException(Yii::t('app', 'The requested page does not exist.'));
    }

    protected function findPage(string $access_key)
    {
        $model = SharingPage::find()
            ->where(['access_key' => $access_key])
            ->andWhere(['>=','expire_time',time()])
            ->limit(1)
            ->one();

        if ($model !== NULL) {
            return $this->findModel($model->page_id);
        }

        throw new NotFoundHttpException(Yii::t('app', 'The requested page does not exist.'));
    }

    private function flash($type, $message): void
    {
        Yii::$app->getSession()->setFlash($type == 'error' ? 'danger' : $type, $message);
    }
}