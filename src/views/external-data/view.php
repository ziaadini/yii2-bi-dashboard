<?php

use yii\helpers\Html;
use yii\widgets\DetailView;
use yii\helpers\Url;
use yii\grid\GridView;
use  sadi01\bidashboard\models\ExternalDataValue;
use yii\grid\ActionColumn;

/** @var yii\web\View $this */
/** @var sadi01\bidashboard\models\ExternalData $model */
/** @var yii\data\ActiveDataProvider $dataProviderValue */

$this->title = $model->title;
$this->params['breadcrumbs'][] = ['label' => Yii::t('biDashboard', 'External Datas'), 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;

?>

<div class="report-widget-view">
    <div class="page-content container-fluid text-left">
        <div class="work-report-index card">
            <div class="panel-group m-bot20" id="accordion">
                <div class="card-header d-flex justify-content-between">
                    <h4 class="panel-title">
                        <?= Html::encode($this->title) ?>
                    </h4>
                </div>
                <div class="card-body">
                    <table class="table table-striped table-bordered">
                        <thead>
                        <tr>
                            <td><?= Yii::t('biDashboard', 'ID') ?></td>
                            <td><?= Yii::t('biDashboard', 'title') ?></td>
                            <td><?= Yii::t('biDashboard', 'Created at') ?></td>
                            <td><?= Yii::t('biDashboard', 'Updated at') ?></td>
                        </tr>
                        </thead>
                        <tbody>
                        <tr>
                            <td><?= $model->id ?></td>
                            <td><?= $model->title ?></td>
                            <td><?= Yii::$app->pdate->jdate('Y/m/d-h:i', $model->created_at) ?></td>
                            <td><?= Yii::$app->pdate->jdate('Y/m/d-h:i', $model->updated_at) ?></td>
                        </tr>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>

<div class="report-widget-view">
    <div class="page-content container-fluid text-left">
        <div class="work-report-index card">
            <div class="panel-group m-bot20" id="accordion">
                <div class="card-header d-flex justify-content-between">
                    <h4 class="panel-title">
                        <?= Yii::t('biDashboard', 'External Data Values') ?>
                    </h4>
                    <div>
                        <?= Html::a(Yii::t('biDashboard', 'Add new value'), "javascript:void(0)",
                            [
                                'data-pjax' => '0',
                                'class' => "btn btn-success",
                                'data-size' => 'modal-md',
                                'data-title' => Yii::t('app', 'create'),
                                'data-toggle' => 'modal',
                                'data-target' => '#modal-pjax',
                                'data-url' => Url::to(['/bidashboard/external-data-value/create', 'external_data_id' => $model->id]),
                                'data-handle-form-submit' => 1,
                                'data-reload-pjax-container' => 'p-jax-report-year'
                            ])
                        ?>
                    </div>
                </div>
                <div class="card-body">
                    <?= GridView::widget([
                        'dataProvider' => $dataProviderValue,
                        'columns' => [
                            [
                                'class' => 'yii\grid\SerialColumn'
                            ],
                            'value',
                            [
                                'attribute' => 'created_at',
                                'value' => function($item){
                                    return Yii::$app->pdate->jdate('Y/m/d-h:i', $item->created_at);
                                }
                            ],
                            [
                                'attribute' => 'created_by',
                            ],
                            [
                                'class' => ActionColumn::class,
                                'template' => '{update} {delete}',
                                'urlCreator' => function ($action, ExternalDataValue $model, $key, $index, $column) {
                                    return Url::toRoute(['/bidashboard/external-data-value/'.$action, 'id' => $model->id]);
                                }
                            ],
                        ],
                    ]); ?>
                </div>
            </div>
        </div>
    </div>
</div>