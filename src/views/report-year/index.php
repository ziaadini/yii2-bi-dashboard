<?php

use sadi01\bidashboard\models\ReportYear;
use sadi01\bidashboard\widgets\grid\ActionColumn;
use sadi01\bidashboard\widgets\grid\GridView;
use yii\helpers\Html;
use yii\helpers\Url;
use yii\widgets\Pjax;

/** @var yii\web\View $this */
/** @var sadi01\bidashboard\models\ReportYearSearch $searchModel */
/** @var yii\data\ActiveDataProvider $dataProvider */

$this->title = Yii::t('biDashboard', 'Report Years');
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="page-content container-fluid text-left pt-5  bg-white" id="main-wrapper">
    <?php Pjax::begin(['id' => 'p-jax-report-year', 'enablePushState' => false]); ?>
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
                    <?=
                    Html::a(Yii::t('biDashboard', 'create year'), "javascript:void(0)",
                        [
                            'data-pjax' => '0',
                            'class' => "btn btn-primary",
                            'data-size' => 'modal-md',
                            'data-title' => Yii::t('biDashboard', 'create'),
                            'data-toggle' => 'modal',
                            'data-target' => '#modal-pjax',
                            'data-url' => Url::to(['report-year/create']),
                            'data-handle-form-submit' => 1,
                            'data-reload-pjax-container' => 'p-jax-report-year'
                        ])
                    ?>
                </div>
            </div>
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
                'year',
                [
                    'attribute' => 'status',
                    'value' => function (ReportYear $model) {
                        return ReportYear::itemAlias('Status', $model->status);
                    },
                ],
                [
                    'class' => ActionColumn::class,
                    'urlCreator' => function ($action, ReportYear $model, $key, $index, $column) {
                        return Url::toRoute([$action, 'id' => $model->id]);
                    },
                    'template' => '{update} {delete}',
                    'buttons' => [
                        'delete' => function ($url, ReportYear $model, $key) {
                            return Html::a('<i class="fa fa-trash"></i>', 'javascript:void(0)', [
                                'title' => Yii::t('yii', 'Delete'),
                                'aria-label' => Yii::t('yii', 'Delete'),
                                'data-reload-pjax-container' => 'p-jax-report-year',
                                'data-pjax' => '0',
                                'data-url' => Url::to(['report-year/delete', 'id' => $model->id]),
                                'class' => 'p-jax-btn text-danger',
                                'data-title' => Yii::t('yii', 'Delete'),
                                'data-toggle' => 'tooltip',
                            ]);
                        },
                        'update' => function ($url, ReportYear $model, $key) {
                            return Html::a('<i class="fa fa-pen"></i>', "javascript:void(0)",
                                [
                                    'data-pjax' => '0',
                                    'class' => "btn text-primary",
                                    'data-size' => 'modal-md',
                                    'data-title' => Yii::t('biDashboard', 'update'),
                                    'data-toggle' => 'modal',
                                    'data-target' => '#modal-pjax',
                                    'data-url' => Url::to(['report-year/update', 'id' => $model->id]),
                                    'data-handle-form-submit' => 1,
                                    'data-reload-pjax-container' => 'p-jax-report-year'
                                ]
                            );
                        },
                    ],
                ],
            ],
        ]); ?>
    </div>
    <?php Pjax::end(); ?>
</div>