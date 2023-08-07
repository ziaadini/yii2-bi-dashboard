<?php

use sadi01\bidashboard\models\ExternalData;
use yii\helpers\Html;
use yii\helpers\Url;
use yii\grid\ActionColumn;
use yii\grid\GridView;
use yii\widgets\Pjax;
use Yii;
use sadi01\bidashboard\models\ExternalDataValue;


/** @var yii\web\View $this */
/** @var sadi01\bidashboard\models\ExternalDataSearch $searchModel */
/** @var yii\data\ActiveDataProvider $dataProvider */
/** @var yii\data\ActiveDataProvider $dataProviderValues */

$this->title = Yii::t('biDashboard', 'External Datas');
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="page-content container-fluid text-left pt-5" id="main-wrapper">
    <?php Pjax::begin(['id' => 'p-jax-report-page', 'enablePushState' => false]); ?>
    <div class="work-report-index card">
        <div class="panel-group m-bot20" id="accordion">
            <div class="card-header d-flex justify-content-between">
                <h4 class="panel-title pt-2">
                    <?= Yii::t('biDashboard', 'External Datas'); ?>
                </h4>
                <div>
                    <?=
                    Html::a(Yii::t('biDashboard', 'Create External Data'), "javascript:void(0)",
                        [
                            'data-pjax' => '0',
                            'class' => "btn btn-primary",
                            'data-size' => 'modal-md',
                            'data-title' => Yii::t('app', 'create'),
                            'data-toggle' => 'modal',
                            'data-target' => '#modal-pjax',
                            'data-url' => Url::to(['/bidashboard/external-data/create']),
                            'data-handle-form-submit' => 1,
                            'data-reload-pjax-container' => 'p-jax-report-year'
                        ])
                    ?>
                </div>
            </div>
            <div class="card-body page-content container-fluid text-left">
                <?= $this->render('_search', ['model' => $searchModel]); ?>

                <ul class="nav nav-tabs" id="myTab" role="tablist">
                    <li class="nav-item col-sm-6 text-center">
                        <a class="nav-link active" id="home-tab" data-toggle="tab"
                           href="#data_external" role="tab" aria-controls="data_external"
                           aria-selected="true"><?= Yii::t('biDashboard', 'Data External') ?></a>
                    </li>
                    <li class="nav-item col-sm-6 text-center">
                        <a class="nav-link" id="profile-tab" data-toggle="tab"
                           href="#data_external_value" role="tab" aria-controls="data_external_value"
                           aria-selected="false"><?= Yii::t('biDashboard', 'Data External Value') ?></a>
                    </li>
                </ul>
                <div class="tab-content" id="myTabContent">
                    <div class="tab-pane fade show active" id="data_external" role="tabpanel"
                         aria-labelledby="home-tab">
                        <?= GridView::widget([
                            'dataProvider' => $dataProvider,
                            'columns' => [
                                ['class' => 'yii\grid\SerialColumn'],

                                'id',
                                'title',
                                [
                                    'attribute' => 'created_at',
                                    'value' => function($item){
                                        return Yii::$app->pdate->jdate('Y/m/d-h:i', $item->created_at);
                                    }
                                ],
                                [
                                    'class' => ActionColumn::class,
                                    'urlCreator' => function ($action, ExternalData $model, $key, $index, $column) {
                                        return Url::toRoute([$action, 'id' => $model->id]);
                                    }
                                ],
                            ],
                        ]); ?>
                    </div>
                    <div class="tab-pane fade" id="data_external_value" role="tabpanel" aria-labelledby="profile-tab">
                        <?= GridView::widget([
                            'dataProvider' => $dataProviderValues,
                            'columns' => [
                                ['class' => 'yii\grid\SerialColumn'],
                                [
                                    'attribute' => 'external_data_value_id',
//                                    'value' => function($item){
//                                        return $item->
//                                    }
                                ],
                                'value',
                                [
                                    'attribute' => 'created_at',
                                    'value' => function($item){
                                        return Yii::$app->pdate->jdate('Y/m/d-h:i', $item->created_at);
                                    }
                                ],
                                [
                                    'class' => ActionColumn::class,
                                    'template' => '{update}',
                                    'urlCreator' => function ($action, ExternalDataValue $model, $key, $index, $column) {
                                        return Url::toRoute(['/bidashboard/external-data-value/' . $action, 'id' => $model->id]);
                                    }
                                ],
                            ],
                        ]); ?>
                    </div>
                </div>

            </div>
        </div>
    </div>
    <?php Pjax::end(); ?>
</div>