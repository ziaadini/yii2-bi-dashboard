<?php

namespace ziaadini\bidashboard\controllers;

use Yii;
use ziaadini\bidashboard\models\ReportModelClass;
use ziaadini\bidashboard\models\ReportModelClassSearch;
use ziaadini\bidashboard\traits\AjaxValidationTrait;
use yii\filters\AccessControl;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use yii\web\Response;

/**
 * ReportModelClassController implements the CRUD actions for ReportModelClass model.
 */
class ReportModelClassController extends Controller
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
                            'roles' => ['BI/ReportModelClass/index'],
                            'actions' => [
                                'index'
                            ]
                        ],
                        [
                            'allow' => true,
                            'roles' => ['BI/ReportModelClass/update'],
                            'actions' => [
                                'update'
                            ]
                        ],
                    ],
                ],
                'verbs' => [
                    'class' => VerbFilter::class,
                    'actions' => [
                        'delete' => ['POST'],
                    ],
                ],
            ]
        );
    }

    /**
     * Lists all ReportModelClass models.
     *
     * @return string
     */
    public function actionIndex()
    {
        $searchModel = new ReportModelClassSearch();
        $dataProvider = $searchModel->search($this->request->queryParams);

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Updates an existing ReportModelClass model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param int $id
     * @return string|Response
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionUpdate($id)
    {
        $model = $this->findModel($id);
        $model->scenario = $model::SCENARIO_UPDATE;

        if ($model->load($this->request->post()) && $model->validate()) {

            if ($model->save(false)) {
                return $this->asJson([
                    'status' => true,
                    'message' => Yii::t("biDashboard", 'The Operation Was Successful')
                ]);
            } else {
                return $this->asJson([
                    'status' => false,
                    'message' => Yii::t("biDashboard", 'Error In Update')
                ]);
            }
        }

        $this->performAjaxValidation($model);
        return $this->renderAjax('update', [
            'model' => $model,
        ]);
    }

    /**
     * Finds the ReportModelClass model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param int $id
     * @return ReportModelClass the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = ReportModelClass::findOne(['id' => $id])) !== null) {
            return $model;
        }

        throw new NotFoundHttpException(Yii::t('biDashboard', 'The requested page does not exist.'));
    }
}
