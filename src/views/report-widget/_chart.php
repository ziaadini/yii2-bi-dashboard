<?php

use yii\helpers\Html;
use miloschuman\highcharts\Highcharts;
use yii\helpers\Url;
use yii\widgets\Pjax;
use sadi01\bidashboard\models\ReportWidgetResult;
use yii\web\JsExpression;


/**
 * @var yii\web\View $this
 * @var sadi01\bidashboard\models\ReportWidget $widget
 * @var $titles array
 * @var $results array
 * @var $chart_type string
 * @var $field string
 * @var $max integer
 * @var $start_range integer
 * @var $end_range integer
 */
$this->title = Yii::t('biDashboard', 'Chart');
$this->params['breadcrumbs'][] = ['label' => Yii::t('biDashboard', 'Chart'), 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="report-widget-create">
    <div class="page-content container-fluid text-left">
        <div class="work-report-index card">
            <div class="panel-group m-bot20" id="accordion">
                <?php Pjax::begin(['id' => 'p-jax-report-page-widget-chart', 'enablePushState' => false,'clientOptions' => ['push' => false],]); ?>
                <div class="card-body text-center">
                    <?php if (!empty($results)): ?>
                        <?= Html::dropDownList('your-dropdown-name', Yii::$app->request->get('chart_type'), ReportWidgetResult::itemAlias('Chart'), [
                            'id' => 'chart_type_id',
                            'class' => 'form-control col-sm-3',
                            'onchange' => 'pjaxChartReload()',
                        ]);
                        ?>
                        <?= Highcharts::widget([
                            'options' => [
                                'chart' => ['type' => $chart_type],
                                'title' => [
                                    'text' => $widget->title
                                ],
                                'xAxis' => [
                                    'categories' => $titles
                                ],
                                'yAxis' => [
                                    'title' => [
                                        'text' => $widget->title
                                    ],
                                    'min' => 0,
                                    'max' => $results ? max($results) : 0,
                                    'tickInterval' => 10
                                ],
                                'series' => [
                                    [
                                        'name' => $widget->title,
                                        'data' => $results
                                    ],
                                ],
                                'plotOptions' => [
                                    'pie' => [
                                        'allowPointSelect' => true,
                                        'cursor' => 'pointer',
                                        'dataLabels' => [
                                            'enabled' => true,
                                        ],
                                    ],
                                ]
                            ]
                        ]);
                        ?>
                    <?php else: ?>
                    <div class="alert alert-danger" role="alert"><?= Yii::t("biDashboard", 'No Data')?></div>
                    <div class="alert alert-danger" role="alert"><?= Yii::t("biDashboard", 'Please run widget/widgets first')?></div>
                    <?php endif; ?>
                </div>
                <?php Pjax::end(); ?>
            </div>
        </div>
    </div>
</div>
<script>
    function pjaxChartReload() {
        var chart_type = $('#chart_type_id').val();
        var urlPjax = "/bidashboard/report-widget/modal-show-chart?id=<?=$widget->id?>&field=<?=$field?>&start_range=<?=$start_range?>&end_range=<?=$end_range?>&chart_type="+chart_type;
        $.pjax.reload({
            container: '#p-jax-report-page-widget-chart',
            replace: false ,
            url: urlPjax,
            push: false,
        });
    }
</script>