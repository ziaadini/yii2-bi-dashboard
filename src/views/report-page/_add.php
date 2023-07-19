<?php

use sadi01\bidashboard\models\ReportPageWidget;
use sadi01\bidashboard\models\ReportWidget;
use yii\helpers\ArrayHelper;
use kartik\select2\Select2;
use kartik\depdrop\DepDrop;
use yii\helpers\Html;
use yii\widgets\ActiveForm;
use yii\web\View;
use yii\helpers\Url;


/** @var yii\web\View $this */
/** @var sadi01\bidashboard\models\ReportPageWidget $model */
/** @var yii\widgets\ActiveForm $form */
/** @var sadi01\bidashboard\models\ReportPage $page */
/** @var sadi01\bidashboard\models\ReportWidget $widgets */
?>
<div class="report-widget-create">
    <div class="page-content container-fluid text-left ">
        <div class="work-report-index card">
            <div class="panel-group m-bot20" id="accordion">
                <div class="card-body">
                    <div class="report-page-widget-form">
                        <?php $form = ActiveForm::begin(['id' => 'page-widget-form']); ?>
                        <?= $form->field($model, 'widget_id')->widget(Select2::class, [
                            'data' => ArrayHelper::map($widgets, 'id', 'title'),
                            'options' => [
                                'placeholder' => Yii::t('biDashboard', 'Select widget'),
                            ],
                            'pluginOptions' => [
                                'allowClear' => true
                            ],
                        ]); ?>
                        <?= $form->field($model, 'report_widget_field')->widget(DepDrop::class, [
                            'options' => ['id' => 'widget_field_id'],
                            'pluginOptions' => [
                                'depends' => ['reportpagewidget-widget_id'],
                                'placeholder' => Yii::t('biDashboard', 'Select...'),
                                'url' => Url::to(['report-page/getwidgetcolumn'])
                            ]
                        ]); ?>
                        <?= $form->field($model, 'report_widget_field_format')->dropDownList(['1' => Yii::t('biDashboard', 'Number'), '2' => Yii::t('biDashboard', 'Currency')]); ?>
                        <div class="form-group">
                            <?= Html::submitButton(Yii::t('biDashboard', 'Save'), ['class' => 'btn btn-success']) ?>
                        </div>
                        <?php ActiveForm::end(); ?>
                    </div>

                </div>
            </div>
        </div>
    </div>
</div>