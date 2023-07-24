<?php

namespace sadi01\bidashboard\controllers;

use sadi01\bidashboard\models\ReportPage;
use sadi01\bidashboard\models\SharingPage;
use sadi01\bidashboard\models\SharingPageSearch;
use sadi01\bidashboard\traits\AjaxValidationTrait;
use Yii;
use yii\base\Exception;
use Yii\base\ExitException;
use yii\filters\VerbFilter;
use yii\web\Controller;
use yii\web\NotFoundHttpException;

/**
 * SharingPageController implements the CRUD actions for SharingPage model.
 */
class SharingPageController extends Controller
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
                        'expire' => ['POST']
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
     * Lists all SharingPage models.
     *
     * @return string
     */
    public function actionIndex()
    {
        $searchModel = new SharingPageSearch();
        $dataProvider = $searchModel->search($this->request->queryParams);

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Displays a single SharingPage model.
     * @param int $id
     * @return string
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionView($id)
    {
        return $this->renderAjax('view', [
            'model' => $this->findModel($id),
        ]);
    }

    /**
     * Creates a new SharingPage model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return string|\yii\web\Response
     */
    public function actionCreate()
    {
        $model = new SharingPage();
        if ($this->request->isPost) {
            if ($model->load($this->request->post())) {
                $model->save();
                return $this->asJson([
                    'success' => true,
                    'msg' => Yii::t("app", 'Success')
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
     * Updates an existing SharingPage model.
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
                'success' => true,
                'msg' => Yii::t("biDashboard", 'Success')
            ]);
        }
        $this->performAjaxValidation($model);
        return $this->renderAjax('update', [
            'model' => $model,
        ]);
    }

    /**
     * Deletes an existing SharingPage model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param int $id
     * @return \yii\web\Response
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionDelete(int $id)
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
     * @throws ExitException
     * @throws Exception
     * @throws NotFoundHttpException
     */
    public function actionManagement($id)
    {
        $page = $this->findModelPage($id);

        $share_page_model = new SharingPage([
            'page_id' => $page->id,
            'access_key' => Yii::$app->security->generateRandomString()
        ]);
        $page_model = $page->accessKeys;
        if ($share_page_model->load(Yii::$app->request->post()) && $share_page_model->save()) {
            return $this->asJson([
                'success' => true,
                'msg' => Yii::t("biDashboard", 'Success')
            ]);
        }

        $this->performAjaxValidation($share_page_model);
        return $this->renderAjax('management', [
            'model' => $share_page_model,
            'page_model' => $page_model,
        ]);
    }

    /**
     * @param $id
     * @return \yii\web\Response
     */
    public function actionExpire($id)
    {
        $model = $this->findModel($id);
        if ($model) {
            $model->expire();
            return $this->asJson([
                'status' => true,
                'msg' => Yii::t("biDashboard", 'Success')
            ]);

        }
        else{
            return $this->asJson([
                'status' => false,
                'msg' => Yii::t("biDashboard", 'fail to update')
            ]);
        }
    }
    /**
     * Finds the SharingPage model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param int $id
     * @return SharingPage the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel(int $id): SharingPage
    {
        if (($model = SharingPage::findOne(['id' => $id])) !== null) {
            return $model;
        }

        throw new NotFoundHttpException(Yii::t('app', 'The requested page does not exist.'));
    }

    /**
     * Finds the ReportPage model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param int $id ID
     * @return ReportPage the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModelPage($id)
    {
        if (($model = ReportPage::findOne(['id' => $id])) !== null) {
            return $model;
        }
        throw new NotFoundHttpException(Yii::t('app', 'The requested page does not exist.'));
    }
}