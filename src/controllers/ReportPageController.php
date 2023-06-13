<?php

namespace sadi01\bidashboard\controllers;

use sadi01\bidashboard\components\jdate;
use sadi01\bidashboard\models\ReportPage;
use sadi01\bidashboard\models\ReportPageSearch;
use sadi01\bidashboard\models\ReportPageWidget;
use sadi01\bidashboard\traits\AjaxValidationTrait;
use Yii;
use yii\filters\AccessControl;
use yii\filters\VerbFilter;
use yii\web\Controller;
use yii\web\NotFoundHttpException;

/**
 * ReportPageController implements the CRUD actions for ReportPage model.
 */
class ReportPageController extends Controller
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
                    'rules' => [
                        [
                            'allow' => true,
                            'roles' => ['@'],
                        ],
                    ],
                ],
                'verbs' => [
                    'class' => VerbFilter::class,
                    'actions' => [
                        'index' => ['GET'],
                        'view' => ['GET'],
                        'create' => ['GET', 'POST'],
                        'update' => ['GET', 'PUT', 'POST'],
                        'delete' => ['POST', 'DELETE'],
                    ],
                ],
            ]
        );
    }

    /**
     * Lists all ReportPage models.
     *
     * @return string
     */
    public function actionIndex()
    {
        $searchModel = new ReportPageSearch();
        $dataProvider = $searchModel->search($this->request->queryParams);

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Displays a single ReportPage model.
     * @param int $id ID
     * @return string
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionView($id)
    {
        $model = $this->findModel($id);

        if ($model->range_type) {
            return $this->render('view', [
                'model' => $model,
                'widgets' => $model->reportPageWidgets,
            ]);
        } else {
            return $this->render('monthly', [
                'model' => $model,
                'widgets' => $model->reportPageWidgets,
            ]);
        }
    }

    /**
     * Creates a new ReportPage model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return string|\yii\web\Response
     */
    public function actionCreate()
    {
        $model = new ReportPage();

        if ($this->request->isPost) {
            if ($model->load($this->request->post()) && $model->validate()) {
                $model->save(false);
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
     * Updates an existing ReportPage model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param int $id ID
     * @return string|\yii\web\Response
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionUpdate($id)
    {
        $model = $this->findModel($id);

        if ($this->request->isPost && $model->load($this->request->post()) && $model->validate() && $model->save()) {
            return $this->asJson([
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
     * Deletes an existing ReportPage model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param int $id ID
     * @return \yii\web\Response
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionDelete($id)
    {
        $model = $this->findModel($id);

        if ($model->canDelete() && $model->softDelete()) {

            $this->flash('success', Yii::t('app', 'Item Deleted'));

        } else {

            $this->flash('error', $model->errors ? array_values($model->errors)[0][0] : Yii::t('app', 'Error In Delete Action'));
        }

        return $this->redirect(['index']);
    }

    /**
     * Finds the ReportPage model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param int $id ID
     * @return ReportPage the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = ReportPage::findOne(['id' => $id])) !== null) {
            return $model;
        }

        throw new NotFoundHttpException(Yii::t('app', 'The requested page does not exist.'));
    }

    public function actionAdd($id)
    {
        $model = new ReportPageWidget();
        $page = $this->findModel($id);
        $model->page_id = $id;

        if ($this->request->isPost) {
            if ($model->load($this->request->post()) && $model->validate()) {
                if ($model->save(false)) {
                    return $this->asJson([
                        'success' => true,
                        'msg' => Yii::t("app", 'Success')
                    ]);
                } else {
                    return $this->asJson([
                        'success' => false,
                        'msg' => Yii::t("app", 'fail')
                    ]);
                }
            }
        } else {
            $model->loadDefaultValues();
        }

        $this->performAjaxValidation($model);
        return $this->renderAjax('_add', [
            'model' => $model,
            'page' => $page
        ]);
    }

    private function flash($type, $message)
    {
        Yii::$app->getSession()->setFlash($type == 'error' ? 'danger' : $type, $message);
    }
}