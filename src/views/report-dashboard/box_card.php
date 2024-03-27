<?php

use yii\helpers\Html;
use yii\web\View;
use sadi01\bidashboard\models\ReportBoxWidgets;
use sadi01\bidashboard\models\ReportYear;
use sadi01\bidashboard\models\ReportBox;
use yii\helpers\Url;

/** @var ReportBox $box */

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
<div class="m-2">
    <div class="card border rounded-md shadow mb-4">
        <div class="card-header d-flex align-items-center justify-content-between px-3">
            <span class="mr-3"><?= $box->title ?? 'عنوان باکس' ?>
                <?php if ($box->date_type == ReportBox::DATE_TYPE_FLEXIBLE): ?>
                    <span> | <span class="btn btn-sm btn-warning disabled px-1 py-0 rounded-md"><?= ReportBox::itemAlias('RangeType', $box->range_type) ?></span></span>
                <?php endif; ?>
            </span>
            <div class="d-flex align-items-center">
                <div class="d-flex align-items-center">
                    <div class="d-flex mr-1">
                        <?php if ($box->date_type == ReportBox::DATE_TYPE_FLEXIBLE): ?>
                            <?php if ($box->range_type == ReportBox::RANGE_TYPE_DAILY): ?>
                                <div class="px-1">
                                    <select name="day" class="form-control rounded-md btn-sm" id="select_day_<?= $box->id ?>">
                                        <?php for ($i = 1; $i <= 31; $i++): ?>
                                            <option value="<?= $i ?>" <?= $box->lastDateSet['day'] == $i ? 'selected' : '' ?> ><?= $i ?></option>
                                        <?php endfor; ?>
                                    </select>
                                </div>
                            <?php endif; ?>
                            <div>
                                <select name="month" class="form-control rounded-md btn-sm" id="select_month_<?= $box->id ?>">
                                    <?php for ($i = 1; $i <= 12; $i++): ?>
                                        <option value="<?= $i ?>" <?= $box->lastDateSet['month'] == $i ? 'selected' : '' ?> ><?= $pdate->jdate_words(['mm' => $i])['mm'] ?></option>
                                    <?php endfor; ?>
                                </select>
                            </div>
                            <div class="px-1">
                                <select name="year" class="form-control rounded-md btn-sm" id="select_year_<?= $box->id ?>">
                                    <?php foreach (ReportYear::itemAlias('List') as $Year): ?>
                                        <option <?= $Year ?> <?= $box->lastDateSet['year'] == $Year ? 'selected' : '' ?> ><?= $Year ?></option>
                                    <?php endforeach; ?>
                                </select>
                            </div>
                        <?php else: ?>
                            <button class="bg-white border border-warning btn btn-sm disabled mr-2 py-2 rounded-md shadow-none"><?= ReportBox::itemAlias('DateTypes', $box->date_type) ?></button>
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
                        'data-size' => 'modal-dialog-centered modal-xl',
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
        <div class="card-body row min-h-60">
            <?php if (!empty($box->boxWidgets)): ?>
                <?php foreach ($box->boxWidgets as $card): ?>
                    <div class="card shadow-sm text-white <?= $card->widget_card_color ? ReportBoxWidgets::itemAlias('CardColorsClass', $card->widget_card_color) : 'bg-secondary' ?> m-2 rounded-md min-width-card">
                        <div class="card-header px-2 d-flex justify-content-between align-items-center">
                            <?= Html::a(
                                $card->title ?? $card->widget->title,
                                [$card->widget->getModelRoute()],
                                [
                                    'data-pjax' => '0',
                                    'target' => '_blank',
                                    'class' => 'font-12 text-white',
                                ]
                            ) ?>
                            <div class="d-flex align-items-center">
                                <?= Html::a('<i class="fas fa-trash-alt text-danger font-14"></i>', "javascript:void(0)",
                                    [
                                        'title' => Yii::t('biDashboard', 'Delete'),
                                        'data-pjax' => '0',
                                        'class' => "p-jax-btn d-flex btn btn-light p-button",
                                        'data-url' => Url::to(['report-box-widget/delete', 'widgetId' => $card->id]),
                                        'data-handle-form-submit' => 1,
                                        'data-reload-pjax-container' => 'p-jax-report-dashboard-view',
                                        'data-toggle' => 'tooltip',
                                    ]) ?>
                            </div>
                        </div>
                        <div class="card-body">
                            <h2 class="text-center"><?= ReportBoxWidgets::getFormattedValue($card->widget_field_format, $card->cardResultCount) ?></h2>
                        </div>
                        <div class="card-footer d-flex justify-content-between align-items-center h6 p-2 mb-0">
                            <p class="mb-0"><?= $card->description ?></p>
                        </div>
                    </div>
                <?php endforeach; ?>
            <?php else: ?>
                <div class="d-flex align-items-center justify-content-center w-100">
                    <span class="text-muted">این باکس خالی است!</span>
                </div>
            <?php endif; ?>
        </div>
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
                        'data-size' => 'modal-xl modal-dialog-centered',
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
</div>
