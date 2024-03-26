<?php

use sadi01\bidashboard\widgets\Alert;
use sadi01\bidashboard\models\ReportDashboard;
use sadi01\bidashboard\models\ReportWidget;
use sadi01\bidashboard\models\ReportBox;
use sadi01\bidashboard\models\ReportBoxWidgets;
use sadi01\bidashboard\models\ReportYear;
use yii\helpers\Html;
use yii\helpers\Time;
use yii\helpers\Url;
use yii\web\View;
use yii\widgets\DetailView;
use yii\widgets\Pjax;
use yii\widgets\ActiveForm;
use yii\web\JsExpression;

/**
 * @var View $this
 * @var ReportDashboard $model
 * @var ReportBox $boxes
 * @var ReportBox $charts
 * @var ReportBox $tables
 * @var ReportBoxWidgets $cards
 */
$this->title = $model->title;
$pdate = Yii::$app->pdate;

?>

<div class="report-dashboard-view">

    <?php Pjax::begin([
        'id' => 'p-jax-report-dashboard-view',
        'enablePushState' => false,
        'timeout' => false,
        ]); ?>

    <div class="bg-white p-3 d-flex justify-content-between rounded-md mb-4 shadow-sm">
        <?= Alert::widget() ?>
        <?php if (Yii::$app->user->identity): ?>
        <div class="d-flex flex-column">
            <h1 class="h4 font-bold"><?= $model->title ?></h1>
            <span class="text-muted"><?= $model->description ?></span>
        </div>
        <div class="d-flex align-items-center">
            <button type="button" class="btn btn-secondary rounded-md mr-2"> تاریخ امروز:  <?= $pdate->jdate('Y/m/d') ?></button>
            <?= Html::a('<i class="fa-plus far"></i>' . ' ' . Yii::t('biDashboard', 'create box'), "javascript:void(0)",
                [
                    'data-pjax' => '0',
                    'class' => "btn btn-success rounded-md mr-2",
                    'data-size' => 'modal-dialog-centered modal-xl',
                    'data-title' => Yii::t('biDashboard', 'create box'),
                    'data-toggle' => 'modal',
                    'data-target' => '#modal-pjax-bi',
                    'data-url' => Url::to(['report-box/create', 'dashboardId' => $model->id]),
                    'data-handle-form-submit' => 1,
                    'data-reload-pjax-container' => 'p-jax-report-dashboard-view'
                ]) ?>
            <a href="<?= Url::to(['/bidashboard/report-dashboard/']) ?>" class="btn btn-info rounded-md">بازگشت</a>
        </div>
        <?php endif; ?>
    </div>
    <div class="container-xxl">

        <?php if (!empty($cards)): ?>
            <!--  Separator  -->
            <div class="separator text-muted my-4">
                <span class="font-bold h4 mb-0 mx-2"><?= Yii::t('biDashboard', 'Cards') ?></span>
            </div>
            <!--  Cards  -->
            <div class="row">
            <?php foreach($cards as $box):?>
                <?php Pjax::begin([
                    'id' => 'p-jax-report-dashboard-box-'.$box->id,
                    'enablePushState' => false,
                    'timeout' => false,
                ]); ?>
                <?= $this->render('box_card', [
                    'box' => $box,
                ]) ?>
                <?php Pjax::end();?>
            <?php endforeach; ?>
            </div>
        <?php endif; ?>

        <?php if (!empty($charts)): ?>

            <!--  Separator  -->
            <div class="separator text-muted my-4">
                <span class="font-bold h4 mb-0 mx-2"><?= Yii::t('biDashboard', 'Charts') ?></span>
            </div>

            <!--  Charts  -->
            <div class="" style="display:grid; grid-template-columns: 1fr 1fr;gap:1.5rem; padding:0 1rem;max-width:calc(100% - 15rem);">
                <?php foreach($charts as $index => $box):?>
                    <?php Pjax::begin([
                        'id' => 'p-jax-report-dashboard-box-'.$box->id,
                        'enablePushState' => false,
                        'timeout' => false,
                    ]); ?>
                    <?= $this->render('box_chart', [
                        'box' => $box,
                    ]); ?>
                    <?php Pjax::end();?>
                <?php endforeach; ?>
            </div>
        <?php endif; ?>

        <?php if (!empty($tables)): ?>

            <!--  Separator  -->
            <div class="separator text-muted my-4">
                <span class="font-bold h4 mb-0 mx-2"><?= Yii::t('biDashboard', 'Tables') ?></span>
            </div>

            <!--  Tables  -->
            <?php foreach($tables as $box):?>
                <?php Pjax::begin([
                    'id' => 'p-jax-report-dashboard-box-'.$box->id,
                    'enablePushState' => false,
                    'timeout' => false,
                ]); ?>
                <?= $this->render('box_table', [
                    'box' => $box,
                ]) ?>
                <?php Pjax::end();?>
            <?php endforeach; ?>

        <?php endif; ?>

    </div>

    <?php if(empty($cards) && empty($charts) && empty($table)): ?>
    <div class="d-flex justify-content-center">
        <span>اطلاعاتی برای نمایش وجود ندارد.</span>
    </div>
    <?php endif; ?>

    <?php Pjax::end(); ?>
</div>

