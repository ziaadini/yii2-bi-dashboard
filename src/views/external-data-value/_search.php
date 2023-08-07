<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/** @var yii\web\View $this */
/** @var sadi01\bidashboard\models\ExternalDataValueSearch $model */
/** @var yii\widgets\ActiveForm $form */
?>

<div class="external-data-value-search">

    <?php $form = ActiveForm::begin([
        'action' => ['index'],
        'method' => 'get',
        'options' => [
            'data-pjax' => 1
        ],
    ]); ?>

    <?= $form->field($model, 'id') ?>

    <?= $form->field($model, 'external_data_id') ?>

    <?= $form->field($model, 'value') ?>


    <div class="form-group">
        <?= Html::submitButton(Yii::t('biDashboard', 'Search'), ['class' => 'btn btn-primary']) ?>
        <?= Html::resetButton(Yii::t('biDashboard', 'Reset'), ['class' => 'btn btn-outline-secondary']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
