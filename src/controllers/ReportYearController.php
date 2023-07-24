<?php

namespace sadi01\bidashboard\controllers;

use sadi01\bidashboard\models\ReportYear;
use sadi01\bidashboard\models\ReportYearSearch;
use sadi01\bidashboard\traits\AjaxValidationTrait;
use Yii;
use yii\filters\VerbFilter;
use yii\web\Controller;
use yii\web\NotFoundHttpException;

/**
 * ReportYearController implements the CRUD actions for ReportYear model.
 */
class ReportYearController extends Controller
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

    public function beforeAction($action)
    {
        Yii::$app->controller->enableCsrfValidation = false;
        return parent::beforeAction($action);
    }

    /**
     * Lists all ReportYear models.
     *
     * @return string
     */
    public function actionIndex()
    {
        $searchModel = new ReportYearSearch();
        $dataProvider = $searchModel->search($this->request->queryParams);

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Displays a single ReportYear model.
     * @param int $id
     * @return string
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionView($id)
    {
        return $this->render('view', [
            'model' => $this->findModel($id),
        ]);
    }

    /**
     * Creates a new ReportYear model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return string|\yii\web\Response
     */
    public function actionCreate()
    {
        $model = new ReportYear();
        if ($this->request->isPost) {
            if ($model->load($this->request->post())) {
                $model->save();
                return $this->asJson([
                    'success' => true,
                    'msg' => Yii::t("app", 'Success')
                ]);
            } else {
                return $this->asJson([
                    'success' => false,
                    'msg' => Yii::t("app", 'Fails')
                ]);
            }
        } else {
            $model->loadDefaultValues();
        }

        $this->performAjaxValidation($model);
        return $this->renderAjax('create', [
            'model' => $model,
        ]);
    }

    /**
     * Updates an existing ReportYear model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param int $id
     * @return string|\yii\web\Response
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionUpdate(int $id)
    {
        $model = $this->findModel($id);

        if ($this->request->isPost && $model->load($this->request->post()) && $model->save()) {
            return $this->asJson([
                'status' => true,
                'success' => true,
                'msg' => Yii::t("app", 'Success')
            ]);
        }

        $this->performAjaxValidation($model);
        return $this->renderAjax('update', [
            'model' => $model,
        ]);
    }

    /**
     * Deletes an existing ReportYear model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param int $id
     * @return \yii\web\Response
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionDelete($id)
    {
        $model = $this->findModel($id);
        if ($model->canDelete() && $model->softDelete()) {
            return $this->asJson([
                'status' => true,
                'msg' => Yii::t("biDashboard", 'Item Deleted')
            ]);
        } else {
            return $this->asJson([
                'status' => false,
                'msg' => Yii::t("biDashboard", 'Error In Delete Action')
            ]);
        }
    }

    /**
     * Finds the ReportYear model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param int $id
     * @return ReportYear the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = ReportYear::findOne(['id' => $id])) !== null) {
            return $model;
        }

        throw new NotFoundHttpException(Yii::t('app', 'The requested page does not exist.'));
    }
}