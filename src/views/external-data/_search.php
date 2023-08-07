<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use sadi01\bidashboard\models\ExternalData;

/** @var yii\web\View $this */
/** @var sadi01\bidashboard\models\ExternalDataSearch $model */
/** @var yii\widgets\ActiveForm $form */
?>

<div class="external-data-search">

    <?php $form = ActiveForm::begin([
        'action' => ['index'],
        'method' => 'get',
        'options' => [
            'data-pjax' => 1
        ],
    ]); ?>
    <div class="row">
        <div class="col-sm-3">
            <?= $form->field($model, 'title') ?>
        </div>
        <div class="col-sm-3">
            <?= $form->field($model, 'status')->dropDownList(ExternalData::itemAlias('Status')) ?>
        </div>
        <div class="col-sm-3">
            <?= $form->field($model, 'created_at') ?>
        </div>
        <div class="col-sm-3">
            <?= $form->field($model, 'created_by') ?>
        </div>
    </div>

    <div class="form-group">
        <?= Html::submitButton(Yii::t('biDashboard', 'Search'), ['class' => 'btn btn-primary']) ?>
        <?= Html::resetButton(Yii::t('biDashboard', 'Reset'), ['class' => 'btn btn-outline-secondary']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
