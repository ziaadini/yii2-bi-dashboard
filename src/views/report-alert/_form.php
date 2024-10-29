<?php

use ziaadini\bidashboard\models\ReportAlert;
use ziaadini\bidashboard\models\ReportWidget;
use kartik\select2\Select2;
use kartik\depdrop\DepDrop;
use yii\helpers\Url;
use yii\bootstrap4\ActiveForm;
use yii\helpers\Html;
use yii\web\View;
use yii\widgets\MaskedInput;

/** @var View $this */
/** @var ReportAlert $model */
/** @var ActiveForm $form */

?>


<div class="dashboard-form">

    <?php $form = ActiveForm::begin(['id' => 'dynamic-form', 'enableClientValidation' => true]); ?>

    <div class="row justify-content-center">
        <div class="col-3">
            <?= $form->field($model, 'title')->textInput([
                'placeholder' => 'عنوان هشدار...',
                'maxlength' => true,
                'class' => 'form-control rounded-md input-border'
            ])->label('عنوان هشدار' . ' ' . '<span class="text-danger">*</span>') ?>
        </div>
        <div class="col-3">
            <?= $form->field($model, 'description')->textarea([
                'placeholder' => 'متن اطلاع رسانی به کاربر را وارد کنید...',
                'maxlength' => true,
                'class' => 'form-control rounded-md input-border',
                'rows' => '3'
            ])->label('توضیحات هشدار' . ' ' . '<span class="text-danger">*</span>') ?>
        </div>

        <div class="col-1">
            <?= $form->field($model, 'status')->widget(Select2::class, [
                'data' => ReportAlert::itemAlias('Status'),
                'options' => [],
                'pluginOptions' => [
                    'allowClear' => true,
                    'initialize' => !$model->isNewRecord,
                ],
            ]); ?>
        </div>
        <div class="col-2">
            <?= $form->field($model, 'notification_type')->widget(Select2::class, [
                'data' => ReportAlert::itemAlias('Notification'),
                'options' => [
                    'id' => "notification_type_id",
                ],
                'pluginOptions' => [
                    'allowClear' => true,
                    'initialize' => !$model->isNewRecord,
                ],
            ]); ?>
        </div>
        <div class="col-3">
            <?= $form->field($model, 'users')->widget(DepDrop::class, [
                'type' => DepDrop::TYPE_SELECT2,
                'options' => [
                    'id' => 'users',
                    'multiple' => true,
                    'placeholder' => 'کاربران اطلاع‌رسانی را انتخاب کنید...',
                    'class' => 'depdrop-field'
                ],
                'select2Options' => [
                    'pluginOptions' => ['allowClear' => true]
                ],
                'pluginOptions' => [
                    'depends' => ['notification_type_id'],
                    'initialize' => !$model->isNewRecord,
                    'url' => Url::to(['/bidashboard/report-user/get-users/', 'alertId' => $model->id ?? 0])
                ]
            ])->label('کاربران اطلاع‌رسانی' . ' ' . '<span class="text-danger">*</span>'); ?>
        </div>
    </div>
    <div class="row justify-content-center">
        <div class="col-3">
            <?= $form->field($model, 'widget_id')->widget(Select2::class, [
                'data' => ReportWidget::getWidgetList(showRangeType: true),
                'options' => [
                    'id' => "widget_id",
                    'placeholder' => 'ویجت مورد نظر را انتخاب کنید...',
                    'disabled' => $fromBox
                ],
                'pluginOptions' => [
                    'allowClear' => true,
                    'initialize' => !$model->isNewRecord || $fromBox,
                ],
            ])->label('ویجت' . ' ' . '<span class="text-danger">*</span>'); ?>
        </div>
        <div class="col-3">
            <?= $form->field($model, "widget_field")->widget(DepDrop::class, [
                'type' => DepDrop::TYPE_SELECT2,
                'options' => [
                    'id' => "widget_field",
                    'placeholder' => 'فیلد خروجی ویجت را انتخاب کنید...',
                    'class' => 'depdrop-field',
                    'disabled' => $fromBox
                ],
                'select2Options' => [
                    'pluginOptions' => ['allowClear' => true]
                ],
                'pluginOptions' => [
                    'depends' => ["widget_id"],
                    'initialize' => !$model->isNewRecord || $fromBox,
                    'url' => Url::to(['/bidashboard/report-box-widget/get-widget-columns/'])
                ]
            ])->label('فیلد خروجی ویجت' . ' ' . '<span class="text-danger">*</span>'); ?>
        </div>
        <div class="col-3">
            <?= $form->field($model, 'floor')->widget(
                MaskedInput::class,
                [
                    'options' => [
                        'autocomplete' => 'off',
                        'class' => 'form-control  mask_currency rounded-md input-border',
                        'placeholder' => 'کف مقدار را وارد...',
                        'title' => 'مقدار کف',
                    ],
                    'clientOptions' => [
                        'alias' => 'integer',
                        'groupSeparator' => ',',
                        'autoGroup' => true,
                        'removeMaskOnSubmit' => true,
                        'autoUnmask' => true,
                    ],
                ])->label('مقدار کف' . ' ' . '<span class="text-danger">*</span>'); ?>
        </div>
        <div class="col-3">
            <?= $form->field($model, 'ceiling')->widget(
                MaskedInput::class,
                [
                    'options' => [
                        'autocomplete' => 'off',
                        'class' => 'form-control  mask_currency rounded-md input-border',
                        'placeholder' => 'سقف مقدار را وارد...',
                        'title' => 'مقدار سقف',
                    ],
                    'clientOptions' => [
                        'alias' => 'integer',
                        'groupSeparator' => ',',
                        'autoGroup' => true,
                        'removeMaskOnSubmit' => true,
                        'autoUnmask' => true,
                    ],
                ])->label('مقدار سقف' . ' ' . '<span class="text-danger">*</span>'); ?>
        </div>
    </div>
    <div class="d-flex justify-content-end">
        <?= Html::submitButton($model->isNewRecord ? Yii::t('biDashboard', 'Create Alert') : Yii::t('biDashboard', 'update'), ['class' => 'btn btn-success rounded-md']) ?>
    </div>

    <?php ActiveForm::end(); ?>
</div>