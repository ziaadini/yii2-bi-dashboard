<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/** @var yii\web\View $this */
/** @var \ziaadini\bidashboard\models\ReportDashboardSearch $model */
/** @var yii\widgets\ActiveForm $form */
?>

<div class="report-dashboard">

    <?php $form = ActiveForm::begin([
        'action' => ['index'],
        'method' => 'get',
        'options' => [
            'data-pjax' => 1
        ],
    ]); ?>

    <div class="d-flex align-items-end">
        <div class="search-filed min-w-60 mr-2">
            <?= $form->field($model, 'first_name')->textInput([
                'class' => 'form-control rounded-md',
                'placeholder' => 'نام...'
            ])->label(false) ?>
        </div>
        <div class="search-filed min-w-60 mr-2">
            <?= $form->field($model, 'last_name')->textInput([
                'class' => 'form-control rounded-md',
                'placeholder' => 'نام خانوادگی...'
            ])->label(false) ?>
        </div>
        <div class="search-filed min-w-60 mr-2">
            <?= $form->field($model, 'phone_number')->textInput([
                'class' => 'form-control rounded-md',
                'placeholder' => 'شماره تلفن...'
            ])->label(false) ?>
        </div>
        <div class="search-filed min-w-60 mr-2">
            <?= $form->field($model, 'email')->textInput([
                'class' => 'form-control rounded-md',
                'placeholder' => 'ایمیل...'
            ])->label(false) ?>
        </div>
        <div class="">
            <?= Html::submitButton(Yii::t('biDashboard', 'Search'), ['class' => 'btn btn-primary rounded-md']) ?>
        </div>
    </div>

    <?php ActiveForm::end(); ?>

</div>