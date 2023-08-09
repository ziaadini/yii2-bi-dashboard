<?php

use yii\helpers\Html;
use yii\widgets\DetailView;
use yii\helpers\Url;
use sadi01\bidashboard\widgets\grid\ActionColumn;
use sadi01\bidashboard\widgets\grid\GridView;
use  sadi01\bidashboard\models\ExternalDataValue;
use yii\widgets\Pjax;

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

<?php Pjax::begin(['id' => 'p-jax-external-data', 'enablePushState' => false]); ?>

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
                                'data-title' => Yii::t('biDashboard', 'Add new value'),
                                'data-toggle' => 'modal',
                                'data-target' => '#modal-pjax',
                                'data-url' => Url::to(['/bidashboard/external-data-value/create', 'external_data_id' => $model->id]),
                                'data-handle-form-submit' => 1,
                                'data-reload-pjax-container' => 'p-jax-external-data-value'
                            ])
                        ?>
                    </div>
                </div>
                <div class="card-body">
                    <?php Pjax::begin(['id' => 'p-jax-external-data-value']); ?>

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
                                    return Url::toRoute(['/bidashboard/external-data-value/' . $action, 'id' => $model->id]);
                                },
                                'buttons' => [
                                    'update' => function ($url, ExternalDataValue $model, $key) {
                                        return Html::a('<i class="fa fa-pen"></i>', "javascript:void(0)",
                                            [
                                                'data-pjax' => '0',
                                                'class' => "btn text-primary",
                                                'data-size' => 'modal-md',
                                                'data-title' => Yii::t('biDashboard', 'update'),
                                                'data-toggle' => 'modal',
                                                'data-target' => '#modal-pjax',
                                                'data-url' => Url::to(['/bidashboard/external-data-value/update', 'id' => $model->id]),
                                                'data-handle-form-submit' => 1,
                                                'data-reload-pjax-container' => 'p-jax-external-data'
                                            ]
                                        );
                                    },
                                    'delete' => function ($url, ExternalDataValue $model, $key) {
                                        return Html::a('<i class="fa fa-trash"></i>', 'javascript:void(0)', [
                                            'title' => Yii::t('yii', 'Delete'),
                                            'aria-label' => Yii::t('yii', 'Delete'),
                                            'data-reload-pjax-container' => 'p-jax-external-data',
                                            'data-pjax' => '0',
                                            'data-url' => Url::to(['/bidashboard/external-data-value/delete', 'id' => $model->id]),
                                            'class' => 'p-jax-btn text-danger p-0',
                                            'data-title' => Yii::t('yii', 'Delete'),
                                            'data-toggle' => 'tooltip',
                                        ]);
                                    },
                                ],
                            ],
                        ],
                    ]); ?>
                    <?php Pjax::end(); ?>

                </div>
            </div>
        </div>
    </div>
</div>
<?php Pjax::end(); ?>
