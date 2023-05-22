<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/** @var yii\web\View $this */
/** @var sadi01\bidashboard\models\ReportModelClass $model */
/** @var yii\widgets\ActiveForm $form */
?>

<div class="report-model-class-form">

    <?php $form = ActiveForm::begin(); ?>

    <?= $form->field($model, 'title')->textInput() ?>

    <?= $form->field($model, 'search_model_class')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'search_model_method')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'search_model_run_result_view')->textInput(['maxlength' => true]) ?>

    <div class="form-group">
        <?= Html::submitButton(Yii::t('biDashboard', 'Save'), ['class' => 'btn btn-success']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
