<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/** @var yii\web\View $this */
/** @var \ReportPageSearch $model */
/** @var yii\widgets\ActiveForm $form */
?>

<div class="report-page-search">

    <?php $form = ActiveForm::begin([
        'action' => ['index'],
        'method' => 'get',
        'options' => [
            'data-pjax' => 1
        ],
    ]); ?>

    <div class="row">
        <div class="col-3">
            <?= $form->field($model, 'title') ?>
        </div>
        <div class="col-3">
            <?= $form->field($model, 'add_on') ?>
        </div>
    </div>
<!--    --><?php //= $form->field($model, 'id') ?>

<!--    --><?php //= $form->field($model, 'status') ?>

<!--    --><?php //= $form->field($model, 'range_type') ?>
    <?php // echo $form->field($model, 'created_at') ?>

    <?php // echo $form->field($model, 'updated_at') ?>

    <?php // echo $form->field($model, 'deleted_at') ?>

    <?php // echo $form->field($model, 'updated_by') ?>

    <?php // echo $form->field($model, 'created_by') ?>

    <div class="form-group">
        <?= Html::submitButton(Yii::t('app', 'Search'), ['class' => 'btn btn-primary']) ?>
        <?= Html::resetButton(Yii::t('app', 'Reset'), ['class' => 'btn btn-outline-secondary']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
