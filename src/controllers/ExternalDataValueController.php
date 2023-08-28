<?php

namespace sadi01\bidashboard\controllers;

use sadi01\bidashboard\models\ExternalDataValue;
use sadi01\bidashboard\models\ExternalDataValueSearch;
use sadi01\bidashboard\traits\AjaxValidationTrait;
use Yii;
use yii\filters\AccessControl;
use yii\filters\VerbFilter;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
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
//                'access' => [
//                    'class' => AccessControl::class,
//                    'rules' =>
//                        [
//                            [
//                                'allow' => true,
//                                'roles' => ['BI/ExternalDataValue/index'],
//                                'actions' => [
//                                    'index'
//                                ]
//                            ],
//                            [
//                                'allow' => true,
//                                'roles' => ['BI/ExternalDataValue/view'],
//                                'actions' => [
//                                    'view'
//                                ]
//                            ],
//                            [
//                                'allow' => true,
//                                'roles' => ['BI/ExternalDataValue/create'],
//                                'actions' => [
//                                    'create',
//                                ]
//                            ],
//                            [
//                                'allow' => true,
//                                'roles' => ['BI/ExternalDataValue/update'],
//                                'actions' => [
//                                    'update',
//                                ]
//                            ],
//                            [
//                                'allow' => true,
//                                'roles' => ['BI/ExternalDataValue/delete'],
//                                'actions' => [
//                                    'delete'
//                                ]
//                            ],
//
//                        ]
//                ],
                'verbs' => [
                    'class' => VerbFilter::class,
                    'actions' => [
                        'index' => ['GET'],
                        'view' => ['GET'],
                        'create' => ['GET','POST'],
                        'update' => ['GET','POST'],
                        'delete' => ['POST', 'DELETE'],
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
        $queryParams = array_filter(Yii::$app->request->getQueryParam('ExternalDataValueSearch') ?: []);

        if ($this->request->isPjax) {
            return $this->renderAjax('index', [
                'searchModel' => $searchModel,
                'dataProvider' => $dataProvider,
                'queryParams' => $queryParams,
            ]);
        } else {
            return $this->render('index', [
                'searchModel' => $searchModel,
                'dataProvider' => $dataProvider,
                'queryParams' => $queryParams,
            ]);
        }
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
     * @return string|Response
     */
    public function actionCreate($external_data_id)
    {
        $model = new ExternalDataValue(['external_data_id' => $external_data_id]);

        if ($model->load($this->request->post()) && $model->validate()) {
            if ($model->save(false)) {
                return $this->asJson([
                    'status' => true,
                    'message' => Yii::t("biDashboard", 'The Operation Was Successful')
                ]);
            } else {
                return $this->asJson([
                    'status' => false,
                    'message' => Yii::t("biDashboard", 'Error In Save External Data Value')
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

        if ($model->load($this->request->post()) && $model->validate()) {
            if ($model->save(false)) {
                return $this->asJson([
                    'status' => true,
                    'message' => Yii::t("biDashboard", 'The Operation Was Successful')
                ]);
            } else {
                return $this->asJson([
                    'status' => false,
                    'message' => Yii::t("biDashboard", 'Error In Update External Data Value')
                ]);
            }
        }

        $this->performAjaxValidation($model);
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

        throw new NotFoundHttpException(Yii::t('app', 'The requested page does not exist.'));
    }
}