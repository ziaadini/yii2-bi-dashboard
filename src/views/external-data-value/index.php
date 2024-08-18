<?php

use Yii;

use yii\helpers\Url;
use ziaadini\bidashboard\widgets\grid\ActionColumn;
use ziaadini\bidashboard\widgets\grid\GridView;
use yii\widgets\Pjax;
use yii\helpers\Html;
use ziaadini\bidashboard\models\ExternalDataValue;
use ziaadini\bidashboard\widgets\ReportModalWidget;


/** @var yii\web\View $this */
/** @var ziaadini\bidashboard\models\ExternalDataSearch $searchModel */
/** @var yii\data\ActiveDataProvider $dataProvider */
/** @var yii\data\ActiveDataProvider $dataProviderValues */
/** @var array $queryParams */

$this->title = Yii::t('biDashboard', 'External Datas');
$this->params['breadcrumbs'][] = $this->title;
?>
<?php Pjax::begin(['id' => 'p-jax-external-data', 'enablePushState' => false]); ?>

<div class="page-content container-fluid text-left" id="main-wrapper">
    <div class="work-report-index card">
        <div class="panel-group m-bot20" id="accordion">
            <div class="card-header d-flex justify-content-between">
                <h4 class="panel-title pt-2">
                    <?= Yii::t('biDashboard', 'External Data Values'); ?>
                </h4>
                <div>
                    <?= ReportModalWidget::widget([
                        'queryParams' => $queryParams,
                        'searchModel' => $searchModel,
                        'searchModelMethod' => 'searchWidget',
                        'searchRoute' => Yii::$app->request->pathInfo,
                        'searchModelFormName' => key(Yii::$app->request->getQueryParams()),
                        'outputColumn' => [
                            "day" => "روز",
                            "year" => "سال",
                            "month" => "ماه",
                            "total_count" => "تعداد",
                            "total_amount" => "جمع‌کل"
                        ],
                    ]) ?>
                </div>
            </div>
            <div class="card-body page-content container-fluid text-left">
                <?= $this->render('_search', ['model' => $searchModel]); ?>

                <?= $this->render('/external-data-value/_nav') ?>

                <?= GridView::widget([
                    'dataProvider' => $dataProvider,
                    'columns' => [
                        ['class' => 'yii\grid\SerialColumn'],
                        [
                            'attribute' => 'external_data_id',
                            'label' => Yii::t('biDashboard', 'External Data'),
                            'value' => function (ExternalDataValue $item) {
                                return $item->externalData?->title;
                            }
                        ],
                        'value',
                        [
                            'attribute' => 'created_at',
                            'value' => function (ExternalDataValue $item) {
                                return Yii::$app->pdate->jdate('Y/m/d-h:i', $item->created_at);
                            }
                        ],
                        [
                            'class' => ActionColumn::class,
                            'template' => '{update} {delete}',
                            'urlCreator' => function ($action, ExternalDataValue $model, $key, $index, $column) {
                                return Url::toRoute(['/bidashboard/external-data-value/' . $action, 'id' => $model->id]);
                            },
                            'buttons' => [
                                'update' => function ($url, ExternalDataValue $model, $key) {
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

            </div>
        </div>
    </div>
</div>
<?php Pjax::end(); ?>