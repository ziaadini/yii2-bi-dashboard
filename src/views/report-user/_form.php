<?php

use ziaadini\bidashboard\models\ReportUser;
use kartik\select2\Select2;
use yii\helpers\Url;
use yii\bootstrap4\ActiveForm;
use yii\helpers\Html;
use yii\web\View;

/** @var View $this */
/** @var ReportUser $model */
/** @var ActiveForm $form */
?>

<div class="dashboard-form">

    <?php $form = ActiveForm::begin(['id' => 'dynamic-form', 'enableClientValidation' => true]); ?>

    <div class="row justify-content-center">
        <div class="col-3">
            <?= $form->field($model, 'first_name')->textInput([
                'placeholder' => 'نام...',
                'maxlength' => true,
                'class' => 'form-control rounded-md input-border'
            ])->label('نام' . ' ' . '<span class="text-danger">*</span>') ?>
        </div>
        <div class="col-3">
            <?= $form->field($model, 'last_name')->textInput([
                'placeholder' => 'نام خانوادگی...',
                'maxlength' => true,
                'class' => 'form-control rounded-md input-border'
            ])->label('نام خانوادگی' . ' ' . '<span class="text-danger">*</span>') ?>
        </div>
        <div class="col-3">
            <?= $form->field($model, 'phone_number')->textInput([
                'placeholder' => 'شماره تلفن...',
                'maxlength' => true,
                'class' => 'form-control rounded-md input-border'
            ])->label('شماره تلفن' . ' ' . '<span class="text-danger">*</span>') ?>
        </div>
        <div class="col-3">
            <?= $form->field($model, 'email')->textInput([
                'placeholder' => 'ایمیل...',
                'maxlength' => true,
                'class' => 'form-control rounded-md input-border'
            ])->label('ایمیل' . ' ' . '<span class="text-danger">*</span>') ?>
        </div>
    </div>

    <div class="d-flex justify-content-end">
        <?= Html::submitButton($model->isNewRecord ? Yii::t('biDashboard', 'Save User') : Yii::t('biDashboard', 'update'), ['class' => 'btn btn-success rounded-md']) ?>
    </div>

    <?php ActiveForm::end(); ?>
</div>