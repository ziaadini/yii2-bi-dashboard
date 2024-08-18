<?php

namespace ziaadini\bidashboard\controllers;

use ziaadini\bidashboard\models\ExternalData;
use ziaadini\bidashboard\models\ExternalDataSearch;
use ziaadini\bidashboard\models\ExternalDataValue;
use ziaadini\bidashboard\traits\AjaxValidationTrait;
use Yii;
use yii\data\ActiveDataProvider;
use yii\filters\AccessControl;
use yii\filters\VerbFilter;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\web\Response;

/**
 * ExternalDataController implements the CRUD actions for ExternalData model.
 */
class ExternalDataController extends Controller
{
    use AjaxValidationTrait;



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
                            'roles' => ['BI/ExternalData/index'],
                            'actions' => [
                                'index'
                            ]
                        ],
                        [
                            'allow' => true,
                            'roles' => ['BI/ExternalData/view'],
                            'actions' => [
                                'view'
                            ]
                        ],
                        [
                            'allow' => true,
                            'roles' => ['BI/ExternalData/create'],
                            'actions' => [
                                'create',
                            ]
                        ],
                        [
                            'allow' => true,
                            'roles' => ['BI/ExternalData/update'],
                            'actions' => [
                                'update',
                            ]
                        ],
                        [
                            'allow' => true,
                            'roles' => ['BI/ExternalData/delete'],
                            'actions' => [
                                'delete'
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
                    ],
                ],
            ]
        );
    }

    /**
     * Lists all ExternalData models.
     *
     * @return string
     */
    public function actionIndex()
    {
        $searchModel = new ExternalDataSearch();
        $dataProvider = $searchModel->search($this->request->queryParams);

        $dataProviderValues = new ActiveDataProvider([
            'query' => ExternalDataValue::find(),
            'sort' => [
                'defaultOrder' => [
                    'created_at' => SORT_DESC,
                ],
            ],
        ]);

        if ($this->request->isPjax) {
            return $this->renderAjax('index', [
                'searchModel' => $searchModel,
                'dataProvider' => $dataProvider,
                'dataProviderValues' => $dataProviderValues,
            ]);
        } else {
            return $this->render('index', [
                'searchModel' => $searchModel,
                'dataProvider' => $dataProvider,
                'dataProviderValues' => $dataProviderValues,
            ]);
        }
    }

    /**
     * Displays a single ExternalData model.
     * @param int $id
     * @return string
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionView($id)
    {
        $dataProviderValue = ExternalDataValue::find()->where(['external_data_id' => $id]);
        $dataProviderValue = new ActiveDataProvider([
            'query' => $dataProviderValue,
            'sort' => [
                'defaultOrder' => [
                    'created_at' => SORT_DESC,
                ],
            ],
        ]);

        return $this->render('view', [
            'model' => $this->findModel($id),
            'dataProviderValue' => $dataProviderValue,
        ]);
    }

    /**
     * Creates a new ExternalData model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return string|\yii\web\Response
     */
    public function actionCreate()
    {
        $model = new ExternalData();

        if ($model->load($this->request->post()) && $model->validate()) {
            if ($model->save(false)) {
                return $this->asJson([
                    'status' => true,
                    'message' => Yii::t("biDashboard", 'The Operation Was Successful')
                ]);
            } else {
                return $this->asJson([
                    'status' => false,
                    'message' => Yii::t("biDashboard", 'Error In Save External Data')
                ]);
            }
        }

        $this->performAjaxValidation($model);
        return $this->renderAjax('create', [
            'model' => $model,
        ]);
    }

    /**
     * Updates an existing ExternalData model.
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
                    'message' => Yii::t("biDashboard", 'Error In Update External Data')
                ]);
            }
        }

        $this->performAjaxValidation($model);
        return $this->renderAjax('update', [
            'model' => $model,
        ]);
    }

    /**
     * Deletes an existing ExternalData model.
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
     * Finds the ExternalData model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param int $id
     * @return ExternalData the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = ExternalData::findOne(['id' => $id])) !== null) {
            return $model;
        }

        throw new NotFoundHttpException(Yii::t('app', 'The requested page does not exist.'));
    }
}
