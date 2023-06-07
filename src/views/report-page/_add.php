<?php

use sadi01\bidashboard\models\ReportPageWidget;
use sadi01\bidashboard\models\ReportWidget;
use yii\helpers\ArrayHelper;
use kartik\select2\Select2;
use yii\helpers\Html;
use yii\widgets\ActiveForm;

/** @var yii\web\View $this */
/** @var sadi01\bidashboard\models\ReportPageWidget $model */
/** @var yii\widgets\ActiveForm $form */
?>

<div class="report-page-widget-form">

    <?php $form = ActiveForm::begin(); ?>

    <?=
    $form->field($model, 'widget_id')->widget(Select2::class, [
        'data' => ArrayHelper::map(ReportWidget::find()->all(), 'id', 'title'),
        'options' => ['placeholder' => Yii::t('app', 'Select user')],
        'pluginOptions' => [
            'allowClear' => true
        ],
    ]);
    ?>
    <?= $form->field($model, 'report_widget_field')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'report_widget_field_format')->textInput() ?>

    <?= $form->field($model, 'status')->dropDownList(ReportPageWidget::itemAlias('Status'), ['prompt' => Yii::t('app', 'Select Status')]) ?>

    <div class="form-group">
        <?= Html::submitButton('Save', ['class' => 'btn btn-success']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>