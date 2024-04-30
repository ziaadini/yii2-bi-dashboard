<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/** @var yii\web\View $this */
/** @var sadi01\bidashboard\models\search\ReportWidgetSearch $model */
/** @var yii\widgets\ActiveForm $form */
?>

<div class="report-widget-search">

    <?php $form = ActiveForm::begin([
        'action' => ['index'],
        'method' => 'get',
        'options' => [
            'data-pjax' => 1
        ],
    ]); ?>

    <div class="d-flex align-items-end">
        <div class="search-filed d-flex min-w-60 mr-2">

            <?= $form->field($model, 'id',[
                'options' => [
                    'class' => 'mr-2',
                ]])->textInput([
                'class' => 'form-control rounded-md',
                'placeholder' => 'شناسه ویجت را وارد کنید...'
            ])->label(false) ?>

            <?= $form->field($model, 'title',[
                'options' => [
                    'class' => 'mr-2',
                ]])->textInput([
                'class' => 'form-control rounded-md',
                'placeholder' => 'عنوان ویجت را وارد کنید...'
            ])->label(false) ?>

            <?= $form->field($model, 'description',[
                'options' => [
                    'class' => 'mr-2',
                ]])->textInput([
                'class' => 'form-control rounded-md',
                'placeholder' => ' توضیحات ویجت را وارد کنید...'
            ])->label(false) ?>

        </div>
        <div class="">
            <?= Html::submitButton(Yii::t('biDashboard', 'Search'), ['class' => 'btn btn-primary rounded-md']) ?>
        </div>
    </div>

    <?php ActiveForm::end(); ?>

</div>
