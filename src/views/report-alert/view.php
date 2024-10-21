<?php

use ziaadini\bidashboard\widgets\Alert;
use ziaadini\bidashboard\widgets\grid\ActionColumn;
use ziaadini\bidashboard\widgets\grid\GridView;
use ziaadini\bidashboard\models\ReportFiredAlert;
use yii\helpers\Html;
use yii\helpers\Time;
use yii\helpers\Url;
use yii\web\View;
use yii\widgets\DetailView;
use yii\widgets\Pjax;
use yii\widgets\ActiveForm;
use yii\web\JsExpression;

/**
 * @var View $this
 * @var ReportDashboard $model
 * @var ReportBox $boxes
 * @var ReportBox $charts
 * @var ReportBox $tables
 * @var ReportBoxWidgets $cards
 */
$pdate = Yii::$app->pdate;

?>

<div class="report-dashboard-view">

    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],
            'id',
            [
                'attribute' => 'dashboard_id',
                'value' => function (ReportFiredAlert $model) {
                    return $model->dashboard->title.' ('.$model->dashboard->id.')';
                },
            ],
            [
                'attribute' => 'box_id',
                'value' => function (ReportFiredAlert $model) {
                    return $model->box->title.' ('.$model->box->id.')';
                },
            ],
            [
                'attribute' => 'created_at',
                'value' => function (ReportFiredAlert $model) {
                    return Yii::$app->pdate->jdate('Y/m/d - H:i', $model->created_at);
                }
            ],
            [
                'attribute' => 'لینک به داشبورد',
                'format' => 'raw',
                'value' => function (ReportFiredAlert $model) {
                    return Html::a('<i class="fas fa-link"></i>', Url::to(['report-dashboard/view', 'id' => $model->dashboard_id]) . '#box_'.$model->box_id, [
                        'target' => '_blank',
                    ]);
                }
            ],
        ],
        'summary' => "",
    ]); ?>

</div>