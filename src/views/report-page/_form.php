<?php

use sadi01\bidashboard\models\ReportPage;
use yii\helpers\Html;
use yii\widgets\ActiveForm;

/** @var yii\web\View $this */
/** @var \ReportPage $model */
/** @var yii\widgets\ActiveForm $form */
?>

<div class="report-page-form">

    <?php $form = ActiveForm::begin(); ?>

    <?= $form->field($model, 'title')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'status')->dropDownList(ReportPage::itemAlias('Status'),['prompt'=>Yii::t('app','Select Status')]) ?>

    <?= $form->field($model, 'range_type')->dropDownList(ReportPage::itemAlias('RANGE'),['prompt'=>Yii::t('app','Select RANGE')]) ?>

    <?= $form->field($model, 'add_on')->textInput() ?>

    <div class="form-group">
        <?= Html::submitButton(Yii::t('app', 'Save'), ['class' => 'btn btn-success']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
