<?php

use yii\helpers\Html;
use miloschuman\highcharts\Highcharts;

/**
 * @var yii\web\View $this
 * @var sadi01\bidashboard\models\ReportWidget $widget
 * @var $titles array
 * @var $results array
 */
$this->title = Yii::t('biDashboard', 'Chart');
$this->params['breadcrumbs'][] = ['label' => Yii::t('biDashboard', 'Chart'), 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="report-widget-create">
    <div class="page-content container-fluid text-left">
        <div class="work-report-index card">
            <div class="panel-group m-bot20" id="accordion">
                <div class="card-body">
                    <div class="card-body">
                        <?= Highcharts::widget([
                            'options' => [
                                'title' => [
                                    'text' => $widget->title
                                ],
                                'xAxis' => [
                                    'categories' => $titles
                                ],
                                'yAxis' => [
                                    'title' => [
                                        'text' => $widget->title
                                    ]
                                ],
                                'series' => [
                                    [
                                        'type' => 'column',
                                        'name' => $widget->title,
                                        'data' => $results
                                    ],
                                    [
                                        'type' => 'line',
                                        'name' => $widget->title,
                                        'data' => $results
                                    ],
                                ]
                            ]
                        ]);
                        ?>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
