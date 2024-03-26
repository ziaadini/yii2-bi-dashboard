<?php
use yii\helpers\Html;
use yii\web\View;
use sadi01\bidashboard\models\ReportBoxWidgets;
use sadi01\bidashboard\models\ReportYear;
use sadi01\bidashboard\models\ReportBox;
use yii\helpers\Url;
use miloschuman\highcharts\Highcharts;
use miloschuman\highcharts\Highmaps;
use miloschuman\highcharts\GanttChart;
use miloschuman\highcharts\HighchartsAsset;

/** @var ReportBox $box */
HighchartsAsset::register($this)->withScripts(['modules/stock', 'modules/exporting', 'modules/drilldown']);

$this->registerJsFile('https://code.highcharts.com/modules/wordcloud.js', [
    'depends' => 'miloschuman\highcharts\HighchartsAsset'
]);
$script = <<< JS
    $(document).ready(function() {
        $("#select_year_$box->id, #select_month_$box->id, #select_day_$box->id").on("change", function() {
            
            const selectedYear = $("#select_year_$box->id").val();
            const selectedMonth = $("#select_month_$box->id").val();
            const selectedDay = $("#select_day_$box->id").val();
            
            // Construct the URL based on the selected values
            const constructedUrl = '/bidashboard/report-box/run-box?id='+$box->id+'&'+'year='+selectedYear+'&month='+selectedMonth+'&day='+selectedDay;
        
            // Update the data-url attribute
            $("#sync_btn_$box->id").attr("data-url", constructedUrl);
        });
    });
JS;
$this->registerJs($script);

$pdate = Yii::$app->pdate;

?>

<div class="border bg-white rounded-md shadow mb-2 text-center">
    <div class="card-header d-flex align-items-center justify-content-between px-3">
        <span><?= $box->title ?? 'عنوان باکس' ?> | <span class="font-12 font-normal">(<?= ReportBox::itemAlias('RangeType', $box->range_type) ?>)</span></span>
        <div class="d-flex align-items-center">
            <div class="d-flex align-items-center">
                <div class="d-flex mr-1">
                    <?php if ($box->range_type == ReportBox::RANGE_TYPE_DAILY): ?>
                        <div>
                            <select name="month" class="form-control rounded-md" id="select_month_<?= $box->id ?>">
                                <?php for ($i = 1; $i <= 12; $i++): ?>
                                    <option value="<?= $i ?>" <?= $box->lastDateSet['month'] == $i ? 'selected' : '' ?> ><?= $pdate->jdate_words(['mm' => $i])['mm'] ?></option>
                                <?php endfor; ?>
                            </select>
                        </div>
                        <div class="px-1">
                            <select name="year" class="form-control rounded-md" id="select_year_<?= $box->id ?>">
                                <?php foreach (ReportYear::itemAlias('List') as $Year): ?>
                                    <option <?= $Year ?> <?= $box->lastDateSet['year'] == $Year ? 'selected' : '' ?> ><?= $Year ?></option>
                                <?php endforeach; ?>
                            </select>
                        </div>
                    <?php elseif ($box->range_type == ReportBox::RANGE_TYPE_MONTHLY): ?>
                        <div class="px-1">
                            <select name="year" class="form-control rounded-md" id="select_year_<?= $box->id ?>">
                                <?php foreach (ReportYear::itemAlias('List') as $Year): ?>
                                    <option <?= $Year ?> <?= $box->lastDateSet['year'] == $Year ? 'selected' : '' ?> ><?= $Year ?></option>
                                <?php endforeach; ?>
                            </select>
                        </div>
                    <?php endif; ?>
                </div>
                <?= Html::a('<i class="fas fa-sync text-success font-18"></i>', "javascript:void(0)",
                    [
                        'id' => 'sync_btn_'.$box->id,
                        'title' => Yii::t('biDashboard', 'Update Box'),
                        'aria-label' => Yii::t('yii', 'Update Box'),
                        'data-reload-pjax-container' => 'p-jax-report-dashboard-view',
                        'data-pjax' => '0',
                        'data-url' => Url::to(['/bidashboard/report-box/run-box', 'id' => $box->id, 'year' => $box->lastDateSet['year'], 'month' => $box->lastDateSet['month'], 'day' => $box->lastDateSet['day']]),
                        'class' => "p-jax-btn d-flex",
                        'data-title' => Yii::t('biDashboard', 'Update Box'),
                        'data-toggle' => 'tooltip',
                    ]) ?>
                <span class="font-bold mx-3 mt-1 text-secondary">|</span>
            </div>
            <?= Html::a('<i class="fas fa-edit text-info font-18"></i>', "javascript:void(0)",
                [
                    'data-pjax' => '0',
                    'class' => "d-flex mr-2",
                    'data-size' => 'modal-xl',
                    'data-title' => Yii::t('biDashboard', 'Edit Box'),
                    'data-toggle' => 'modal',
                    'data-target' => '#modal-pjax-bi',
                    'data-url' => Url::to(['report-box/update', 'id' => $box->id]),
                    'data-handle-form-submit' => 1,
                    'data-reload-pjax-container' => 'p-jax-report-dashboard-view'
                ]) ?>
            <?= Html::a('<i class="fas fa-trash-alt text-danger font-18"></i>', "javascript:void(0)",
                [
                    'title' => Yii::t('biDashboard', 'Delete Box'),
                    'aria-label' => Yii::t('yii', 'Delete Box'),
                    'data-reload-pjax-container' => 'p-jax-report-dashboard-view',
                    'data-pjax' => '0',
                    'data-url' => Url::to(['/bidashboard/report-box/delete', 'id' => $box->id]),
                    'class' => "p-jax-btn d-flex",
                    'data-title' => Yii::t('biDashboard', 'Delete Box'),
                    'data-toggle' => 'tooltip',
                ]) ?>
        </div>
    </div>
    <?php if (!empty($box->chartSeries)): ?>
        <?= Highcharts::widget([
            'options' => [
                'scripts' => [
                    'modules/exporting',
                    'themes/grid',
                ],
                'accessibility' => [
                    'enabled' => false
                ],
                'chart' => [
                    'style' => [
                        'fontFamily' => 'IRANSans, sans-serif',
                        'direction' => 'ltr',
                    ],
                    'type' => ReportBox::itemAlias('ChartTypes', $box->chart_type),
                    'className' => 'high-chart'
                ],
                'lang' => [
                    'printChart' => 'چاپ نمودار',
                    'downloadPNG' => 'PNG دانلود تصویر',
                    'downloadJPEG' => 'JPEG دانلود تصویر',
                    'downloadPDF' => 'PDF دانلود فایل',
                    'downloadSVG' => 'SVG دانلود فایل',
                    'viewFullscreen' => 'مشاهده در حالت تمام صفحه',
                ],
                'title' => [
                    'text' => '' ,
                ],
                'xAxis' => [
                    'categories' => $box->chartCategories
                ],
                'yAxis' => [
                    'title' => [
                        'text' => 'مقدار'
                    ]
                ],
                'series' => $box->chartSeries
            ]
        ]); ?>
    <?php else: ?>
        <div class="d-flex align-items-center justify-content-center min-h-96 w-100">
            <span class="text-muted">این باکس خالی است!</span>
        </div>
    <?php endif; ?>
    <div class="card-footer d-flex align-items-center justify-content-between px-3">
        <span class="text-muted font-12 mr-3"><?= $box->description ?? '(توضیحات باکس)' ?></span>
        <div class="d-flex">
            <button type="button" class="btn btn-sm btn-warning disabled mr-2 rounded-md shadow-none"> بروزرسانی:
                <?php if ($box->last_run != 0): ?>
                    <?= Yii::$app->formatter->asRelativeTime($box->last_run, 'now'); ?>
                <?php endif; ?>
            </button>
            <?= Html::a(Yii::t('biDashboard', 'Add and Edit Widgets'), "javascript:void(0)",
                [
                    'data-pjax' => '0',
                    'class' => "btn btn-info btn-sm rounded-md font-12",
                    'data-size' => 'modal-xl',
                    'data-title' => Yii::t('biDashboard', 'Add and Edit Widgets'),
                    'data-toggle' => 'modal',
                    'data-target' => '#modal-pjax-bi',
                    'data-url' => Url::to(['report-box-widget/update', 'boxId' => $box->id]),
                    'data-handle-form-submit' => 1,
                    'data-reload-pjax-container' => 'p-jax-report-dashboard-view'
                ]) ?>
            <div class="d-flex align-items-center ml-2">
                <?= Html::a('<i class="fas fa-arrow-up font-light"></i>', 'javascript:void(0)',
                    [
                        'title' => Yii::t('biDashboard', 'Moving'),
                        'data-confirm-alert' => 0,
                        'aria-label' => Yii::t('yii', 'Moving'),
                        'data-reload-pjax-container' => 'p-jax-report-dashboard-view',
                        'data-pjax' => '0',
                        'data-url' => Url::to(['/bidashboard/report-box/dec-order', 'id' => $box->id]),
                        'class' => "p-jax-btn text-secondary mr-2",
                        'data-title' => Yii::t('biDashboard', 'Moving'),
                        'data-toggle' => 'tooltip',
                    ]); ?>
                <?= Html::a('<i class="fas fa-arrow-down font-light"></i>', 'javascript:void(0)',
                    [
                        'title' => Yii::t('biDashboard', 'Moving'),
                        'data-confirm-alert' => 0,
                        'aria-label' => Yii::t('yii', 'Moving'),
                        'data-reload-pjax-container' => 'p-jax-report-dashboard-view',
                        'data-pjax' => '0',
                        'data-url' => Url::to(['/bidashboard/report-box/inc-order', 'id' => $box->id]),
                        'class' => "p-jax-btn text-secondary",
                        'data-title' => Yii::t('biDashboard', 'Moving'),
                        'data-toggle' => 'tooltip',
                    ]); ?>
            </div>
        </div>
    </div>
</div>
