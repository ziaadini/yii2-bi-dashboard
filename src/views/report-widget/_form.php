<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/** @var yii\web\View $this */
/** @var sadi01\bidashboard\models\ReportWidget $model */
/** @var yii\widgets\ActiveForm $form */
?>

<div class="report-widget-form">

    <?php $form = ActiveForm::begin(); ?>

    <?= $form->field($model, 'title')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'description')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'search_model_class')->textInput() ?>

    <?= $form->field($model, 'search_model_method')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'status')->textInput() ?>

<!--    --><?php //= $form->field($model, 'deleted_at')->textInput() ?>

<!--    --><?php //= $form->field($model, 'search_model_run_result_view')->textInput(['maxlength' => true]) ?>

<!--    --><?php //= $form->field($model, 'range_type')->textInput() ?>

<!--    --><?php //= $form->field($model, 'visibility')->textInput() ?>

<!--    --><?php //= $form->field($model, 'add_on')->textInput() ?>

<!--    --><?php //= $form->field($model, 'updated_at')->textInput() ?>

<!--    --><?php //= $form->field($model, 'created_at')->textInput() ?>

<!--    --><?php //= $form->field($model, 'updated_by')->textInput() ?>

<!--    --><?php //= $form->field($model, 'created_by')->textInput() ?>

    <div class="form-group">
        <?= Html::submitButton(Yii::t('biDashboard', 'Save'), ['class' => 'btn btn-success']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
