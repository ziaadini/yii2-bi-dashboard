<?php

use ziaadini\bidashboard\models\ReportPage;
use ziaadini\bidashboard\models\SharingPage;
use mobit\dateRangePicker\dateRangePicker;
use yii\helpers\ArrayHelper;
use yii\helpers\Html;
use yii\bootstrap4\ActiveForm;

/** @var yii\web\View $this */
/** @var \ziaadini\bidashboard\models\SharingPageSearch $model */
/** @var ActiveForm $form */
?>

<div class="sharing-page-search">
    <?php $form = ActiveForm::begin([
        'action' => ['index'],
        'method' => 'get',
        'options' => [
            'data-pjax' => 1
        ],
    ]); ?>
    <div class="row">
        <div class="col-3">
            <?= $form->field($model, 'page_id')->dropDownList(
                ArrayHelper::map(SharingPage::itemAlias('List'), 'id', 'title'),
                ['prompt' => Yii::t('biDashboard', 'Select a page')]
            ) ?>
        </div>
    </div>
    <div class="form-group">
        <?= Html::submitButton(Yii::t('biDashboard', 'Search'), ['class' => 'btn btn-primary']) ?>
        <?= Html::resetButton(Yii::t('biDashboard', 'Reset'), ['class' => 'btn btn-outline-secondary']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>