<?php

use ziaadini\bidashboard\components\Pdate;
use ziaadini\bidashboard\models\SharingPage;
use mobit\dateRangePicker\dateRangePicker;
use yii\helpers\Html;
use yii\helpers\Url;
use yii\web\View;
use yii\widgets\ActiveForm;
use yii\widgets\Pjax;

/** @var View $this */
/** @var SharingPage $model */
/** @var ActiveForm $form */
/** @var SharingPage $page_model */
/**@var $pDate Pdate */

$this->title = Yii::t('biDashboard', 'Sharing Pages');
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="sharing-page-management container text-left">

    <div class="row">
        <div class="col-sm-12">
            <div class="sharing-page-form">
                <?php $form = ActiveForm::begin(['id' => 'sharing-form', 'enableClientValidation' => true]); ?>
                <div class="row">
                    <div class="col-md-4">
                        <?= $form->field($model, 'expire_time')->widget(dateRangePicker::class, [
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
                                'id' => 'from_date_time',
                                'autocomplete' => 'off',
                            ]
                        ]);
                        ?>
                    </div>
                    <div class="col-sm-4 pt-4">
                        <div class="form-group">
                            <?= Html::submitButton(Yii::t('biDashboard', 'Save'), ['class' => 'btn btn-success']) ?>
                        </div>
                    </div>
                </div>
                <?php ActiveForm::end(); ?>
            </div>
        </div>

        <div class="col-md-12">
            <div class="sharing-page-index">
                <h4><?= Html::encode($this->title) ?></h4>
                <table class="table table-striped">
                    <thead>
                        <tr>
                            <th>#</th>
                            <th><?= Yii::t('biDashboard', 'Access Key') ?></th>
                            <th><?= Yii::t('biDashboard', 'Expire Time') ?></th>
                            <th><?= Yii::t('biDashboard', 'Button') ?></th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach ($page_model as $key): ?>
                            <tr>
                                <td><?= $key['id'] ?></td>
                                <td>
                                    <span id="access_key_<?= $key->id ?>">
                                        <?= $key['access_key'] ?>
                                    </span>
                                    <span class="fa fa-copy text-info p-1" onclick="copyToClipboard(generateAccessKeyLink('<?= $key['access_key'] ?>'))"></span>
                                </td>
                                <td><?= Yii::$app->pdate->jdate("Y/m/d H:i", intval($key['expire_time'])) ?></td>
                                <td>
                                    <?php Pjax::begin(['id' => 'p-jax-sharing-page']); ?>
                                    <?php if ($key['expire_time'] > time()): ?>
                                        <?= Html::a(
                                            Yii::t('biDashboard', 'Expired'),
                                            'javascript:void(0)',
                                            [
                                                'title' => Yii::t('biDashboard', 'Expired'),
                                                'aria-label' => Yii::t('biDashboard', 'Expired'),
                                                'data-reload-pjax-container' => 'p-jax-sharing-page',
                                                'data-pjax' => '0',
                                                'data-url' => Url::to(['/bidashboard/sharing-page/expire', 'id' => $key['id']]),
                                                'class' => " p-jax-btn btn-sm text-info",
                                                'data-title' => Yii::t('biDashboard', 'Expired'),
                                            ]
                                        ); ?>

                                    <?php endif; ?>
                                    <?php Pjax::end(); ?>

                                </td>
                            </tr>
                        <?php endforeach; ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>