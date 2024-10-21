<?php

use ziaadini\bidashboard\models\ReportAlert;
use ziaadini\bidashboard\models\ReportAlertSearch;
use ziaadini\bidashboard\models\ReportWidget;
use ziaadini\bidashboard\widgets\grid\ActionColumn;
use ziaadini\bidashboard\widgets\grid\GridView;
use yii\data\ActiveDataProvider;
use yii\helpers\Html;
use yii\helpers\Url;
use yii\web\View;
use yii\widgets\Pjax;

/** @var View $this */
/** @var ReportAlertSearch $searchModel */
/** @var ActiveDataProvider $dataProvider */

$this->title = Yii::t('biDashboard', 'Alerts');
$this->params['breadcrumbs'][] = ' ' . $this->title;
$script = <<< JS
    $(document).ready(function() {
        function toggleClass() {
            $('i.fa-bells.fire').toggleClass('text-danger');
        }
        setInterval(toggleClass, 450);
    });
JS;
$this->registerJs($script);
?>
<style>
    .fa-bells {
        transition: color 0.5s ease;
    }
</style>
<div class="page-content container-fluid text-left" id="main-wrapper">
    <?php Pjax::begin(['id' => 'p-jax-report-alert', 'enablePushState' => false]); ?>
    <div class="work-report-index card">
        <div class="panel-group m-bot20" id="accordion">
            <div class="card-header d-flex justify-content-between">
                <div class="d-flex align-items-center font-16 font-bold">
                    <span><?= Yii::t('biDashboard', 'Alert List') ?></span></div>
                <?= $this->render('_search', ['model' => $searchModel]); ?>
                <div>
                    <?= Html::a(
                        Yii::t('biDashboard', 'Create Alert'),
                        "javascript:void(0)",
                        [
                            'data-pjax' => '0',
                            'class' => "btn btn-success rounded-md",
                            'data-size' => 'modal-xxl modal-dialog-centered',
                            'data-title' => Yii::t('biDashboard', 'Create Alert'),
                            'data-toggle' => 'modal',
                            'data-target' => '#modal-pjax-bi',
                            'data-url' => Url::to(['report-alert/create']),
                            'data-handle-form-submit' => 1,
                            'data-reload-pjax-container' => 'p-jax-report-alert'
                        ]
                    ) ?>
                </div>
            </div>
            <div class="card-body page-content container-fluid text-left">
                <?= GridView::widget([
                    'dataProvider' => $dataProvider,
                    'columns' => [
                        ['class' => 'yii\grid\SerialColumn'],
                        'id',
                        'title',
                        'description',
                        [
                            'attribute' => 'notification_type',
                            'value' => function (ReportAlert $model) {
                                return ReportAlert::itemAlias('Notification', $model->notification_type);
                            },
                        ],
                        [
                            'attribute' => 'widget_id',
                            'value' => function (ReportAlert $model) {
                                return $model->widget->title;
                            },
                        ],
                        [
                            'attribute' => 'widget_field',
                            'value' => function (ReportAlert $model) {
                                return ReportWidget::getWidgetFieldTitle($model->widget_id, $model->widget_field);
                            },
                        ],
                        [
                            'attribute' => 'state',
                            'format' => 'raw',
                            'value' => function (ReportAlert $model) {
                                if ($model->state === ReportAlert::STATE_ALERTING) {
                                    return ReportAlert::itemAlias('State', $model->state) .
                                        ' <i class="fa-bells fas fire text-white text-danger"></i>';
                                }
                                return ReportAlert::itemAlias('State', $model->state);
                            },
                        ],
                        [
                            'attribute' => 'ceiling',
                            'value' => function (ReportAlert $model) {
                                if($model->ceiling)
                                    return number_format($model->ceiling);
                                else
                                    return '_';
                            },
                        ],
                        [
                            'attribute' => 'floor',
                            'value' => function (ReportAlert $model) {
                                if($model->floor)
                                    return number_format($model->floor);
                                else
                                    return '_';
                            },
                        ],
                        [
                            'attribute' => 'seen',
                            'value' => function (ReportAlert $model) {
                                return ReportAlert::itemAlias('Seen', $model->seen);
                            },
                        ],
                        [
                            'attribute' => 'status',
                            'value' => function (ReportAlert $model) {
                                return ReportAlert::itemAlias('Status', $model->status);
                            },
                        ],
                        [
                            'class' => ActionColumn::class,
                            'template' => '{view} {delete}',
                            'urlCreator' => function ($action, ReportAlert $model, $key, $index, $column) {
                                return Url::toRoute([$action, 'id' => $model->id]);
                            },
                            'template' => '{view} {update} {delete}',
                            'buttons' => [
                                'delete' => function ($url, ReportAlert $model, $key) {
                                    return Html::a('<i class="fas fa-trash-alt"></i>', 'javascript:void(0)', [
                                        'title' => Yii::t('yii', 'Delete'),
                                        'aria-label' => Yii::t('yii', 'Delete'),
                                        'data-reload-pjax-container' => 'p-jax-report-alert',
                                        'data-pjax' => '0',
                                        'data-url' => Url::to(['report-alert/delete', 'id' => $model->id]),
                                        'class' => 'p-jax-btn text-danger',
                                        'data-title' => Yii::t('yii', 'Delete'),
                                        'data-toggle' => 'tooltip',
                                    ]);
                                },
                                'update' => function ($url, ReportAlert $model, $key) {
                                    return Html::a('<i class="fas fa-edit"></i>', "javascript:void(0)", [
                                        'data-pjax' => '0',
                                        'class' => "btn text-primary p-0 mr-2",
                                        'data-size' => 'modal-dialog-centered modal-xxl',
                                        'data-title' => Yii::t('biDashboard', 'update'),
                                        'data-toggle' => 'modal',
                                        'data-target' => '#modal-pjax-bi',
                                        'data-url' => Url::to(['report-alert/update', 'id' => $model->id]),
                                        'data-handle-form-submit' => 1,
                                        'data-reload-pjax-container' => 'p-jax-report-alert'
                                    ]);
                                },
                                'view' => function ($url, ReportAlert $model, $key) {
                                    if($model->state == ReportAlert::STATE_ALERTING){
                                        return Html::a('<i class="fas fa-bells"></i>', "javascript:void(0)", [
                                            'data-pjax' => '0',
                                            'class' => "btn text-danger p-0 mr-2",
                                            'data-size' => 'modal-dialog-centered modal-xl',
                                            'data-title' => Yii::t('biDashboard', 'Fired Alerts'),
                                            'data-toggle' => 'modal',
                                            'data-target' => '#modal-pjax-bi',
                                            'data-url' => Url::to(['report-alert/view', 'alert_id' => $model->id]),
                                            'data-handle-form-submit' => 1,
                                            'data-reload-pjax-container' => 'p-jax-report-alert'
                                        ]);
                                    }
                                    else {
                                        return '';
                                    }
                                },
                            ],
                        ],
                    ],
                    'summary' => "",
                ]); ?>
            </div>
        </div>
    </div>
    <?php Pjax::end(); ?>
</div>