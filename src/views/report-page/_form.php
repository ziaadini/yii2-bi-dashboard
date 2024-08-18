<?php

use ziaadini\bidashboard\models\ReportPage;
use yii\bootstrap4\ActiveForm;
use yii\helpers\Html;
use yii\web\View;

/** @var View $this */
/** @var ReportPage $model */
/** @var ActiveForm $form */
?>


<div class="report-page-widget-form">

    <?php $form = ActiveForm::begin(['id' => 'page-form', 'enableClientValidation' => true]); ?>

    <?= $form->field($model, 'title')->textInput(['maxlength' => true]) ?>
    <?php if ($model->isNewRecord): ?>
        <?= $form->field($model, 'status')->dropDownList(ReportPage::itemAlias('Status')) ?>

        <?= $form->field($model, 'range_type')->dropDownList(ReportPage::itemAlias('RangeType')) ?>
    <?php endif; ?>
    <div class="form-group">
        <?= Html::submitButton(Yii::t('biDashboard', 'Save'), ['class' => 'btn btn-success']) ?>
    </div>

    <?php ActiveForm::end(); ?>
</div>