<?php

namespace sadi01\bidashboard\controllers;

use sadi01\bidashboard\models\ReportWidgetResult;
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
            $runWidget = $this->actionRunWidget($id, null, null);
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
        $searchModelClass = $this->requestGet($request, 'searchModelClass');
        $searchModelMethod = $this->requestGet($request, 'searchModelMethod');
        $searchModelRunResultView = $this->requestGet($request, 'searchModelRunResultView');
        $search_route = $this->requestGet($request, 'search_route');
        $search_model_form_name = $this->requestGet($request, 'search_model_form_name');
        $queryParams = $this->requestGet($request, 'queryParams');

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
    public function actionRunWidget($id, $start_range=null, $end_range=null)
    {
        $widget = $this->findModel($id);
        $nowDate = new \DateTime('UTC');
        $pDate = \Yii::$app->pdate;
        $jNowDate = $pDate->jgetdate();
        $CNTmonthDay = (int)$jNowDate['mon'] <= 6 ? 31 : 30;

        $j_year_start_range = $jNowDate['year'];
        $j_month_start_range = $jNowDate['mon'];
        if ($widget->range_type == $widget::RANGE_TYPE_DAILY) {
            if (!$start_range) {
                $start_range_datetime = new \DateTime($pDate->jalali_to_gregorian($j_year_start_range, $j_month_start_range, '1', '/'));
            } else {
                $start_range_datetime = new \DateTime($pDate->jalali_to_gregorian($start_range['year'], $start_range['month'], $start_range['day'], '/'));
            }
            if (!$end_range) {
                $j_day_range = $jNowDate['mday'];
                $end_range_datetime = new \DateTime($pDate->jalali_to_gregorian($j_year_start_range, $j_month_start_range, $j_day_range, '/'));
            } else {
                $end_range_datetime = new \DateTime($pDate->jalali_to_gregorian($end_range['year'], $end_range['month'], $end_range['day'], '/'));
            }
        } else {
            if (!$start_range) {
                $start_range_datetime = new \DateTime($pDate->jalali_to_gregorian($j_year_start_range, '1', '1', '/'));
            } else {
                $start_range_datetime = new \DateTime($pDate->jalali_to_gregorian($start_range['year'], $start_range['month'], '1', '/'));
            }
            if (!$end_range) {
                $end_range_datetime = new \DateTime($pDate->jalali_to_gregorian($j_year_start_range, $j_month_start_range, $CNTmonthDay, '/'));
            } else {
                $end_range_datetime = new \DateTime($pDate->jalali_to_gregorian($end_range['year'], $end_range['month'], $CNTmonthDay, '/'));
            }
        }

        $modelQueryResults = [];
        if ($widget->range_type == $widget::RANGE_TYPE_DAILY) {
            for ($i = 1; $i <= $CNTmonthDay; $i++) {
                $startDate = new \DateTime($pDate->jalali_to_gregorian($j_year_start_range, $j_month_start_range, $i, '/'));
                $endDate = $startDate->setTime(23, 23, 59);
                $modelQueryResults[$i] = $this->findSearchModelWidget($widget, $startDate, $endDate, 'm')[0];
                $modelQueryResults[$i]['title'] = $i;
            }
        } else {
            $months = [1 => 'فروردین', 2 => 'اردیبشهت', 3 => 'خرداد', 4 => 'تیر', 5 => 'مرداد', 6 => 'شهریور', 7 => 'مهر', 8 => 'آبان', 9 => 'آذر', 10 => 'دی', 11 => 'بهمن', 12 => 'اسفند'];
            foreach ($months as $key => $month) {
                $startDate = new \DateTime($pDate->jalali_to_gregorian($j_year_start_range, $key, '1', '/'));
                $endDate = new \DateTime($pDate->jalali_to_gregorian($j_year_start_range, $key, $key <= 6 ? '31' : '30', '/'));

                $modelQueryResults[$key] = $this->findSearchModelWidget($widget, $startDate, $endDate, 'm')[0];
                $modelQueryResults[$key]['title'] = $month;
            }
        }


        // -- create Report Widget Result
        $reportWidgetResult = new ReportWidgetResult();
        $reportWidgetResult->widget_id = $id;
        $reportWidgetResult->status = 10;
        $reportWidgetResult->start_range = $start_range_datetime->getTimestamp();
        $reportWidgetResult->end_range = $end_range_datetime->getTimestamp();
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
            $dataProvider = $searchModel->{$model->search_model_method}($params, $startDate, $endDate);
        } else {
            //TODO: error
        }
        $modelQueryResults = array_values($dataProvider->query->asArray()->all());

        return $modelQueryResults;
    }
}