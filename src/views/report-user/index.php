<?php

use ziaadini\bidashboard\models\ReportUser;
use ziaadini\bidashboard\models\ReportUserSearch;
use ziaadini\bidashboard\widgets\grid\ActionColumn;
use ziaadini\bidashboard\widgets\grid\GridView;
use yii\data\ActiveDataProvider;
use yii\helpers\Html;
use yii\helpers\Url;
use yii\web\View;
use yii\widgets\Pjax;

/** @var View $this */
/** @var ReportUserSearch $searchModel */
/** @var ActiveDataProvider $dataProvider */

$this->title = Yii::t('biDashboard', 'Users');
$this->params['breadcrumbs'][] = ' ' . $this->title;

?>

<div class="page-content container-fluid text-left" id="main-wrapper">
    <?php Pjax::begin(['id' => 'p-jax-report-user', 'enablePushState' => false]); ?>
    <div class="work-report-index card">
        <div class="panel-group m-bot20" id="accordion">
            <div class="card-header d-flex justify-content-between">
                <div class="d-flex align-items-center font-16 font-bold">
                    <span><?= Yii::t('biDashboard', 'User List') ?></span></div>
                <?= $this->render('_search', ['model' => $searchModel]); ?>
                <div>
                    <?= Html::a(
                        Yii::t('biDashboard', 'Create User'),
                        "javascript:void(0)",
                        [
                            'data-pjax' => '0',
                            'class' => "btn btn-success rounded-md",
                            'data-size' => 'modal-dialog-centered modal-xl',
                            'data-title' => Yii::t('biDashboard', 'Create User'),
                            'data-toggle' => 'modal',
                            'data-target' => '#modal-pjax-bi',
                            'data-url' => Url::to(['report-user/create']),
                            'data-handle-form-submit' => 1,
                            'data-reload-pjax-container' => 'p-jax-report-user'
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
                        'first_name',
                        'last_name',
                        'phone_number',
                        'email',
                        [
                            'attribute' => 'status',
                            'value' => function (ReportUser $model) {
                                return ReportUser::itemAlias('Status', $model->status);
                            },
                        ],
                        [
                            'class' => ActionColumn::class,
                            'urlCreator' => function ($action, ReportUser $model, $key, $index, $column) {
                                return Url::toRoute([$action, 'id' => $model->id]);
                            },
                            'template' => '{update} {delete}',
                            'buttons' => [
                                'delete' => function ($url, ReportUser $model, $key) {
                                    return Html::a('<i class="fas fa-trash-alt"></i>', 'javascript:void(0)', [
                                        'title' => Yii::t('yii', 'Delete'),
                                        'aria-label' => Yii::t('yii', 'Delete'),
                                        'data-reload-pjax-container' => 'p-jax-report-user',
                                        'data-pjax' => '0',
                                        'data-url' => Url::to(['report-user/delete', 'id' => $model->id]),
                                        'class' => 'p-jax-btn text-danger mr-2',
                                        'data-title' => Yii::t('yii', 'Delete'),
                                        'data-toggle' => 'tooltip',
                                    ]);
                                },
                                'update' => function ($url, ReportUser $model, $key) {
                                    return Html::a('<i class="fas fa-edit"></i>', "javascript:void(0)", [
                                        'data-pjax' => '0',
                                        'class' => "btn text-primary",
                                        'data-size' => 'modal-dialog-centered modal-xl',
                                        'data-title' => Yii::t('biDashboard', 'update'),
                                        'data-toggle' => 'modal',
                                        'data-target' => '#modal-pjax-bi',
                                        'data-url' => Url::to(['report-user/update', 'id' => $model->id]),
                                        'data-handle-form-submit' => 1,
                                        'data-reload-pjax-container' => 'p-jax-report-user'
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