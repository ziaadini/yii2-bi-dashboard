<?php

use ziaadini\bidashboard\models\ReportDashboard;
use ziaadini\bidashboard\models\ReportDashboardSearch;
use ziaadini\bidashboard\widgets\grid\ActionColumn;
use ziaadini\bidashboard\widgets\grid\GridView;
use yii\data\ActiveDataProvider;
use yii\helpers\Html;
use yii\helpers\Url;
use yii\web\View;
use yii\widgets\Pjax;

/** @var View $this */
/** @var ReportDashboardSearch $searchModel */
/** @var ActiveDataProvider $dataProvider */

$this->title = Yii::t('biDashboard', 'Report Dashboards');
$this->params['breadcrumbs'][] = ' ' . $this->title;

$this->registerJs("
    $('.daily-update-checkbox').on('change', function() {
        console.log('hi');
        var checkbox = $(this);
        var id = checkbox.val();
        var dailyUpdate = checkbox.is(':checked') ? 1 : 0;

        $.ajax({
            url: '" . \yii\helpers\Url::to(['report-dashboard/change-daily-update']) . "',
            type: 'POST',
            data: {
                id: id,
                daily_update: dailyUpdate,
                _csrf: yii.getCsrfToken()
            },
            success: function(data) {},
            error: function() {
                alert('خطا در تغییر بروزرسانی');
            }
        });
    });
");

?>

<div class="page-content container-fluid text-left pt-5" id="main-wrapper">
    <?php Pjax::begin(['id' => 'p-jax-report-dashboard', 'enablePushState' => false]); ?>
    <div class="work-report-index card">
        <div class="panel-group m-bot20" id="accordion">
            <div class="card-header d-flex justify-content-between">
                <div class="d-flex align-items-center font-16 font-bold">
                    <span><?= Yii::t('biDashboard', 'Dashboard List') ?></span></div>
                <?= $this->render('_search', ['model' => $searchModel]); ?>
                <div>
                    <?= Html::a(
                        Yii::t('biDashboard', 'create dashboard'),
                        "javascript:void(0)",
                        [
                            'data-pjax' => '0',
                            'class' => "btn btn-success rounded-md",
                            'data-size' => 'modal-lg modal-dialog-centered',
                            'data-title' => Yii::t('biDashboard', 'create dashboard'),
                            'data-toggle' => 'modal',
                            'data-target' => '#modal-pjax-bi',
                            'data-url' => Url::to(['report-dashboard/create']),
                            'data-handle-form-submit' => 1,
                            'data-reload-pjax-container' => 'p-jax-report-dashboard'
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
                        [
                            'attribute' => 'title',
                            'format' => 'raw',
                            'value' => function (ReportDashboard $model) {
                                return Html::a($model->title, ['/bidashboard/report-dashboard/view', 'id' => $model->id], [
                                    'title' => $model->title,
                                    'class' => 'btn text-info',
                                    'data-toggle' => 'tooltip',
                                    'data-pjax' => '0',
                                    'style' => 'font-size:18px;'
                                ]);
                            },
                        ],
                        'description',
                        [
                            'class' => \yii\grid\CheckboxColumn::class,
                            'checkboxOptions' => function ($model, $key, $index, $column) {
                                return [
                                    'id' => $model->id, // Unique ID for each checkbox
                                    'value' => $model->id,
                                    'checked' => $model->daily_update ? true : false,
                                    'class' => 'daily-update-checkbox',
                                ];
                            },
                            'header' => Yii::t('biDashboard', 'Daily update'),
                        ],
                        [
                            'attribute' => 'status',
                            'value' => function (ReportDashboard $model) {
                                return ReportDashboard::itemAlias('Status', $model->status);
                            },
                        ],
                        [
                            'class' => ActionColumn::class,
                            'template' => '{view} {delete}',
                            'urlCreator' => function ($action, ReportDashboard $model, $key, $index, $column) {
                                return Url::toRoute([$action, 'id' => $model->id]);
                            },
                            'template' => '{view} {update} {delete}',
                            'buttons' => [
                                'delete' => function ($url, ReportDashboard $model, $key) {
                                    return Html::a('<i class="fas fa-trash-alt"></i>', 'javascript:void(0)', [
                                        'title' => Yii::t('yii', 'Delete'),
                                        'aria-label' => Yii::t('yii', 'Delete'),
                                        'data-reload-pjax-container' => 'p-jax-report-dashboard',
                                        'data-pjax' => '0',
                                        'data-url' => Url::to(['report-dashboard/delete', 'id' => $model->id]),
                                        'class' => 'p-jax-btn text-danger mr-2',
                                        'data-title' => Yii::t('yii', 'Delete'),
                                        'data-toggle' => 'tooltip',
                                    ]);
                                },
                                'update' => function ($url, ReportDashboard $model, $key) {
                                    return Html::a('<i class="fas fa-edit"></i>', "javascript:void(0)", [
                                        'data-pjax' => '0',
                                        'class' => "btn text-primary",
                                        'data-size' => 'modal-dialog-centered modal-xl',
                                        'data-title' => Yii::t('biDashboard', 'update'),
                                        'data-toggle' => 'modal',
                                        'data-target' => '#modal-pjax-bi',
                                        'data-url' => Url::to(['report-dashboard/update', 'id' => $model->id]),
                                        'data-handle-form-submit' => 1,
                                        'data-reload-pjax-container' => 'p-jax-report-dashboard'
                                    ]);
                                },
                                'view' => function ($url, ReportDashboard $model, $key) {
                                    return Html::a('<i class="fas fa-eye"></i>', $url, [
                                        'title' => Yii::t('yii', 'View'),
                                        'aria-label' => Yii::t('yii', 'View'),
                                        'class' => 'btn text-info p-0',
                                        'data-toggle' => 'tooltip',
                                        'data-pjax' => '0',
                                    ]);
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