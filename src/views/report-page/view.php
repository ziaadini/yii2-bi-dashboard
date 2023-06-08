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
                        <th scope="col">1</th>
                        <th scope="col">2</th>
                        <th scope="col">3</th>
                        <th scope="col">4</th>
                        <th scope="col">5</th>
                        <th scope="col">6</th>
                        <th scope="col">7</th>
                        <th scope="col">8</th>
                        <th scope="col">9</th>
                        <th scope="col">10</th>
                        <th scope="col">11</th>
                        <th scope="col">12</th>
                        <th scope="col">13</th>
                        <th scope="col">14</th>
                        <th scope="col">15</th>
                        <th scope="col">16</th>
                        <th scope="col">17</th>
                        <th scope="col">18</th>
                        <th scope="col">19</th>
                        <th scope="col">20</th>
                        <th scope="col">21</th>
                        <th scope="col">22</th>
                        <th scope="col">23</th>
                        <th scope="col">24</th>
                        <th scope="col">25</th>
                        <th scope="col">26</th>
                        <th scope="col">27</th>
                        <th scope="col">28</th>
                        <th scope="col">29</th>
                        <th scope="col">30</th>
                        <th scope="col">31</th>

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
                                                'data-url' => Url::to(['/bidashboard/report-widget/delete', 'id' => $widget->widget['id']]),
                                                'class' => " p-jax-btn btn-sm text-danger",
                                                'data-title' => Yii::t('yii', 'delete'),
                                                'data-toggle' => 'tooltip',
                                                'data-method' => ''
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