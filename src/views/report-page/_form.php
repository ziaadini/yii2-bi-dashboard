<?php

use sadi01\bidashboard\models\ReportPage;
use Yii;
use yii\bootstrap4\ActiveForm;
use yii\helpers\Html;
use yii\web\View;

/** @var View $this */
/** @var ReportPage $model */
/** @var ActiveForm $form */
?>

<div class="report-widget-create">
    <div class="page-content container-fluid text-left ">
        <div class="work-report-index card">
            <div class="panel-group m-bot20" id="accordion">
                <div class="card-body">
                    <div class="report-page-widget-form">

                        <?php $form = ActiveForm::begin(['id' => 'page-form','enableClientValidation' => true]); ?>

                        <?= $form->field($model, 'title')->textInput(['maxlength' => true]) ?>

                        <?= $form->field($model, 'status')->dropDownList(ReportPage::itemAlias('Status')) ?>

                        <?= $form->field($model, 'range_type')->dropDownList(ReportPage::itemAlias('RangeType')) ?>

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