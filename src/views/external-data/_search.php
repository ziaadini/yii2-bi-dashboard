<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use ziaadini\bidashboard\models\ExternalData;
use sadi01\dateRangePicker\dateRangePicker;


/** @var yii\web\View $this */
/** @var ziaadini\bidashboard\models\ExternalDataSearch $model */
/** @var yii\widgets\ActiveForm $form */
?>

<div class="external-data-search">

    <?php $form = ActiveForm::begin([
        'action' => ['index'],
        'method' => 'get',
        'options' => [
            'data-pjax' => 1
        ],
    ]); ?>
    <div class="row">
        <div class="col-sm-3">
            <?= $form->field($model, 'title') ?>
        </div>
        <div class="col-sm-3">
            <?= $form->field($model, 'status')->dropDownList(ExternalData::itemAlias('Status')) ?>
        </div>
        <div class="col-sm-3">
            <?= $form->field($model, 'created_at')->widget(dateRangePicker::class, [
                'options'  => [
                    'drops' => 'down',
                    'placement' => 'right',
                    'opens' => 'left',
                    'language' => 'fa',
                    'jalaali' => true,
                    'showDropdowns' => true,
                    'singleDatePicker' => true,
                    'useTimestamp' => true,
                    'timePicker' => true,
                    'timePicker24Hour' => true,
                    'timePickerSeconds' => true,
                    'locale' => [
                        'format' => 'jYYYY/jMM/jDD HH:mm:ss',
                    ],
                ],
                'htmlOptions' => [
                    'class'    => 'form-control',
                    'id' => 'date_time_range',
                    'autocomplete' => 'off',
                ]
            ]);
            ?>
        </div>
    </div>

    <div class="form-group">
        <?= Html::submitButton(Yii::t('biDashboard', 'Search'), ['class' => 'btn btn-primary']) ?>
        <?= Html::resetButton(Yii::t('biDashboard', 'Reset'), ['class' => 'btn btn-outline-secondary']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>