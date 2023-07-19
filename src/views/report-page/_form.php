<?php

use sadi01\bidashboard\models\ReportPage;
use Yii;
use yii\bootstrap4\ActiveForm;
use yii\helpers\Html;
use yii\web\View;

/** @var View $this */
/** @var ReportPage $model */
/** @var ActiveForm $form */
?>

<div class="report-page-form">

    <?php $form = ActiveForm::begin(['id' => 'page-form', 'enableClientValidation' => true]); ?>

    <?= $form->field($model, 'title')->textInput(['maxlength' => true]) ?>
    <?php if (!isset($model->range_type)): ?>
        <?= $form->field($model, 'range_type')->dropDownList(ReportPage::itemAlias('range_type'), ['prompt' => Yii::t('biDashboard', 'Select RANGE')]) ?>
    <?php endif; ?>
    <div class="form-group">
        <?= Html::submitButton(Yii::t('biDashboard', 'Save'), ['class' => 'btn btn-success']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>