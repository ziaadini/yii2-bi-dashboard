<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use sadi01\dateRangePicker\dateRangePicker;


/** @var yii\web\View $this */
/** @var sadi01\bidashboard\models\ExternalDataValue $model */
/** @var yii\widgets\ActiveForm $form */
?>

<div class="external-data-value-form">

    <?php $form = ActiveForm::begin(['id' => 'external-data-value-form','enableClientValidation' => true]); ?>

    <?= $form->field($model, 'value')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'created_at')->widget(dateRangePicker::class,[
        'options'  => [
            'drops' => 'down',
            'placement' => 'right',
            'opens' => 'left',
            'language' => 'fa',
            'jalaali'=> true,
            'showDropdowns'=> true,
            'singleDatePicker' => true,
            'useTimestamp' => true,
            'timePicker' => true,
            'timePicker24Hour' => true,
            'timePickerSeconds' => true,
            'locale'=> [
                'format' => 'jYYYY/jMM/jDD HH:mm:ss',
            ],
        ],
        'htmlOptions' => [
            'class'	=> 'form-control',
            'id' => 'external_data_edit_range_date',
            'autocomplete' => 'off',
            'value' => $model->created_at,
        ]
    ]);
    ?>
    <div class="form-group">
        <?= Html::submitButton(Yii::t('biDashboard', 'Save'), ['class' => 'btn btn-success']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
