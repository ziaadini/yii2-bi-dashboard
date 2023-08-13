<?php

use sadi01\bidashboard\models\ReportYear;
use yii\helpers\ArrayHelper;
use yii\helpers\Html;
use yii\bootstrap4\ActiveForm;

/** @var yii\web\View $this */
/** @var sadi01\bidashboard\models\ReportYearSearch $model */
/** @var ActiveForm $form */
?>

<div class="report-year-search">

    <?php $form = ActiveForm::begin([
        'action' => ['index'],
        'method' => 'get',
    ]); ?>
    <div class="row">
        <div class="col-3">
            <?= $form->field($model, 'year')->dropDownList(
                array_combine(ReportYear::itemAlias('List'), ReportYear::itemAlias('List')),
                ['prompt' => Yii::t('biDashboard','Select a year')]
            ) ?>
        </div>
    </div>
    <div class="form-group">
        <?= Html::submitButton(Yii::t('biDashboard', 'Search'), ['class' => 'btn btn-primary']) ?>
        <?= Html::resetButton(Yii::t('biDashboard', 'Reset'), ['class' => 'btn btn-outline-secondary']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
