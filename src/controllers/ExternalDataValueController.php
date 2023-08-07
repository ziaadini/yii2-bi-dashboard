<?php

namespace sadi01\bidashboard\controllers;

use Yii;
use sadi01\bidashboard\models\ExternalDataValue;
use sadi01\bidashboard\models\ExternalDataValueSearch;
use sadi01\bidashboard\traits\AjaxValidationTrait;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use yii\web\Response;

/**
 * ExternalDataValueController implements the CRUD actions for ExternalDataValue model.
 */
class ExternalDataValueController extends Controller
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
                    'class' => VerbFilter::className(),
                    'actions' => [
                        'delete' => ['POST'],
                    ],
                ],
            ]
        );
    }

    /**
     * Lists all ExternalDataValue models.
     *
     * @return string
     */
    public function actionIndex()
    {
        $searchModel = new ExternalDataValueSearch();

        $dataProvider = $searchModel->search($this->request->queryParams);

        $queryParams = \Yii::$app->request->getQueryParams();
        if ($queryParams and key_exists('ExternalDataValueSearch',$queryParams)) {

            $queryParams = array_filter($queryParams['ExternalDataValueSearch']);
        }

        return $this->renderAjax('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
            'queryParams' => $queryParams,
        ]);
    }

    /**
     * Displays a single ExternalDataValue model.
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
     * Creates a new ExternalDataValue model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return string|\yii\web\Response
     */
    public function actionCreate($external_data_id)
    {
        $model = new ExternalDataValue();

        if ($model->load($this->request->post())) {
            $model->external_data_id = $external_data_id;
            if ($model->save()) {
                return $this->asJson([
                    'status' => true,
                    'message' => Yii::t("biDashboard", 'Success')
                ]);
            } else {
                return $this->asJson([
                    'status' => false,
                    'message' => Yii::t("biDashboard", 'Fail in Save')
                ]);
            }
        }

        $this->performAjaxValidation($model);
        return $this->renderAjax('create', [
            'model' => $model,
        ]);
    }

    /**
     * Updates an existing ExternalDataValue model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param int $id 
     * @return string|Response
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionUpdate($id)
    {
        $model = $this->findModel($id);

        if ($model->load($this->request->post())) {
            if ($model->save()) {
                return $this->asJson([
                    'status' => true,
                    'message' => Yii::t("biDashboard", 'Success')
                ]);
            } else {
                return $this->asJson([
                    'status' => false,
                    'message' => Yii::t("biDashboard", 'Fail in Save')
                ]);
            }
        }

        return $this->renderAjax('update', [
            'model' => $model,
        ]);
    }

    /**
     * Deletes an existing ExternalDataValue model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param int $id 
     * @return Response
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionDelete($id)
    {
        $this->findModel($id)->delete();

        return $this->redirect(['index']);
    }

    /**
     * Finds the ExternalDataValue model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param int $id 
     * @return ExternalDataValue the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = ExternalDataValue::findOne(['id' => $id])) !== null) {
            return $model;
        }

        throw new NotFoundHttpException(Yii::t('biDashboard', 'The requested page does not exist.'));
    }
}
