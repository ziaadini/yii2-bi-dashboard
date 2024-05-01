<?php

namespace sadi01\bidashboard\controllers;

use sadi01\bidashboard\models\ReportPage;
use sadi01\bidashboard\models\ReportPageWidget;
use sadi01\bidashboard\traits\AjaxValidationTrait;
use Yii;
use yii\filters\AccessControl;
use yii\filters\VerbFilter;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\web\Response;

/**
 * ReportPageController implements the CRUD actions for ReportPage model.
 */
class ReportPageWidgetController extends Controller
{
    use AjaxValidationTrait;

    public function behaviors(): array
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
                                'roles' => ['BI/ReportPageWidget/delete'],
                                'actions' => [
                                    'delete',
                                ]
                            ],
                            [
                                'allow' => true,
                                'roles' => ['BI/ReportPage/view'],
                                'actions' => [
                                    'inc-order','dec-order'
                                ]
                            ]
                        ]
                ],
                'verbs' => [
                    'class' => VerbFilter::class,
                    'actions' => [
                        'delete' => ['POST', 'DELETE'],
                    ],
                ],
            ]
        );
    }

    public function actionDelete($id_widget, $id_page)
    {
        $model = ReportPageWidget::findOne(['widget_id' => $id_widget, 'page_id' => $id_page]);
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

    public function actionIncOrder($id)
    {
        $pageWidget = $this->findModel($id);

        if ($pageWidget->display_order >= $pageWidget->getDisplayOrderExtreme('max')) {
            return $this->asJson([
                'status' => false,
                'message' => Yii::t("biDashboard", 'It is not possible to move')
            ]);
        }

        $result = $pageWidget->changeWidgetOrder('inc');
        return $this->asJson($result);
    }

    public function actionDecOrder($id)
    {
        $pageWidget = $this->findModel($id);

        if ($pageWidget->display_order <= $pageWidget->getDisplayOrderExtreme('min')) {
            return $this->asJson([
                'status' => false,
                'message' => Yii::t("biDashboard", 'It is not possible to move')
            ]);
        }

        $result = $pageWidget->changeWidgetOrder('dec');
        return $this->asJson($result);
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
        if (($model = ReportPageWidget::findOne(['id' => $id])) !== null) {
            return $model;
        }

        throw new NotFoundHttpException(Yii::t('app', 'The requested page does not exist.'));
    }
}