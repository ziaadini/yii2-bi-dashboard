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
                ArrayHelper::map(ReportYear::itemAlias('List'), 'id', 'title'),
                ['prompt' => 'Select a page']
            ) ?>
        </div>
    </div>
    <div class="form-group">
        <?= Html::submitButton(Yii::t('app', 'Search'), ['class' => 'btn btn-primary']) ?>
        <?= Html::resetButton(Yii::t('app', 'Reset'), ['class' => 'btn btn-outline-secondary']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
