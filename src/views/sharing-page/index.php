<?php

use sadi01\bidashboard\models\SharingPage;
use yii\grid\ActionColumn;
use yii\grid\GridView;
use yii\helpers\Html;
use yii\helpers\Url;
use yii\widgets\Pjax;

/** @var yii\web\View $this */
/** @var \sadi01\bidashboard\models\SharingPageSearch $searchModel */
/** @var yii\data\ActiveDataProvider $dataProvider */

$this->title = Yii::t('biDashboard', 'Sharing Pages');
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="page-content container-fluid text-left pt-5 bg-white" id="main-wrapper">
    <?php Pjax::begin(['id' => 'p-jax-sharing-page']); ?>
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
                    <?= Html::a(Yii::t('biDashboard', 'create'), "javascript:void(0)",
                        [
                            'data-pjax' => '0',
                            'class' => "btn btn-primary",
                            'data-size' => 'modal-xl',
                            'data-title' => Yii::t('app', 'create'),
                            'data-toggle' => 'modal',
                            'data-target' => '#modal-pjax',
                            'data-url' => Url::to(['sharing-page/create']),
                            'data-handle-form-submit' => 1,
                            'data-reload-pjax-container' => 'p-jax-sharing-page'
                        ]) ?>
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
                [
                    'attribute' => 'page_id',
                    'value' => function ($model) {
                        return $model->page->title;
                    },
                ],
                [
                    'attribute' => 'status',
                    'value' => function ($model) {

                        return SharingPage::itemAlias('Status', $model->status);
                    },
                ],
                'access_key',
                'expire_time:datetime',
                [
                    'class' => ActionColumn::class,
                    'urlCreator' => function ($action, SharingPage $model, $key, $index, $column) {
                        return Url::toRoute([$action, 'id' => $model->id]);
                    },
                    'template' => '{custom-view} {custom-update} {custom-delete} {expire}', // Replace the default delete button with {custom-delete}
                    'visibleButtons' => [
                            'expire' => function($model) {

                            }
                    ],
                    'buttons' => [
                        'custom-delete' => function ($url, $model, $key) {
                            return Html::a('<i class="mdi mdi-delete"></i>', 'javascript:void(0)', [
                                'title' => Yii::t('yii', 'Delete'),
                                'aria-label' => Yii::t('yii', 'Delete'),
                                'data-reload-pjax-container' => 'p-jax-sharing-page',
                                'data-pjax' => '0',
                                'data-url' => Url::to(['/bidashboard/sharing-page/delete', 'id' => $model->id]),
                                'class' => 'p-jax-btn text-danger',
                                'data-title' => Yii::t('yii', 'Delete'),
                                'data-toggle' => 'tooltip',
                            ]);
                        },
                        'custom-update' => function ($url, $model, $key) {
                            return Html::a('<i class="mdi mdi-update"></i>', "javascript:void(0)",
                                [
                                    'data-pjax' => '0',
                                    'class' => "btn text-primary",
                                    'data-size' => 'modal-xl',
                                    'data-title' => Yii::t('app', 'create'),
                                    'data-toggle' => 'modal',
                                    'data-target' => '#modal-pjax',
                                    'data-url' => Url::to(['sharing-page/update', 'id' => $model->id]),
                                    'data-handle-form-submit' => 1,
                                    'data-reload-pjax-container' => 'p-jax-sharing-page'
                                ]
                            );
                        },
                        'custom-view' => function ($url, $model, $key) {
                            return Html::a('<i class="mdi mdi-eye"></i>', "javascript:void(0)",
                                [
                                    'data-pjax' => '0',
                                    'class' => "btn text-primary",
                                    'data-size' => 'modal-xl',
                                    'data-title' => Yii::t('app', 'view'),
                                    'data-toggle' => 'modal',
                                    'data-target' => '#modal-pjax',
                                    'data-url' => Url::to(['sharing-page/view', 'id' => $model->id]),
                                    'data-handle-form-submit' => 1,
                                    'data-reload-pjax-container' => 'p-jax-sharing-page'
                                ]
                            );
                        },
                        'expire' => function ($url, $model, $key) {
                            if ($model->expire_time > time()) {
                                return Html::a('<i class="mdi mdi-reload"></i>', 'javascript:void(0)', [
                                    'title' => Yii::t('yii', 'Expired'),
                                    'aria-label' => Yii::t('yii', 'Expired'),
                                    'data-reload-pjax-container' => 'p-jax-sharing-page',
                                    'data-pjax' => '0',
                                    'data-url' => Url::to(['/bidashboard/sharing-page/expire', 'id' => $model->id]),
                                    'class' => 'p-jax-btn btn-sm text-info',
                                    'data-title' => Yii::t('yii', 'Expired'),
                                ]);
                            } else {
                                return '';
                            }
                        },
                    ],
                ],

            ],
        ]); ?>
    </div>
    <?php Pjax::end(); ?>
</div>
