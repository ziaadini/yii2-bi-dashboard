<?php

use ziaadini\bidashboard\models\ReportPageWidget;
use ziaadini\bidashboard\models\ReportWidget;
use yii\helpers\ArrayHelper;
use kartik\select2\Select2;
use yii\helpers\Html;
use yii\widgets\ActiveForm;
use yii\web\View;
use yii\helpers\Url;


/** @var ziaadini\bidashboard\models\ReportPageWidget $model */
?>
<div class="report-widget-create">
    <div class="page-content container-fluid text-left">
        <div class="work-report-index">
            <div class="panel-group m-bot20" id="accordion">
                <div class="card-body">
                    <?php $form = ActiveForm::begin(['id' => 'page-widget-update-form']); ?>

                    <?= $form->field($model, 'report_widget_field')->dropDownList($column_name); ?>

                    <?= $form->field($model, 'report_widget_field_format')->dropDownList(['1' => Yii::t('biDashboard', 'Number'), '2' => Yii::t('biDashboard', 'Curency')]); ?>

                    <div class="form-group">
                        <?= Html::submitButton('Save', ['class' => 'btn btn-success']) ?>
                    </div>

                    <?php ActiveForm::end(); ?>

                </div>
            </div>
        </div>
    </div>
</div>