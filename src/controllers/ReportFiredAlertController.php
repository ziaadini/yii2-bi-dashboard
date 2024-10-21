<?php

namespace ziaadini\bidashboard\controllers;

use common\models\BaseModel;
use ziaadini\bidashboard\models\ReportAlert;
use ziaadini\bidashboard\models\ReportFiredAlert;
use ziaadini\bidashboard\models\ReportFiredAlertSearch;
use ziaadini\bidashboard\models\ReportBaseModel;
use ziaadini\bidashboard\models\ReportWidget;
use ziaadini\bidashboard\traits\AjaxValidationTrait;
use ziaadini\bidashboard\traits\CoreTrait;
use yii\helpers\ArrayHelper;
use yii\base\Model;
use yii\db\Exception;
use yii\filters\AccessControl;
use yii\filters\VerbFilter;
use yii\web\Controller;
use yii\web\Response;
use Yii;

class ReportFiredAlertController extends Controller
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
                    'except' => [''],
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
                                    'index', 'change-seen-status'
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

    public function actionIndex($box_id = null)
    {
        $searchModel = new ReportFiredAlertSearch();

        if ($box_id != null) {
            $searchModel->box_id = $box_id;
        }

        $dataProvider = $searchModel->search($this->request->queryParams);
        return $this->renderAjax('index', [
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

    }

    public function actionCreate()
    {
        $model = new ReportFiredAlert();
        if ($model->load($this->request->post()) && $model->validate()) {

            if ($model->save())
                return $this->asJson([
                    'status' => true,
                    'message' => Yii::t("biDashboard", 'The Operation Was Successful')
                ]);
            else {
                return $this->asJson([
                    'status' => false,
                    'message' => Yii::t("biDashboard", 'The Operation Failed')
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
    public function actionChangeSeenStatus()
    {
        \Yii::$app->response->format = \yii\web\Response::FORMAT_JSON;

        if (Yii::$app->request->isAjax) {

            $id = Yii::$app->request->post('id');
            $seen_status = Yii::$app->request->post('seen_status');
            $model = ReportFiredAlert::findOne($id);

            if ($model !== null) {

                $model->seen_status = $seen_status;
                $model->seen_time = time();
                $model->seen_by = Yii::$app->user->id;

                if ($model->save()) {
                    return ['success' => true];
                }
            }
        }

        return ['success' => false];
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


    protected function findModel(int $id): ReportAlert
    {
        if (($model = ReportFiredAlert::findOne(['id' => $id])) !== null) {
            return $model;
        }

        throw new NotFoundHttpException(Yii::t('app', 'The requested page does not exist.'));
    }
}
