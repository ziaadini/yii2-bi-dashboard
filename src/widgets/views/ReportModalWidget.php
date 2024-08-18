<?php

namespace ziaadini\bidashboard\widgets\views;

use ziaadini\bidashboard\BiAssets;
use Yii;
use yii\bootstrap4\Modal;
use yii\helpers\Url;
use yii\web\View;
use yii\widgets\Pjax;
use yii\helpers\Html;
use yii\bootstrap4\ActiveForm;
use yii\helpers\ArrayHelper;

$biAssets = BiAssets::register($this);
$url = $biAssets->baseUrl;

/**
 * @var $searchModel object
 * @var $searchRoute string
 * @var $searchModelMethod string
 * @var $searchModelRunResultView string
 * @var $searchModelFormName string
 * @var $queryParams array
 * @var $outputColumn array
 * @var $this View;
 */

?>

<?= Html::a(
    Html::tag('span', 'افزودن ویجت', ['class' => ['btn btn-info']]),
    "javascript:void(0)",
    [
        'data-pjax' => '0',
        'data-size' => 'modal-xl',
        'title' => Yii::t('biDashboard', 'Save As Report Widget'),
        'data-title' => Yii::t('biDashboard', 'Save As Report Widget'),
        'data-toggle' => 'modal',
        'data-target' => '#modal-pjax-bi',
        'data-url' => Url::to([
            '/bidashboard/report-widget/create',
            'searchModelClass' => $searchModel::class,
            'searchModelMethod' => $searchModelMethod,
            'searchModelRunResultView' => $searchModelRunResultView,
            'search_route' => $searchRoute,
            'search_model_form_name' => $searchModelFormName,
            'queryParams' => json_encode($queryParams),
            'output_column' => json_encode($outputColumn ?? []),
        ]),
        'data-handle-form-submit' => 1,
        'class' => 'm-1',
    ]
) ?>

<?= Html::a(
    Html::tag('span', 'لیست ویجت‌ها', ['class' => ['btn btn-info']]),
    "javascript:void(0)",
    [
        'data-pjax' => '0',
        'data-size' => 'modal-xl',
        'title' => Yii::t('biDashboard', 'Report Widgets'),
        'data-title' => Yii::t('biDashboard', 'Report Widgets'),
        'data-toggle' => 'modal',
        'data-target' => '#modal-pjax-bi',
        'data-url' => Url::to([
            '/bidashboard/report-widget/open-modal',
            'ReportWidgetSearch[search_model_class]' => $searchModel::class,
            'ReportWidgetSearch[search_model_method]' => $searchModelMethod,
        ]),
        'data-handle-form-submit' => 0,
        'class' => 'm-1',
    ]
) ?>

<?php if (Yii::$app->controller->module->layout !== 'bid_main') { ?>
    <?php
    Modal::begin([
        'headerOptions' => ['id' => 'modalPjaxOverHeader-bi'],
        'id' => 'modal-pjax-over-bi',
        'bodyOptions' => [
            'id' => 'modalPjaxOverContent-bi',
            'class' => 'p-3 text-left',
            'data' => ['show-preloader' => 0]
        ],
        'options' => ['tabindex' => false, 'style' => 'z-index:1051;']
    ]); ?>
    <div class="text-center">
        <div class="spinner-border text-info" role="status" style="width: 3rem; height: 3rem;">
            <span class="sr-only">Loading...</span>
        </div>
    </div>
    <?php Modal::end(); ?>
<?php } ?>

<?php if (Yii::$app->controller->module->layout !== 'bid_main') { ?>
    <?php
    Modal::begin([
        'headerOptions' => ['id' => 'modalPjaxHeader-bi'],
        'id' => 'modal-pjax-bi',
        'bodyOptions' => [
            'id' => 'modalPjaxContent-bi',
            'class' => 'p-3',
            'data' => ['show-preloader' => 0, 'pjax' => true]
        ],
        'options' => ['tabindex' => false]
    ]); ?>
    <div class="text-center">
        <div class="spinner-border text-info" role="status" style="width: 3rem; height: 3rem;">
            <span class="sr-only">Loading...</span>
        </div>
    </div>
    <?php Modal::end(); ?>
<?php } ?>