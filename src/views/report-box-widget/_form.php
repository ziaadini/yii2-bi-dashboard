<?php

use sadi01\bidashboard\models\ReportBoxWidgets;
use sadi01\bidashboard\models\ReportBox;
use sadi01\bidashboard\models\ReportWidget;
use wbraganca\dynamicform\DynamicFormWidget;
use yii\bootstrap4\ActiveForm;
use kartik\select2\Select2;
use kartik\depdrop\DepDrop;
use yii\helpers\Url;
use yii\helpers\Html;
use yii\web\View;

/** @var ReportBoxWidgets $modelsWidget */
/** @var ReportBox $modelBox */
/** @var ActiveForm $form */
/** @var View $this */
$js = '

jQuery(".dynamicform_wrapper").on("afterInsert", function(e, item) {

    jQuery(".dynamicform_wrapper .card-title-item").each(function(index) {
        jQuery(this).html("ویجت: " + (index + 1));
    });
    jQuery(item).find("select").each(function() {
        jQuery(this).val(null).trigger("change");
    });
    jQuery(item).find(".depdrop-field").each(function() {
        // Reset the DepDrop field
        jQuery(this).depdrop("reset");
    });
});

$(".dynamicform_wrapper").on("beforeDelete", function(e, item) {
    if (! confirm("ویجت حذف شود؟ ")) {
        return false;
    }
    return true;
});

jQuery(".dynamicform_wrapper").on("afterDelete", function(e) {
    jQuery(".dynamicform_wrapper .card-title-item").each(function(index) {
        jQuery(this).html("ویجت: " + (index + 1));
    });
});

$(".dynamicform_wrapper").on("limitReached", function(e, item) {
    alert("Limit reached");
});
';
$this->registerJs($js);
?>


<div class="box-form">

    <?php $form = ActiveForm::begin(['id' => 'dynamic-form', 'enableClientValidation' => true]); ?>

    <?= $form->field($modelBox, 'id')->hiddenInput(['value' => $modelBox->id])->label(false) ?>

    <?php DynamicFormWidget::begin([
        'widgetContainer' => 'dynamicform_wrapper',
        'widgetBody' => '.container-items',
        'widgetItem' => '.item',
        'limit' => 10,
        'min' => 1,
        'insertButton' => '.add-widget',
        'deleteButton' => '.remove-widget',
        'model' => $modelsWidget[0],
        'formId' => 'dynamic-form',
        'formFields' => [
            'widget_id',
            'widget_field',
            'title',
            'widget_field_format',
        ],
    ]); ?>

    <div class="card border rounded-md shadow-sm bg-slate-300">
        <div class="card-header border-bottom d-flex px-3 align-items-center justify-content-between">
            <div class="">
                <span>عنوان باکس: </span><span><?= $modelBox->title ?></span>

            </div>
            <button type="button" class="rounded-md add-widget btn btn-success btn-sm"><?= Yii::t('biDashboard', 'add widget') ?></button>
        </div>
        <div class="card-body container-items pb-0">
            <!-- widgetContainer -->
            <?php foreach ($modelsWidget as $index => $modelWidget): ?>
                <div class="item card border rounded-md shadow-sm">
                    <!-- widgetBody -->
                    <div class="px-3 py-2 border-bottom d-flex align-items-center justify-content-between">
                        <span class="card-title-item"> ویجت: <?= ($index + 1) ?></span>
                        <div class="">
                            <?php if ($modelWidget->widget !== null): ?>
                                <?= Html::a(
                                    Yii::t('biDashboard', 'Show model'),
                                    [$modelWidget->widget->getModelRoute()],
                                    [
                                        'data-pjax' => '0',
                                        'target' => '_blank',
                                        'class' => 'btn btn-info btn-sm rounded-md mr-1',
                                    ]
                                ) ?>
                            <?php endif; ?>
                            <button type="button" class="rounded-md remove-widget btn btn-danger btn-sm"><?= Yii::t('biDashboard', 'Remove Widget') ?></button>
                        </div>
                    </div>
                    <div class="card-body">
                        <?php
                        // necessary for update action.
                        if (!$modelWidget->isNewRecord) {
                            echo Html::activeHiddenInput($modelWidget, "[{$index}]id");
                        }
                        ?>
                        <div class="row justify-content-center">
                            <div class="col-3">
                                <?= $form->field($modelWidget, "[{$index}]widget_id")->widget(Select2::class, [
                                    'data' => ReportWidget::getWidgetList($modelBox->range_type),
                                    'options' => [
                                        'id' => "widget_id-{$index}",
                                        'placeholder' => 'ویجت مورد نظر را انتخاب کنید...',

                                    ],
                                    'pluginOptions' => [
                                        'allowClear' => true,
                                        'initialize' => !$modelBox->isNewRecord,
                                    ],
                                ])->label('ویجت'. ' '. '<span class="text-danger">*</span>'); ?>
                            </div>
                            <div class="col-3">
                                <?= $form->field($modelWidget, "[{$index}]widget_field")->widget(DepDrop::class, [
                                    'type' => DepDrop::TYPE_SELECT2,
                                    'options' => [
                                        'id' => "widget_field-{$index}",
                                        'placeholder' => 'فیلد خروجی ویجت را انتخاب کنید...',
                                        'class' => 'depdrop-field'
                                    ],
                                    'select2Options' => [
                                        'pluginOptions' => ['allowClear' => true]
                                    ],
                                    'pluginOptions' => [
                                        'depends' => ["widget_id-{$index}"],
                                        'initialize' => !$modelWidget->isNewRecord,
                                        'url' => Url::to(['/bidashboard/report-box-widget/get-widget-columns/'])
                                    ]
                                ])->label('فیلد خروجی ویجت'. ' '. '<span class="text-danger">*</span>'); ?>
                            </div>
                            <div class="col-3">
                                <?= $form->field($modelWidget, "[{$index}]title")->textInput([
                                    'placeholder' => 'پیش فرض عنوان ویجت می باشد.',
                                    'maxlength' => true,
                                    'class' => 'form-control rounded-md input-border'
                                ])->label('عنوان ویجت')
                                ?>
                            </div>
                            <div class="col-3">
                                <?= $form->field($modelWidget, "[{$index}]widget_field_format")->widget(Select2::class, [
                                    'data' => ReportBoxWidgets::itemAlias('Format'),
                                    'options' => [
                                        'id' => "widget_field_format-{$index}",
                                        'placeholder' => 'فرمت فیلد خروجی ویجت را انتخاب کنید...',
                                    ],
                                    'pluginOptions' => [
                                        'allowClear' => true,
                                        'initialize' => !$modelWidget->isNewRecord,
                                    ]
                                ])->label('فرمت فیلد خروجی ویجت'. ' '. '<span class="text-danger">*</span>'); ?>
                            </div>
                            <?php if ($modelBox->display_type === ReportBox::DISPLAY_CARD): ?>
                                <div class="col-3 mt-1">
                                    <?= $form->field($modelWidget, "[{$index}]widget_card_color")->widget(Select2::class, [
                                        'data' => ReportBoxWidgets::itemAlias('CardColorsName'),
                                        'options' => [
                                            'id' => "widget_card_color-{$index}",
                                            'placeholder' => 'رنگ کارت را انتخاب کنید...',
                                            'class' => 'widget-depdrop'
                                        ],
                                        'pluginOptions' => [
                                            'initialize' => !$modelWidget->isNewRecord,
                                            'allowClear' => true
                                        ],
                                    ])->label('رنگ کارت'); ?>
                                </div>
                            <?php endif; ?>
                        </div>
                    </div>
                </div>
            <?php endforeach; ?>
        </div>
        <div class="card-footer d-flex align-items-center justify-content-between">
            <div class="font-12 text-secondary">
                <span>توضیحات باکس: </span><span><?= $modelBox->description ?></span>
            </div>
            <div class="font-12 text-secondary">
                <span>نوع باکس: </span>
                <span>
                    <?php if ($modelBox->display_type === ReportBox::DISPLAY_CHART): ?>
                    <?= ReportBox::itemAlias('ChartNames', $modelBox->chart_type) ?>
                    <?php else: ?>
                    <?= ReportBox::itemAlias('DisplayTypes', $modelBox->display_type) ?>
                    <?php endif; ?>
                </span>
            </div>
        </div>
    </div>
    <?php DynamicFormWidget::end(); ?>

    <div class="d-flex justify-content-between">
        <div class="">
            <div class="d-flex">
                <span class="font-18 text-danger"> * </span>
                <span class="font-12 ml-2 text-bold text-muted">فیلدهای خروجی انتخابی در نمودار های ابرکلمات و دایره ای باید از یک نوع باشند (همگی عدد یا همگی مبلغ و... باشند)</span>
            </div>
            <div class="d-flex">
                <span class="font-18 text-danger"> * </span>
                <span class="font-12 ml-2 text-bold text-muted">در نمودار ها و کارت ها فیلد های خروجی انتخابی باید از نوع عددی باشند (تعداد، مبلغ و...) و نه از نوع عنوان (نام ماه و...)</span>
            </div>
        </div>
        <div class="d-flex align-items-center">
            <?= Html::submitButton(Yii::t('biDashboard', 'Save'), ['class' => 'btn btn-success rounded-md']) ?>
        </div>
    </div>
    <?php ActiveForm::end(); ?>
</div>
