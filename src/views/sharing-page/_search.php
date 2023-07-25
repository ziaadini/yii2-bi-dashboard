<?php

use sadi01\bidashboard\models\ReportPage;
use sadi01\dateRangePicker\dateRangePicker;
use yii\helpers\ArrayHelper;
use yii\helpers\Html;
use yii\widgets\ActiveForm;

/** @var yii\web\View $this */
/** @var \sadi01\bidashboard\models\SharingPageSearch $model */
/** @var yii\widgets\ActiveForm $form */
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
                ArrayHelper::map((array)ReportPage::find()->select(['id','title'])->asArray()->all(), 'id', 'title'),
                ['prompt' => 'Select a page']
            ) ?>
        </div>
        <div class="col-3">
            <?= $form->field($model, 'expire_time')->widget(dateRangePicker::class,[
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
                    'id' => 'from_date_time',
                    'autocomplete' => 'off',
                ]
            ]);
            ?>
        </div>
    </div>
    <div class="form-group">
        <?= Html::submitButton(Yii::t('app', 'Search'), ['class' => 'btn btn-primary']) ?>
        <?= Html::resetButton(Yii::t('app', 'Reset'), ['class' => 'btn btn-outline-secondary']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
