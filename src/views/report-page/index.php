<?php

use sadi01\bidashboard\models\ReportPage;


use yii\bootstrap4\Modal;
use yii\grid\ActionColumn;

use yii\grid\GridView;
use yii\helpers\Html;
use yii\helpers\Url;
use yii\widgets\Pjax;


$this->title = Yii::t('app', 'Report Pages');
$this->params['breadcrumbs'][] = $this->title;
?>

<div class="page-content container-fluid text-left pt-5">
    <?php Pjax::begin(['id' => 'p-jax-report-page', 'enablePushState' => false]); ?>

    <?php
    Modal::begin([
        'headerOptions' => ['id' => 'modalPjaxHeader'],
        'id' => 'modal-pjax',
        'bodyOptions' => [
            'id' => 'modalPjaxContent',
            'class' => 'p-3',
            'data' => ['show-preloader' => 0]
        ],
        'options' => ['tabindex' => false]
    ]); ?>

    <?php Modal::end() ?>
    <div class="work-report-index card">
        <div class="panel-group m-bot20" id="accordion">
            <div class="card-header d-flex justify-content-between">
                <h4 class="panel-title">
                    <a class="accordion-toggle collapsed" data-toggle="collapse" data-parent="#accordion"
                       href="#collapseSearch" aria-expanded="false">
                        <i class="mdi mdi-search-web"></i> جستجو
                    </a>
                </h4>
                <div>
                    <?= Html::a(Yii::t('app', 'create'), "javascript:void(0)",
                        [
                            'data-pjax' => '0',
                            'class' => "btn btn-primary",
                            'data-size' => 'modal-xl',
                            'data-title' => Yii::t('app', 'create'),
                            'data-toggle' => 'modal',
                            'data-target' => '#modal-pjax',
                            'data-url' => Url::to(['report-page/create']),
                            'data-handle-form-submit' => 1,
                            'data-show-loading' => 0,
                            'data-reload-pjax-container' => 'p-jax-report-page',
                            'data-reload-pjax-container-on-show' => 0
                        ]) ?>
                </div>
            </div>
            <div class="card-body">
                <div class="modal fade top-modal-with-space" id="quickAccessModal" tabindex="-1" role="dialog"
                     aria-labelledby="myModalLabel" aria-hidden="true">
                    <div class="modal-dialog modal-md">
                        <div class="modal-content-wrap">
                            <div class="modal-content">
                                <div class="modal-header">
                                    <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
                                    <h4 class="modal-title">
                                        <span class="modal-title fas fa-rabbit-fast fa-2x text-danger"></span>
                                    </h4>
                                </div>
                                <div class="modal-body">
                                    <div id="accordionHelp" class="card material-card mt-3 mb-0 panel-group">
                                        <div id="collapseHelp" class="card-body panel-collapse collapse"
                                             aria-expanded="false">
                                            <div class="feed-widget d-flex justify-content-between">
                                                <ul class="feed-body list-style-none w-100">
                                                    <li class="feed-item d-flex align-items-center justify-content-between py-2">
                                                    </li>
                                                    <li class="feed-item d-flex align-items-center justify-content-between py-2">

                                                    </li>
                                                    <hr>
                                                </ul>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div id="collapseSearch" class="panel-collapse collapse" aria-expanded="false">
                  <?= $this->render('_search', ['model' => $searchModel]); ?>
                </div>

                <?= GridView::widget([
                    'dataProvider' => $dataProvider,
                    'columns' => [
                        ['class' => 'yii\grid\SerialColumn'],
                        'title',
                        [
                            'attribute' => 'status',
                            'value' => function ($model) {

                                return ReportPage::itemAlias('Status',$model->status);
                            },
                        ],
                        [
                            'attribute' => 'range_type',
                            'value' => function ($model) {
                                return ReportPage::itemAlias('range_type',$model->range_type);
                            },
                        ],
                        'add_on',
                        [
                            'class' => ActionColumn::class,
                            'template' => '{view} {update} {delete}', // Specify the buttons you want to display
                            'buttons' => [
                                'delete' => function ($url, $model, $key) {
                                    return Html::a(Html::tag('span', Yii::t('app', 'Delete'), ['class' => "btn btn-sm"]), 'javascript:void(0)', [
                                        'title' => Yii::t('yii', 'Delete'),
                                        'aria-label' => Yii::t('yii', 'Delete'),
                                        'data-reload-pjax-container' => 'p-jax-report-page',
                                        'data-pjax' => '0',
                                        'data-url' => Url::to(['/report-page/delete', 'id' => $model->id]),
                                        'class' => "p-jax-btn",
                                        'data-title' => Yii::t('yii', 'Delete'),
                                        'data-toggle' => 'tooltip',
                                        'data-method' => '',
                                    ]);
                                },
                            ],
                            'urlCreator' => function ($action, ReportPage $model, $key, $index, $column) {
                                return Url::toRoute([$action, 'id' => $model->id]);
                            },
                        ],
                    ],
                ]); ?>

            </div>
        </div>
    </div>
<?php Pjax::end(); ?>
</div>
