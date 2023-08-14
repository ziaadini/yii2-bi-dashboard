<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/** @var yii\web\View $this */
/** @var \sadi01\bidashboard\models\ReportPageSearch $model */
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
            <?= $form->field($model, 'range_type')->dropDownList($model->itemAlias('RangeType')) ?>
        </div>
    </div>

    <div class="form-group">
        <?= Html::submitButton(Yii::t('app', 'Search'), ['class' => 'btn btn-primary']) ?>
        <?= Html::resetButton(Yii::t('app', 'Reset'), ['class' => 'btn btn-outline-secondary']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
