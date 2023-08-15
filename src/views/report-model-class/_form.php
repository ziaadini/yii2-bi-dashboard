<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/** @var yii\web\View $this */
/** @var sadi01\bidashboard\models\ReportModelClass $model */
/** @var yii\widgets\ActiveForm $form */
?>

<div class="report-model-class-form">

    <?php $form = ActiveForm::begin(['id' => 'report-model-class-form', 'enableClientValidation' => true]); ?>

    <?= $form->field($model, 'model_class')->textInput(['maxlength' => true,'disabled' => true]) ?>

    <?= $form->field($model, 'title')->textInput(['maxlength' => true]) ?>


    <div class="form-group">
        <?= Html::submitButton(Yii::t('biDashboard', 'Save'), ['class' => 'btn btn-success']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
