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

$this->title = Yii::t('app', 'Sharing Pages');
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="page-content container-fluid text-left pt-5" id="main-wrapper">
    <div class="work-report-index card">
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

            <?php // echo $this->render('_search', ['model' => $searchModel]); ?>
            <div class="card-body">
                <?= GridView::widget([
                    'dataProvider' => $dataProvider,
                    'filterModel' => $searchModel,
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
                            'class' => ActionColumn::className(),
                            'urlCreator' => function ($action, SharingPage $model, $key, $index, $column) {
                                return Url::toRoute([$action, 'id' => $model->id]);
                            }
                        ],
                    ],
                ]); ?>
            </div>

            <?php Pjax::end(); ?>
        </div>
    </div>

</div>
