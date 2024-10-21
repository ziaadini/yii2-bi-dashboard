<?php

namespace ziaadini\bidashboard\controllers;


use ziaadini\bidashboard\helpers\CoreHelper;
use ziaadini\bidashboard\models\ReportAlert;
use ziaadini\bidashboard\models\ReportUser;
use ziaadini\bidashboard\models\ReportUserSearch;
use ziaadini\bidashboard\traits\AjaxValidationTrait;
use ziaadini\bidashboard\traits\CoreTrait;
use yii\base\Model;
use yii\filters\AccessControl;
use yii\filters\VerbFilter;
use yii\web\Controller;
use yii\web\Response;
use Yii;

class ReportUserController extends Controller
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
                    'except' => ['change-daily-update'],
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
                                    'index', 'get-users'
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
        $searchModel = new ReportUserSearch();
        $dataProvider = $searchModel->search($this->request->queryParams);

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    public function actionCreate()
    {
        $model = new ReportUser();

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

    public function actionGetUsers($alertId)
    {
        $out = [];
        $selectedUsers = [];
        if ($alertId)
        {
            $alert = ReportAlert::findOne($alertId);
            $selectedUsers = $alert->usersList();
        }

        if (isset($_POST['depdrop_parents']))
        {
            $notification_type = $_POST['depdrop_parents'][0];
            if ($notification_type != ReportAlert::NOTIFICATION_NONE) {

                $users = ReportUser::find()->all();
                if (!$users) {
                    return $this->asJson(['output' => [], 'selected' => '']);
                }

                foreach ($users as $user) {
                    $out[] = ['id' => $user->id, 'name' => $user->fullName() .' ('. $user->phone_number . ')'];
                }

                return $this->asJson([
                    'output' => $out,
                    'selected' => $selectedUsers,
                ]);
            }
        }

        return $this->asJson([
            'output' => '',
            'selected' => '',
        ]);
    }

    public function actionDelete(int $id)
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

    protected function findModel(int $id): ReportUser
    {
        if (($model = ReportUser::findOne(['id' => $id])) !== null) {
            return $model;
        }

        throw new NotFoundHttpException(Yii::t('app', 'The requested page does not exist.'));
    }
}
