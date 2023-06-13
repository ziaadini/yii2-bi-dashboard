<?php


use sadi01\bidashboard\models\ReportPageWidget;
use yii\helpers\Html;
use yii\helpers\Time;
use sadi01\bidashboard\models\ReportPage;
use yii\helpers\Url;
use yii\web\View;
use yii\widgets\DetailView;
use yii\widgets\Pjax;


/** @var View $this */
/** @var ReportPage $model */

$this->title = $model->title;
$this->params['breadcrumbs'][] = ['label' => Yii::t('app', 'Report Pages'), 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="report-page-view">
    <?php Pjax::begin(['id' => 'p-jax-report-page-add', 'enablePushState' => false]); ?>
    <div class="p-3 bg-white">
        <?= Html::a(Yii::t('biDashboard', 'Update'), "javascript:void(0)",
            [
                'data-pjax' => '0',
                'class' => "btn btn-primary",
                'data-size' => 'modal-xl',
                'data-title' => Yii::t('app', 'update'),
                'data-toggle' => 'modal',
                'data-target' => '#modal-pjax',
                'data-url' => Url::to(['report-page/update', 'id' => $model->id]),
                'data-handle-form-submit' => 1,
                'data-show-loading' => 0,
                'data-reload-pjax-container' => 'p-jax-report-page-add',
                'data-reload-pjax-container-on-show' => 0
            ]) ?>
        <?= Html::a(Yii::t('app', 'Delete'), ['delete', 'id' => $model->id], [
            'class' => 'btn btn-danger',
            'data' => [
                'confirm' => Yii::t('app', 'Are you sure you want to delete this item?'),
                'method' => 'post',
            ],
        ]) ?>
        <?= Html::a(Yii::t('biDashboard', 'اضافه کردن ویجت'), "javascript:void(0)",
            [
                'data-pjax' => '0',
                'class' => "btn btn-primary",
                'data-size' => 'modal-xl',
                'data-title' => Yii::t('app', 'create'),
                'data-toggle' => 'modal',
                'data-target' => '#modal-pjax',
                'data-url' => Url::to(['report-page/add', 'id' => $model->id]),
                'data-handle-form-submit' => 1,
                'data-show-loading' => 0,
                'data-reload-pjax-container' => 'p-jax-report-page-add',
                'data-reload-pjax-container-on-show' => 0
            ]) ?>
        <div class="float-left">
            <span>عنوان  : </span>
            <span><?= $model->title ?></span>
            <span>/</span>
            <span class="text-muted"><?= ReportPage::itemAlias('range_type', $model->range_type) ?></span>
        </div>
    </div>
    <div>
        <div>
            <div class="table-responsive text-nowrap">
                <table class="table bg-white">
                    <thead class="table-dark">
                    <tr>
                        <th scope="col">ویجت</th>
                        <th scope="col">فروردین</th>
                        <th scope="col">اردیبهشت</th>
                        <th scope="col">خرداد</th>
                        <th scope="col">تیر</th>
                        <th scope="col">مرداد</th>
                        <th scope="col">شهریور</th>
                        <th scope="col">مهر</th>
                        <th scope="col">آبان</th>
                        <th scope="col">آذر</th>
                        <th scope="col">دی</th>
                        <th scope="col">بهمن</th>
                        <th scope="col">اسفند</th>

                    </tr>
                    </thead>
                    <tbody>
                    <?php foreach ($widgets as $widget): ?>
                        <tr>
                            <th>
                                <div class="">
                                    <div class="border-bottom">
                                        <?= Html::a('<i class="mdi mdi-launch"></i>', "javascript:void(0)",
                                            [
                                                'data-pjax' => '0',
                                                'class' => "btn btn-sm text-primary",
                                                'data-size' => 'modal-xl',
                                                'data-title' => '<i class="mdi mdi-launch"></i>',
                                                'data-toggle' => 'modal',
                                                'data-target' => '#modal-pjax',
                                                'data-url' => Url::to(['/bidashboard/report-widget/view', 'id' => $widget->widget['id']]),
                                                'data-handle-form-submit' => 1,
                                                'data-show-loading' => 0,
                                                'data-reload-pjax-container' => 'p-jax-report-page-add',
                                                'data-reload-pjax-container-on-show' => 0
                                            ]) ?>
                                        <?= Html::a('<i class="mdi mdi-reload"></i>', "javascript:void(0)",
                                            [
                                                'data-pjax' => '0',
                                                'class' => "btn btn-sm text-success",
                                                'data-size' => 'modal-xl',
                                                'data-title' => '<i class="mdi mdi-reload"></i>',
                                                'data-toggle' => 'modal',
                                                'data-target' => '#modal-pjax',
                                                'data-url' => Url::to(['/report-widget/create', 'id' => $model->id]),
                                                'data-handle-form-submit' => 1,
                                                'data-show-loading' => 0,
                                                'data-reload-pjax-container' => 'p-jax-report-page-add',
                                                'data-reload-pjax-container-on-show' => 0
                                            ]) ?>
                                        <?= Html::a('<i class="mdi mdi-pencil"></i>', "javascript:void(0)",
                                            [
                                                'data-pjax' => '0',
                                                'class' => "btn btn-sm text-info",
                                                'data-size' => 'modal-xl',
                                                'data-title' => Yii::t('app', 'update',),
                                                'data-toggle' => 'modal',
                                                'data-target' => '#modal-pjax',
                                                'data-url' => Url::to(['/report-widget/update', 'id' => $widget->widget['id']]),
                                                'data-handle-form-submit' => 1,
                                                'data-show-loading' => 0,
                                                'data-reload-pjax-container' => 'p-jax-report-page-add',
                                                'data-reload-pjax-container-on-show' => 0
                                            ]) ?>
                                        <?= Html::a('<i class="mdi mdi-delete"></i>', 'javascript:void(0)',
                                            [
                                                'title' => Yii::t('yii', 'delete'),
                                                'aria-label' => Yii::t('yii', 'delete'),
                                                'data-reload-pjax-container' => 'p-jax-report-page-add',
                                                'data-pjax' => '0',
                                                'data-url' => Url::to(['/bidashboard/report-page-widget/delete']),
                                                'class' => " p-jax-btn btn-sm text-danger",
                                                'data-title' => Yii::t('yii', 'delete'),
                                                'data-toggle' => 'tooltip',
                                            ]); ?>

                                    </div>
                                </div>
                                <div class="border-bottom text-left row p-3">
                                    <div class="col-6">
                                        <span>ویجت گزارش :</span>
                                        <span class="bg-warning"><?php echo $widget->widget['search_model_class'] ?></span>

                                    </div>
                                    <div class="col-6">
                                        <label>فیلد ویجت گزارش :</label>
                                        <span class="bg-warning"><?php echo $widget->widget['search_model_class'] ?></span>
                                    </div>
                                </div>
                                <div class="text-center text-info">
                                    <?php
                                    $currentDateTime = new DateTime(); // Current date and time
                                    $updatedAt = DateTime::createFromFormat('U', $widget->widget['updated_at']);


                                    $timeDiff = date_diff($currentDateTime, $updatedAt);

                                    echo "<p>{$timeDiff->format('%d روز, %h ساعت, %i دقیقه, %s ثانیه')}</p>";
                                    ?>
                                </div>


                            </th>
                        </tr>
                    <?php endforeach; ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
    <?php Pjax::end(); ?>
</div>