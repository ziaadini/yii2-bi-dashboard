<?php

use sadi01\bidashboard\models\ReportPageWidget;
use yii\helpers\Html;
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
        <?= Html::a(Yii::t('app', 'Update'), ['update', 'id' => $model->id], ['class' => 'btn btn-primary']) ?>
        <?= Html::a(Yii::t('app', 'Delete'), ['delete', 'id' => $model->id], [
            'class' => 'btn btn-danger',
            'data' => [
                'confirm' => Yii::t('app', 'Are you sure you want to delete this item?'),
                'method' => 'post',
            ],
        ]) ?>
        <?= Html::a(Yii::t('biDashboard', 'create'), "javascript:void(0)",
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
            <span class="text-muted"><?= ReportPage::itemAlias('range_type',$model->range_type) ?></span>
        </div>
    </div>
    <div>
        <div>
            <div class="row">
                <table class="table table-bordered bg-white">
                    <thead>
                    <tr>
                        <th scope="col">#</th>
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
                            <th scope="row"><?php echo $widget->widget['id'] ?></th>
                            <th>
                                <label>عنوان</label>
                                <?php echo $widget->widget['title'] ?>
                                <label>مدل</label>
                                <?php echo $widget->widget['search_model_class'] ?>
                                <label>متد</label>
                                <?php echo $widget->widget['search_model_class'] ?>
                                <?= Html::a(Yii::t('app', 'create'), "javascript:void(0)",
                                    [
                                        'data-pjax' => '0',
                                        'class' => "btn btn-primary",
                                        'data-size' => 'modal-xl',
                                        'data-title' => Yii::t('app', 'create'),
                                        'data-toggle' => 'modal',
                                        'data-target' => '#modal-pjax',
                                        'data-url' => Url::to(['/business-gallery/create', 'id' => $model->id]),
                                        'data-handle-form-submit' => 1,
                                        'data-show-loading' => 0,
                                        'data-reload-pjax-container' => 'p-jax-business-gallery',
                                        'data-reload-pjax-container-on-show' => 0
                                    ]) ?>
                                <?= Html::a(Yii::t('app', 'update'), "javascript:void(0)",
                                    [
                                        'data-pjax' => '0',
                                        'class' => "btn btn-outline-primary",
                                        'data-size' => 'modal-xl',
                                        'data-title' => Yii::t('app', 'update',),
                                        'data-toggle' => 'modal',
                                        'data-target' => '#modal-pjax',
                                        'data-url' => Url::to(['/business-gallery/update', 'id' => $model->id]),
                                        'data-handle-form-submit' => 1,
                                        'data-show-loading' => 0,
                                        'data-reload-pjax-container' => 'p-jax-business-gallery',
                                        'data-reload-pjax-container-on-show' => 0
                                    ]) ?>
                                <?= Html::a(Html::tag('span', Yii::t('app', 'Delete'), ['class' => "btn btn-outline-danger ml-1 rounded-3"]), 'javascript:void(0)',
                                    [
                                        'title' => Yii::t('yii', 'delete'),
                                        'aria-label' => Yii::t('yii', 'delete'),
                                        'data-reload-pjax-container' => 'p-jax-business-gallery',
                                        'data-pjax' => '0',
                                        'data-url' => Url::to(['/business-gallery/delete', 'id' => $model->id]),
                                        'class' => " p-jax-btn",
                                        'data-title' => Yii::t('yii', 'delete'),
                                        'data-toggle' => 'tooltip',
                                        'data-method' => ''
                                    ]); ?>


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