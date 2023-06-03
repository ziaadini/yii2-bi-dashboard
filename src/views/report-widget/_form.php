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

    <?= $form->field($model, 'search_model_class')->hiddenInput(['value' => $searchModelClass])->label(false) ?>
    <?= $form->field($model, 'search_model_method')->hiddenInput(['value' => $searchModelMethod])->label(false) ?>
    <?= $form->field($model, 'search_model_run_result_view')->hiddenInput(['value' => $searchModelRunResultView])->label(false) ?>
    <?= $form->field($model, 'search_route')->hiddenInput(['value' => $searchRoute])->label(false) ?>
    <?= $form->field($model, 'search_model_form_name')->hiddenInput(['value' => $searchModelFormName])->label(false) ?>

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

<div class="table-responsive">
    <table class="table table-striped table-bordered">
        <thead>
        <tr>
            <th><?= Yii::t('biDashboard', 'attribute') ?></th>
            <th><?= Yii::t('biDashboard', 'value') ?></th>
        </tr>
        </thead>
        <tbody>
        <?php foreach ($queryParams as $Pkey => $Pvalue): ?>
            <tr>
                <td>
                    <?= Yii::t('app', $Pkey) ?>
                </td>
                <td>
                    <?= $Pvalue ?>
                </td>
            </tr>
        <?php endforeach; ?>
        </tbody>
    </table>
</div>
