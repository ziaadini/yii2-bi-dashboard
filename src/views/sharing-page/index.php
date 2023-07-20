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
<div class="page-content container-fluid text-left p-5" id="main-wrapper">
    <div class="work-report-index p-2 card">
        <div class="panel-group m-bot20" id="accordion">
            <?php Pjax::begin(['id' => 'p-jax-sharing-page']); ?>
            <h1><?= Html::encode($this->title) ?></h1>
            <p>
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
            </p>
            <?php  $this->render('_search', ['model' => $searchModel]); ?>
            <div class="card-body">
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
                        'access_key',
                        'expire_time:datetime',
                        [
                            'class' => ActionColumn::class,
                            'urlCreator' => function ($action, SharingPage $model, $key, $index, $column) {
                                return Url::toRoute([$action, 'id' => $model->id]);
                            },
                            'template' => '{view} {update} {delete} {expire}', // Add the custom template with the name of the action buttons you want to use.
                            'buttons' => [
                                'expire' => function ($url, $model, $key) {
                                    if ($model->expire_time > time()) {
                                        return Html::a('Expire', 'javascript:void(0)', [
                                            'title' => Yii::t('yii', 'Expired'),
                                            'aria-label' => Yii::t('yii', 'Expired'),
                                            'data-reload-pjax-container' => 'p-jax-sharing-page',
                                            'data-pjax' => '0',
                                            'data-url' => Url::to(['/bidashboard/sharing-page/expire', 'id_key' => $model->id, 'page_id' => $model->page_id]),
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
    </div>

</div>
