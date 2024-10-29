<?php

namespace ziaadini\bidashboard\controllers;

use Codeception\PHPUnit\ResultPrinter\Report;
use common\models\BaseModel;
use ziaadini\bidashboard\models\ReportAlert;
use ziaadini\bidashboard\models\ReportAlertSearch;
use ziaadini\bidashboard\models\ReportAlertUser;
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

class ReportAlertController extends Controller
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
                                    'index',
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

    public function actionIndex(): string
    {
        $searchModel = new ReportAlertSearch();
        $dataProvider = $searchModel->search($this->request->queryParams);

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * @param $id
     * @return string|Response
     *
     *
     */
    public function actionView($alert_id = null)
    {
        $searchModel = new ReportFiredAlertSearch();

        if ($alert_id != null) {
            $searchModel->alert_id = $alert_id;
        }

        $dataProvider = $searchModel->search($this->request->queryParams);
        return $this->renderAjax('view', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    public function actionCreate($widgetId = null, $widgetField = null, $fromBox = null)
    {
        $model = new ReportAlert();
        $model->widget_id = $widgetId;
        $model->widget_field = $widgetField;
        if ($model->load($this->request->post()) && $model->validate())
        {
            $userIds = $this->request->post()['ReportAlert']['users'];
            $transaction = \Yii::$app->db->beginTransaction();
            try {

                $alert = $model->save();

                if ($alert) {

                    if (!empty($userIds) && $model->notification_type != ReportAlert::NOTIFICATION_NONE)
                    {
                        foreach ($userIds as $userId)
                        {
                            $alertUser = new ReportAlertUser();
                            $alertUser->user_id = $userId;
                            $alertUser->alert_id = $model->id;

                            if (!$alertUser->save()) {
                                $transaction->rollBack();
                                Yii::error($e->getMessage() . PHP_EOL . $e->getTraceAsString(), Yii::$app->controller->id . '/' . Yii::$app->controller->action->id);
                                return $this->asJson([
                                    'status' => false,
                                    'message' => $e->getMessage(),
                                ]);
                            }
                        }
                    }

                    $transaction->commit();
                    return $this->asJson([
                        'status' => true,
                        'message' => Yii::t("biDashboard", 'The Operation Was Successful')
                    ]);
                }

                else {
                    $transaction->rollBack();
                    return $this->asJson([
                        'status' => false,
                        'message' => Yii::t("biDashboard", 'The Operation Failed'),
                    ]);
                }
            }
            catch (Exception $e) {
                $transaction->rollBack();
                Yii::error($e->getMessage() . PHP_EOL . $e->getTraceAsString(), Yii::$app->controller->id . '/' . Yii::$app->controller->action->id);
                return $this->asJson([
                    'status' => false,
                    'message' => $e->getMessage(),
                ]);
            }
        }

        $this->performAjaxValidation($model);
        return $this->renderAjax('create', [
            'model' => $model,
            'fromBox' => $fromBox
        ]);
    }

    public function actionUpdate($id, $fromBox = null)
    {
        $model = $this->findModel($id);

        /*echo \yii\helpers\VarDumper::dump($model, 10, true);
        die();*/


        if ($model->load($this->request->post()) && $model->validate())
        {
            $userIds = $this->request->post()['ReportAlert']['users'];

            //TODO: remove removed UserIds!

            $transaction = \Yii::$app->db->beginTransaction();
            try {

                $alert = $model->save();

                if ($alert) {

                    if (!empty($userIds) && $model->notification_type != ReportAlert::NOTIFICATION_NONE)
                    {
                        foreach ($userIds as $userId)
                        {
                            $alertUser = new ReportAlertUser();
                            $alertUser->user_id = $userId;
                            $alertUser->alert_id = $model->id;

                            if (!$alertUser->save()) {
                                $transaction->rollBack();
                                Yii::error($e->getMessage() . PHP_EOL . $e->getTraceAsString(), Yii::$app->controller->id . '/' . Yii::$app->controller->action->id);
                                return $this->asJson([
                                    'status' => false,
                                    'message' => $e->getMessage(),
                                ]);
                            }
                        }
                    }

                    $transaction->commit();
                    return $this->asJson([
                        'status' => true,
                        'message' => Yii::t("biDashboard", 'The Operation Was Successful')
                    ]);
                }

                else {
                    $transaction->rollBack();
                    return $this->asJson([
                        'status' => false,
                        'message' => Yii::t("biDashboard", 'The Operation Failed'),
                    ]);
                }
            }
            catch (Exception $e) {
                $transaction->rollBack();
                Yii::error($e->getMessage() . PHP_EOL . $e->getTraceAsString(), Yii::$app->controller->id . '/' . Yii::$app->controller->action->id);
                return $this->asJson([
                    'status' => false,
                    'message' => $e->getMessage(),
                ]);
            }
        }

        $this->performAjaxValidation($model);
        return $this->renderAjax('update', [
            'model' => $model,
            'fromBox' => $fromBox
        ]);
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
        if (($model = ReportAlert::findOne(['id' => $id])) !== null) {
            return $model;
        }

        throw new NotFoundHttpException(Yii::t('app', 'The requested page does not exist.'));
    }
}
