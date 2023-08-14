<?php

use yii\helpers\Html;
use yii\bootstrap4\ActiveForm;

/** @var yii\web\View $this */
/** @var sadi01\bidashboard\models\ReportWidget $model */

$this->title = Yii::t('biDashboard', 'Update Report Widget: {name}', [
    'name' => $model->title,
]);
$this->params['breadcrumbs'][] = ['label' => Yii::t('biDashboard', 'Report Widgets'), 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->title, 'url' => ['view', 'id' => $model->id]];
$this->params['breadcrumbs'][] = Yii::t('biDashboard', 'Update');
?>

<div class="report-widget-update">
    <div class="page-content container-fluid text-left">
        <div class="work-report-index card">
            <div class="panel-group m-bot20" id="accordion">
                <div class="card-body">
                    <div class="report-year-form">
                        <?php $form = ActiveForm::begin(['enableClientValidation' => true]); ?>
                        <?= $form->field($model, 'title')->textInput() ?>
                        <?= $form->field($model, 'description')->textInput() ?>
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