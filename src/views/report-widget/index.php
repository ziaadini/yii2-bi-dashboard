<?php

use sadi01\bidashboard\models\ReportWidget;
use sadi01\bidashboard\widgets\grid\ActionColumn;
use sadi01\bidashboard\widgets\grid\GridView;
use yii\helpers\Html;
use yii\helpers\Url;

use yii\widgets\Pjax;

/** @var yii\web\View $this */
/** @var sadi01\bidashboard\models\search\ReportWidgetSearch $searchModel */
/** @var yii\data\ActiveDataProvider $dataProvider */

$this->title = Yii::t('biDashboard', 'Report Widgets');
$this->params['breadcrumbs'][] = $this->title;
?>

<div class="page-content container-fluid text-left pt-5" id="main-wrapper">
    <?php Pjax::begin(['id' => 'p-jax-report-widget', 'enablePushState' => false]); ?>
    <div class="work-report-index card">
        <div class="panel-group m-bot20" id="accordion">
            <div class="card-header d-flex justify-content-between">
                <div class="d-flex align-items-center font-16 font-bold">
                    <span><?= Yii::t('biDashboard', 'Widget List') ?></span>
                </div>
                <?= $this->render('_search', ['model' => $searchModel]); ?>
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
                            'attribute' => 'range_type',
                            'value' => function (ReportWidget $model) {
                                return ReportWidget::itemAlias('RangeTypes', $model->range_type);
                            },
                        ],
                        'search_model_class',
                        'search_model_method',
                        [
                            'class' => ActionColumn::class,
                            'urlCreator' => function ($action, ReportWidget $model, $key, $index, $column) {
                                return Url::toRoute([$action, 'id' => $model->id]);
                            },
                            'template' => '{view} {delete}',
                            'buttons' => [
                                'delete' => function ($url, ReportWidget $model, $key) {
                                    return Html::a('<i class="fas fa-trash-alt"></i>', "javascript:void(0)",
                                        [
                                            'data-pjax' => '0',
                                            'class' => "btn text-danger",
                                            'data-size' => 'modal-dialog-centered modal-lg',
                                            'data-title' => Yii::t('biDashboard', 'Remove Widget'),
                                            'data-toggle' => 'modal',
                                            'data-target' => '#modal-pjax-bi',
                                            'data-url' => Url::to(['report-widget/delete', 'id' => $model->id]),
                                            'data-handle-form-submit' => 1,
                                            'data-reload-pjax-container' => 'p-jax-report-widget'
                                        ]);
                                },
                                'view' => function ($url, ReportWidget $model, $key) {
                                    return Html::a('<i class="fa fa-eye"></i>', "javascript:void(0)",
                                        [
                                            'data-pjax' => '0',
                                            'class' => "btn text-info p-0",
                                            'data-size' => 'modal-xl',
                                            'data-title' => Yii::t('biDashboard', 'view'),
                                            'data-toggle' => 'modal',
                                            'data-target' => '#modal-pjax-bi',
                                            'data-url' => Url::to(['report-widget/view', 'id' => $model->id]),
                                            'data-handle-form-submit' => 1,
                                            'data-reload-pjax-container' => 'p-jax-report-widget',
                                        ]
                                    );
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
