<?php

use sadi01\bidashboard\models\ReportPage;
use sadi01\bidashboard\models\SharingPage;
use sadi01\dateRangePicker\dateRangePicker;
use yii\helpers\ArrayHelper;
use yii\helpers\Html;
use yii\bootstrap4\ActiveForm;

/** @var yii\web\View $this */
/** @var \sadi01\bidashboard\models\SharingPageSearch $model */
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
