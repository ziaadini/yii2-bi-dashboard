<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/** @var yii\web\View $this */
/** @var sadi01\bidashboard\models\search\ReportWidgetSearch $model */
/** @var yii\widgets\ActiveForm $form */
?>

<div class="report-widget-search">

    <?php $form = ActiveForm::begin([
        'action' => ['index'],
        'method' => 'get',
        'options' => [
            'data-pjax' => 1
        ],
    ]); ?>

    <?= $form->field($model, 'id') ?>

    <?= $form->field($model, 'title') ?>

    <?= $form->field($model, 'description') ?>

    <?= $form->field($model, 'search_model_class') ?>

    <?= $form->field($model, 'search_model_method') ?>

    <div class="form-group">
        <?= Html::submitButton(Yii::t('biDashboard', 'Search'), ['class' => 'btn btn-primary']) ?>
        <?= Html::resetButton(Yii::t('biDashboard', 'Reset'), ['class' => 'btn btn-outline-secondary']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
