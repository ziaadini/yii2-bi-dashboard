<?php

namespace sadi01\bidashboard\controllers;

use sadi01\bidashboard\components\Pdate;
use sadi01\bidashboard\models\ReportWidgetResult;
use sadi01\bidashboard\traits\CoreTrait;
use Yii;
use sadi01\bidashboard\models\ReportWidget;
use sadi01\bidashboard\models\ReportWidgetSearch;
use sadi01\bidashboard\traits\AjaxValidationTrait;
use yii\filters\VerbFilter;
use yii\web\Controller;
use yii\web\NotFoundHttpException;

/**
 * ReportWidgetController implements the CRUD actions for ReportWidget model.
 */
class ReportWidgetController extends Controller
{
    use AjaxValidationTrait;
    use CoreTrait;
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
     * @return string
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionView($id)
    {
        $model = $this->findModel($id);
        $params = $model->add_on['params'];

//---- create url search
        $modelRoute = "/" . $model->search_route . "?";
        $modalRouteParams = "";
        foreach ($params as $key => $param) {
            $modalRouteParams .= $model->search_model_form_name . "[" . $key . "]=" . $param . "&";
        }
        $modelRoute .= $modalRouteParams;
//---- end

        $runWidget = ReportWidgetResult::findOne(['widget_id' => $id]);
        if (!$runWidget) {
            $runWidget = $this->runWidget($id, null, null);
        }

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
    public function actionCreate()
    {
        $model = new ReportWidget();
        $model->loadDefaultValues();

        $request = $this->request->get();

        $searchModelClass = $this->request->get( 'searchModelClass',null);
        $searchModelMethod = $this->request->get('searchModelMethod',null);
        $searchModelRunResultView = $this->request->get('searchModelRunResultView',null);
        $search_route = $this->request->get('search_route',null);
        $search_model_form_name = $this->request->get('search_model_form_name',null);
        $queryParams = $this->request->get('queryParams',null);

        if ($this->request->isPost) {
            if ($model->load($this->request->post()) && $model->validate()) {
                $model->save(false);
                return $this->asJson([
                    'success' => true,
                    'msg' => Yii::t('biDashboard', 'Saved successfully'),
                ]);
            } else {
                return $this->asJson([
                    'success' => false,
                    'msg' => Yii::t('biDashboard', 'There was a problem saving'),
                ]);
            }
        } else {
            $model->loadDefaultValues();
        }
        $this->performAjaxValidation($model);

        return $this->renderAjax('create', [
            'model' => $model,
            'searchModelClass' => $searchModelClass,
            'searchModelMethod' => $searchModelMethod,
            'searchModelRunResultView' => $searchModelRunResultView,
            'search_route' => $search_route,
            'search_model_form_name' => $search_model_form_name,
            'queryParams' => $queryParams,
        ]);
    }

    /**
     * Updates an existing ReportWidget model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param int $id ID
     * @return string|\yii\web\Response
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionUpdate($id)
    {
        $model = $this->findModel($id);

        if ($this->request->isPost && $model->load($this->request->post()) && $model->save()) {
            return $this->redirect(['view', 'id' => $model->id]);
        }

        return $this->render('update', [
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

    public function requestGet($request, $key)
    {
        if (key_exists($key, $request)) {
            return $request[$key];
        }
        return null;
    }

    /**
     * @param $id
     * @param $start_range
     * @param $end_rage
     * @return mixed
     * @throws \Exception
     */
    public function runWidget($id, $start_range = null, $end_range = null)
    {
        $widget = $this->findModel($id);
        $nowDate = new \DateTime('UTC');
        /**@var $pDate Pdate */
        $pDate = \Yii::$app->pdate;
        $jNowDate = $pDate->jgetdate();

        if ($start_range) {
            if ($widget->range_type == $widget::RANGE_TYPE_DAILY){
                $start_range = $pDate->jmktime('','','',$start_range['mon'], $start_range['day'], $start_range['year']);
                $end_range = $pDate->jmktime('','','',$end_range['mon'], $end_range['day'], $end_range['year']);
            }else{
                $start_range = $this->getStartAndEndOfMonth($start_range['year']."/".$start_range['mon'])['start'];
                $end_range = $this->getStartAndEndOfMonth($end_range['year']."/".$end_range['mon'])['end'];
            }
        }else{
            if ($widget->range_type == $widget::RANGE_TYPE_DAILY){
                $dateTemp = $this->getStartAndEndOfMonth();
            }else{
                $dateTemp = $this->getStartAndEndOfYear();
            }
            $start_range = $dateTemp['start'];
            $end_range = $dateTemp['end'];
        }

        $modelQueryResults = $this->findSearchModelWidget($widget, $start_range, $end_range);

        // -- create Report Widget Result
        $reportWidgetResult = new ReportWidgetResult();
        $reportWidgetResult->widget_id = $id;
        $reportWidgetResult->status = 10;
        $reportWidgetResult->start_range = $start_range;
        $reportWidgetResult->end_range = $end_range;
        $reportWidgetResult->run_action = Yii::$app->controller->action->id;
        $reportWidgetResult->run_controller = Yii::$app->controller->id;
        $reportWidgetResult->result = $modelQueryResults;
        $reportWidgetResult->save();

        return [
            'success' => true,
            'msg' => Yii::t('biDashboard', 'Saved successfully'),
        ];
    }

    public function findSearchModelWidget($model, $startDate, $endDate)
    {
        $params = $model->add_on['params'];
        $searchModel = new ($model->search_model_class);
        $methodExists = method_exists($searchModel, 'search');
        if ($methodExists) {
            $dataProvider = $searchModel->{$model->search_model_method}($params,$model->range_type, $startDate, $endDate);
        } else {
            //TODO: error
        }
        $modelQueryResults = array_values($dataProvider->query->asArray()->all());

        return $modelQueryResults;
    }
}