<?php

namespace sadi01\bidashboard\controllers;

use sadi01\bidashboard\models\ReportWidget;
use sadi01\bidashboard\models\ReportWidgetResult;
use sadi01\bidashboard\models\ReportWidgetSearch;
use sadi01\bidashboard\traits\AjaxValidationTrait;
use sadi01\bidashboard\traits\CoreTrait;
use Yii;
use yii\filters\VerbFilter;
use yii\helpers\Html;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\web\Response;

/**
 * ReportWidgetController implements the CRUD actions for ReportWidget model.
 */
class ReportWidgetController extends Controller
{
    use AjaxValidationTrait;
    use CoreTrait;

    public $enableCsrfValidation = false;
    public $layout = 'bid_main';

    /**
     * @inheritDoc
     */
    public function behaviors()
    {
        return array_merge(
            parent::behaviors(),
            [
                'verbs' => [
                    'class' => VerbFilter::class,
                    'actions' => [
                        'delete' => ['POST'],
                    ],
                ],
            ]
        );
    }

    /**
     * Lists all ReportWidget models.
     *
     * @return string
     */
    public function actionIndex()
    {
        $searchModel = new ReportWidgetSearch();
        $dataProvider = $searchModel->search($this->request->queryParams);

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Displays a single ReportWidget model.
     * @param int $id ID
     * @param string $method
     * @return string
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionView($id, $method = null)
    {
        $model = $this->findModel($id);

        $modelRoute = $model->getModelRoute();

        return $this->render('view', [
            'model' => $model,
            'modelRoute' => $modelRoute,
        ]);
    }

    /**
     * Creates a new ReportWidget model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return string|\yii\web\Response
     */
    public function actionCreate($searchModelClass = null,
                                 $searchModelMethod = null,
                                 $searchModelRunResultView = null,
                                 $search_route = null,
                                 $search_model_form_name = null,
                                 $queryParams = null,
                                 $output_column = null)
    {
        $model = new ReportWidget();
        $model->loadDefaultValues();

        if ($this->request->isPost) {
            $model->search_model_method = $searchModelMethod;
            $model->search_route = $search_route;
            $model->search_model_class = $searchModelClass;
            $model->search_model_form_name = $search_model_form_name;
            $model->search_model_run_result_view = $searchModelRunResultView;
            $model->params = json_decode($queryParams,true);

            $output_column = $this->request->post('output_column', null);
            $model->outputColumn = array_filter($output_column, fn($value) => array_filter($value));
            if ($model->load($this->request->post()) && $model->validate()) {
                $model->save();
                return $this->asJson([
                    'status' => true,
                    'message' => Yii::t('biDashboard', 'Saved successfully'),
                ]);
            } else {
                return $this->asJson([
                    'status' => false,
                    'errors' => $model->errors,
                    'message' => Yii::t('biDashboard', 'There was a problem saving'),
                ]);
            }
        } else {
            $model->loadDefaultValues();
        }
        $this->performAjaxValidation($model);

        return $this->renderAjax('create', [
            'model' => $model,
            'queryParams' => json_decode($queryParams,true),
            'output_column' => json_decode($output_column,true),
        ]);
    }

    /**
     * Updates an existing ReportWidget model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param int $id ID
     * @return string|Response
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionUpdate($id)
    {
        $model = $this->findModel($id);
        $model->scenario = ReportWidget::SCENARIO_UPDATE;

        if ($model->load($this->request->post()) && $model->save()) {
            return $this->asJson([
                'status' => true,
                'message' => Yii::t("app", 'Item Updated')
            ]);
        }

        $this->performAjaxValidation($model);
        return $this->renderAjax('update', [
            'model' => $model,
        ]);
    }

    /**
     * Deletes an existing ReportWidget model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param int $id ID
     * @return \yii\web\Response
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionDelete($id)
    {
        $model = $this->findModel($id);
        $model->softDelete();

        return $this->redirect(['index']);
    }

    /**
     * Finds the ReportWidget model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param int $id ID
     * @return ReportWidget the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = ReportWidget::findOne(['id' => $id])) !== null) {
            return $model;
        }
        throw new NotFoundHttpException(Yii::t('biDashboard', 'The requested page does not exist.'));
    }

    public function actionOpenModal()
    {
        $searchModel = new ReportWidgetSearch();
        $dataProvider = $searchModel->search($this->request->queryParams);

        return $this->renderAjax('list-widget', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    public function actionRun($id, int $start_range = null, int $end_range = null)
    {
        $model = $this->findModel($id);
        $runWidgetResult = $model->runWidget($start_range, $end_range);

        if ($runWidgetResult === false) {
            return $this->asJson([
                'status' => false,
                'message' => ($model->errors ? Html::errorSummary([$model]) : Yii::t('app', 'Error In Run Widget')),
            ]);
        } else {
            return $this->asJson([
                'status' => true,
                'message' => Yii::t("biDashboard", 'Success'),
            ]);
        }
    }
    public function actionModalShowChart($id,$field,$start_range=null,$end_range=null,$chart_type='line'){
        $model = $this->findModel($id);
        $runWidget= $model->lastResult($start_range,$end_range);
        $result = array_reverse($runWidget->result);
        $arrayResult = null;
        $arrayTitle = null;

        if ($result){
            $arrayResult = array_map(function($item) use ($field) {
                return (int)$item[$field];
            }, $result);

            $arrayTitle = array_map(function($item) {
                return $item["month_name"];
            }, $result);
        }

        if ($chart_type == ReportWidgetResult::CHART_PIE){
            $result_pie = [];
            foreach ($result as $key => $item){
                $result_pie[] = ['name' => $arrayTitle[$key],'y' => $arrayResult[$key]];
            }
            $arrayResult = $result_pie;
        }

        return $this->renderAjax('_chart', [
            'status' => true,
            'msg' => 'ok',
            'widget' => $model,
            'results' => $arrayResult,
            'titles' => $arrayTitle,
            'chart_type' => $chart_type,
            'field' => $field,
            'start_range' => $start_range,
            'end_range' => $end_range,
        ]);
    }
}