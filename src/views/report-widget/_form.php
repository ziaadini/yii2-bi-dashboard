<?php

use yii\helpers\Html;
use yii\bootstrap4\ActiveForm;
use yii\web\View;
use yii\helpers\ArrayHelper;
use sadi01\bidashboard\models\ReportModelClass;
use sadi01\bidashboard\models\ReportWidget;

/** @var View $this */
/** @var ReportWidget $model */
/** @var ActiveForm $form */
?>

<div class="report-widget-form">
    <?php $form = ActiveForm::begin(['action' => ['/bidashboard/report-widget/create']]); ?>

    <div class="row">
        <div class="col-sm-6">
            <?= $form->field($model, 'title')->textInput(['maxlength' => true]) ?>
        </div>
        <div class="col-sm-6">
            <?= $form->field($model, 'description')->textInput(['maxlength' => true]) ?>
        </div>
        <div class="col-sm-3">
            <?= $form->field($model, 'range_type')->dropDownList($model->itemAlias('RangeTypes')) ?>
        </div>
        <div class="col-sm-3">
            <?= $form->field($model, 'visibility')->dropDownList($model->itemAlias('Visibility')) ?>
        </div>
    </div>

    <?= $form->field($model, 'search_model_class')->hiddenInput(['value' => $searchModel::class])->label(false) ?>
    <?= $form->field($model, 'search_model_method')->hiddenInput(['value' => 'search'])->label(false) ?>
    <?= $form->field($model, 'search_route')->hiddenInput(['value' => 'search'])->label(false) ?>
    <?= $form->field($model, 'search_model_form_name')->hiddenInput(['value' => 'search'])->label(false) ?>

    <?php
    foreach ($queryParams as $Pkey => $Pvalue) {
        echo $form->field($model, 'params[' . $Pkey . ']')->hiddenInput(['value' => $Pvalue])->label(false);
    }
    ?>

    <div class="form-group">
        <?= Html::submitButton(Yii::t('biDashboard', 'Save'), ['class' => 'btn btn-success']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>