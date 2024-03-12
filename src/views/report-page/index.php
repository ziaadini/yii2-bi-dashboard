<?php

use sadi01\bidashboard\models\ReportPage;
use sadi01\bidashboard\models\ReportPageSearch;
use sadi01\bidashboard\widgets\grid\ActionColumn;
use sadi01\bidashboard\widgets\grid\GridView;
use yii\data\ActiveDataProvider;
use yii\helpers\Html;
use yii\helpers\Url;
use yii\web\View;
use yii\widgets\Pjax;

/** @var View $this */
/** @var ReportPageSearch $searchModel */
/** @var ActiveDataProvider $dataProvider */

$this->title = Yii::t('biDashboard', 'Report Pages');
$this->params['breadcrumbs'][] = $this->title;

?>

<div class="page-content container-fluid text-left pt-5" id="main-wrapper">
    <?php Pjax::begin(['id' => 'p-jax-report-page', 'enablePushState' => false]); ?>
    <div class="work-report-index card">
        <div class="panel-group m-bot20" id="accordion">
            <div class="card-header d-flex justify-content-between">
                <h4 class="panel-title">
                    <a class="accordion-toggle collapsed" data-toggle="collapse" data-parent="#accordion"
                       href="#collapseSearch" aria-expanded="false">
                        <i class="fa fa-search"></i> جستجو
                    </a>
                </h4>
                <div>
                    <?= Html::a(Yii::t('biDashboard', 'create'), "javascript:void(0)",
                        [
                            'data-pjax' => '0',
                            'class' => "btn btn-primary",
                            'data-size' => 'modal-md',
                            'data-title' => Yii::t('biDashboard', 'create'),
                            'data-toggle' => 'modal',
                            'data-target' => '#modal-pjax-bi',
                            'data-url' => Url::to(['report-page/create']),
                            'data-handle-form-submit' => 1,
                            'data-reload-pjax-container' => 'p-jax-report-page'
                        ]) ?>
                </div>
            </div>
            <div class="card-body page-content container-fluid text-left">
                <div id="collapseSearch" class="panel-collapse collapse" aria-expanded="false">
                    <?= $this->render('_search', ['model' => $searchModel]); ?>
                </div>
                <?= GridView::widget([
                    'dataProvider' => $dataProvider,
                    'columns' => [
                        ['class' => 'yii\grid\SerialColumn'],
                        'id',
                        [
                            'attribute' => 'title',
                            'format' => 'raw',
                            'value' => function (ReportPage $model) {
                                return Html::a($model->title, ['/bidashboard/report-page/view','id' => $model->id ], [
                                    'title' => $model->title,
                                    'class' => 'btn text-info font-16',
                                    'data-toggle' => 'tooltip',
                                    'data-pjax' => '0',
                                ]);
                            },
                        ],
                        [
                            'attribute' => 'status',
                            'value' => function (ReportPage $model) {

                                return ReportPage::itemAlias('Status', $model->status);
                            },
                        ],
                        [
                            'attribute' => 'range_type',
                            'value' => function (ReportPage $model) {
                                return ReportPage::itemAlias('RangeType', $model->range_type);
                            },
                        ],
                        [
                            'class' => ActionColumn::class,
                            'template' => '{view} {delete}',
                            'urlCreator' => function ($action, ReportPage $model, $key, $index, $column) {
                                return Url::toRoute([$action, 'id' => $model->id]);
                            },
                            'template' => '{update} {delete} {view}',
                            'buttons' => [
                                'delete' => function ($url, ReportPage $model, $key) {
                                    return Html::a('<i class="fa fa-trash"></i>', 'javascript:void(0)', [
                                        'title' => Yii::t('yii', 'Delete'),
                                        'aria-label' => Yii::t('yii', 'Delete'),
                                        'data-reload-pjax-container' => 'p-jax-report-page',
                                        'data-pjax' => '0',
                                        'data-url' => Url::to(['report-page/delete', 'id' => $model->id]),
                                        'class' => 'p-jax-btn text-danger mr-2',
                                        'data-title' => Yii::t('yii', 'Delete'),
                                        'data-toggle' => 'tooltip',
                                    ]);
                                },
                                'update' => function ($url, ReportPage $model, $key) {
                                    return Html::a('<i class="fa fa-pen"></i>', "javascript:void(0)",
                                        [
                                            'data-pjax' => '0',
                                            'class' => "btn text-primary",
                                            'data-size' => 'modal-md',
                                            'data-title' => Yii::t('biDashboard', 'update'),
                                            'data-toggle' => 'modal',
                                            'data-target' => '#modal-pjax-bi',
                                            'data-url' => Url::to(['report-page/update', 'id' => $model->id]),
                                            'data-handle-form-submit' => 1,
                                            'data-reload-pjax-container' => 'p-jax-report-page'
                                        ]
                                    );
                                },
                                'view' => function ($url, ReportPage $model, $key) {
                                    return Html::a('<i class="fa fa-eye"></i>', $url, [
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
                ]); ?>
            </div>
        </div>
    </div>
    <?php Pjax::end(); ?>
</div>