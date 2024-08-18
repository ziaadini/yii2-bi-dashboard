<?php

use ziaadini\bidashboard\models\ReportModelClass;
use yii\helpers\Html;
use yii\helpers\Url;
use ziaadini\bidashboard\widgets\grid\ActionColumn;
use ziaadini\bidashboard\widgets\grid\GridView;

use yii\widgets\Pjax;

/** @var yii\web\View $this */
/** @var ziaadini\bidashboard\models\ReportModelClassSearch $searchModel */
/** @var yii\data\ActiveDataProvider $dataProvider */

$this->title = Yii::t('biDashboard', 'Report Model Classes');
$this->params['breadcrumbs'][] = $this->title;
?>


<div class="page-content container-fluid text-left" id="main-wrapper">
    <?php Pjax::begin(['id' => 'p-jax-report-model-class-index', 'enablePushState' => false]); ?>
    <div class="work-report-index card">
        <div class="panel-group m-bot20" id="accordion">
            <div class="card-header d-flex justify-content-between">
                <h4 class="panel-title">
                    <a class="accordion-toggle collapsed" data-toggle="collapse" data-parent="#accordion"
                        href="#collapseSearch" aria-expanded="false">
                        <i class="fa fa-search"></i> جستجو
                    </a>
                </h4>
            </div>
            <div class="card-body page-content container-fluid text-left">
                <div id="collapseSearch" class="panel-collapse collapse" aria-expanded="false">
                    <?= $this->render('_search', ['model' => $searchModel]); ?>
                </div>
                <?= GridView::widget([
                    'dataProvider' => $dataProvider,
                    'columns' => [
                        ['class' => 'yii\grid\SerialColumn'],
                        'model_class',
                        'title',
                        [
                            'class' => ActionColumn::class,
                            'urlCreator' => function ($action, ReportModelClass $model, $key, $index, $column) {
                                return Url::toRoute([$action, 'id' => $model->id]);
                            },
                            'template' => '{update}',
                            'buttons' => [
                                'update' => function ($url, ReportModelClass $model, $key) {
                                    return Html::a(
                                        '<i class="fa fa-pen"></i>',
                                        "javascript:void(0)",
                                        [
                                            'data-pjax' => '0',
                                            'class' => "btn text-primary",
                                            'data-size' => 'modal-md',
                                            'data-title' => Yii::t('biDashboard', 'update'),
                                            'data-toggle' => 'modal',
                                            'data-target' => '#modal-pjax-bi',
                                            'data-url' => Url::to(['report-model-class/update', 'id' => $model->id]),
                                            'data-handle-form-submit' => 1,
                                            'data-reload-pjax-container' => 'p-jax-report-model-class-index'
                                        ]
                                    );
                                }
                            ],
                        ],
                    ],
                ]); ?>
            </div>
        </div>
    </div>
    <?php Pjax::end(); ?>
</div>