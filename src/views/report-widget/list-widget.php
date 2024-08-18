<?php

use ziaadini\bidashboard\models\ReportWidget;
use yii\helpers\Html;
use yii\helpers\Url;
use ziaadini\bidashboard\widgets\grid\ActionColumn;
use ziaadini\bidashboard\widgets\grid\GridView;
use yii\web\View;
use ziaadini\bidashboard\models\search\ReportWidgetSearch;
use yii\data\ActiveDataProvider;
use yii\widgets\Pjax;

/** @var View $this */
/** @var ReportWidgetSearch $searchModel */
/** @var ActiveDataProvider $dataProvider */

$this->title = Yii::t('biDashboard', 'Report Widgets');
$this->params['breadcrumbs'][] = $this->title;
?>
<?= GridView::widget([
    'id' => 'widget-list',
    'dataProvider' => $dataProvider,
    'columns' => [
        ['class' => 'yii\grid\SerialColumn'],
        'id',
        'title',
        'description',
        [
            'attribute' => 'range_type',
            'value' => function ($data) {
                return $data->itemAlias('RangeTypes', $data->range_type);
            },
        ],
        [
            'attribute' => 'visibility',
            'value' => function ($data) {
                return $data->itemAlias('Visibility', $data->visibility);
            },
        ],
        [
            'class' => ActionColumn::class,
            'urlCreator' => function ($action, ReportWidget $model, $key, $index, $column) {
                return Url::toRoute([$action, 'id' => $model->id]);
            },
            'template' => '{view}',
            'buttons' => [
                'view' => function ($url, ReportWidget $model, $key) {
                    return Html::a(
                        '<i class="fa fa-eye"></i>',
                        "javascript:void(0)",
                        [
                            'data-pjax' => '0',
                            'class' => "btn text-info p-0",
                            'data-size' => 'modal-xl',
                            'data-title' => Yii::t('biDashboard', 'view'),
                            'data-toggle' => 'modal',
                            'data-target' => '#modal-pjax-over-bi',
                            'data-url' => Url::to(['report-widget/view', 'id' => $model->id]),
                            'data-handle-form-submit' => 1,
                            'data-reload-pjax-container' => 'p-jax-report-list-widgets-bi'
                        ]
                    );
                },
            ],
        ],
    ],
]); ?>