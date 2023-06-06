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
<div class="report-page-view ">
    <?php Pjax::begin(['id' => 'p-jax-report-page-add', 'enablePushState' => false]); ?>
    <div>
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
    </div>
    <div class="text-left">
        <div class="">
            <h6>عنوان</h6>
            <span><?= $model->title ?></span>
            <h6>نوع نمایش</h6>
            <span><?= $model->range_type ?></span>
        </div>
        <div>
            <div class="row">
                <?php foreach ($widgets as $widget): ?>
                    <div class="col-sm-3 m-1 p-2  bg-white">
                        <div class="">
                            <h4>:WidgetResult</h4>
                            <?php foreach ($widget->widget->reportWidgetResults as $item): ?>
                                <div><?= $item['id'] ?></div>
                            <?php endforeach; ?>
                            <h4>:widget</h4>
                            <div><?= $widget->widget['id'] ?></div>
                        </div>

                    </div>
                <?php endforeach; ?>
            </div>
        </div>
    </div>
    <?php Pjax::end(); ?>
</div>