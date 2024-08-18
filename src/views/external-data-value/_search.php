<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use kartik\select2\Select2;
use ziaadini\bidashboard\models\ExternalData;
use yii\helpers\ArrayHelper;
use ziaadini\dateRangePicker\dateRangePicker;
use ziaadini\bidashboard\models\ExternalDataValue;

/** @var yii\web\View $this */
/** @var ziaadini\bidashboard\models\ExternalDataValueSearch $model */
/** @var yii\widgets\ActiveForm $form */
?>

<div class="external-data-value-search">

    <?php $form = ActiveForm::begin([
        'action' => ['/bidashboard/external-data-value/index'],
        'method' => 'get',
        'options' => [
            'data-pjax' => 1
        ],
    ]); ?>

    <div class="row">
        <div class="col-sm-3">
            <?= $form->field($model, 'external_data_id')->widget(Select2::class, [
                'data' => ArrayHelper::map(ExternalData::find()->all(), 'id', 'title'),
                'options' => [
                    'placeholder' => Yii::t('biDashboard', 'Select...'),
                ],
                'pluginOptions' => [
                    'allowClear' => true
                ],
            ])->label(Yii::t('biDashboard', 'External Data')); ?>
        </div>
        <div class="col-sm-3">
            <?= $form->field($model, 'value') ?>
        </div>
        <div class="col-sm-3">
            <?= $form->field($model, 'status')->dropDownList(ExternalDataValue::itemAlias('Status')) ?>
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