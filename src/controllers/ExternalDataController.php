<?php

namespace sadi01\bidashboard\controllers;

use sadi01\bidashboard\models\ExternalData;
use sadi01\bidashboard\models\ExternalDataSearch;
use sadi01\bidashboard\models\ExternalDataValue;
use sadi01\bidashboard\traits\AjaxValidationTrait;
use Yii;
use yii\data\ActiveDataProvider;
use yii\filters\AccessControl;
use yii\filters\VerbFilter;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\web\Response;
use function PHPUnit\Framework\countOf;

/**
 * ExternalDataController implements the CRUD actions for ExternalData model.
 */
class ExternalDataController extends Controller
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
                'access' => [
                    'class' => AccessControl::class,
                    'rules' =>
                        [
                            [
                                'allow' => true,
                                'roles' => ['ExternalData/index'],
                                'actions' => [
                                    'index'
                                ]
                            ],
                            [
                                'allow' => true,
                                'roles' => ['ExternalData/view'],
                                'actions' => [
                                    'view'
                                ]
                            ],
                            [
                                'allow' => true,
                                'roles' => ['ExternalData/create'],
                                'actions' => [
                                    'create',
                                ]
                            ],
                            [
                                'allow' => true,
                                'roles' => ['ExternalData/update'],
                                'actions' => [
                                    'update',
                                ]
                            ],
                            [
                                'allow' => true,
                                'roles' => ['ExternalData/delete'],
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
                        'create' => ['POST'],
                        'update' => ['POST'],
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

        if ($model->load($this->request->post())) {
            if ($model->save()) {
                return $this->asJson([
                    'status' => true,
                    'message' => Yii::t("app", 'Success')
                ]);
            } else {
                return $this->asJson([
                    'status' => false,
                    'message' => Yii::t("app", 'Fail in Save')
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

        if ($model->load($this->request->post())) {
            if ($model->save()) {
                return $this->asJson([
                    'status' => true,
                    'message' => Yii::t("app", 'Success')
                ]);
            } else {
                return $this->asJson([
                    'status' => false,
                    'message' => Yii::t("app", 'Fail in Save')
                ]);
            }
        }

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
        $exteralDataValues = $model->externalDataValues;
        foreach ($exteralDataValues as $value){
            $value->softDelete();
        }
        $model->softDelete();
        return $this->asJson([
            'status' => true,
            'message' => Yii::t("biDashboard", 'Success')
        ]);
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

        throw new NotFoundHttpException(Yii::t('biDashboard', 'The requested page does not exist.'));
    }
}
