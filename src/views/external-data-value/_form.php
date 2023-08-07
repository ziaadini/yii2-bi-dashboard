<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/** @var yii\web\View $this */
/** @var sadi01\bidashboard\models\ExternalDataValue $model */
/** @var yii\widgets\ActiveForm $form */
?>

<div class="external-data-value-form">

    <?php $form = ActiveForm::begin(['id' => 'external-data-value-form','enableClientValidation' => true]); ?>

    <?= $form->field($model, 'value')->textInput(['maxlength' => true]) ?>

    <div class="form-group">
        <?= Html::submitButton(Yii::t('biDashboard', 'Save'), ['class' => 'btn btn-success']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
