<?php

use Yii;
use sadi01\bidashboard\models\ReportPage;
use sadi01\bidashboard\models\ReportPageWidget;
use sadi01\bidashboard\models\ReportWidgetResult;
use sadi01\bidashboard\models\ReportYear;
use yii\helpers\Html;
use yii\helpers\Time;
use yii\helpers\Url;
use yii\web\View;
use yii\widgets\DetailView;
use yii\widgets\Pjax;

/**
 * @var View $this
 * @var ReportPage $model
 * @var object $pageWidgets
 * @var $pageWidget ReportPageWidget
 * @var $startRange int
 * @var $endRange int
 * @var $rangeDateNumber int
 * @var  ReportYear $years
 */

$this->title = $model->title;
$this->params['breadcrumbs'][] = ['label' => Yii::t('biDashboard', 'Report Pages'), 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
$pdate = Yii::$app->pdate;

/**
 * @var $year string
 * @var $month string
 */

?>

<div class="report-page-view">
    <?php Pjax::begin(['id' => 'p-jax-report-page-add', 'enablePushState' => false]); ?>
    <div class="p-3 bg-white">
        <?= \sadi01\bidashboard\widgets\Alert::widget() ?>
        <div class="row d-flex">
            <div class="pt-2 col-sm-2 text-left mr-auto">
                <span>عنوان  : </span>
                <span><?= $model->title ?></span>
                <span>/</span>
                <span class="text-muted"><?= ReportPage::itemAlias('range_type', $model->range_type) ?></span>
            </div>
            <div class="col-sm-10 d-flex justify-content-end">
                <div class="col-sm-2">
                    <form>
                        <div class="d-flex justify-content-end">
                            <div class="px-1">
                                <select name="year" class="form-control" onchange="this.form.submit()">
                                    <option value="1402" <?= $year == '1402' ? 'selected' : '' ?> >1402</option>
                                    <option value="1401" <?= $year == '1401' ? 'selected' : '' ?> >1401</option>
                                    <option value="1400" <?= $year == '1400' ? 'selected' : '' ?> >1400</option>
                                </select>
                            </div>
                            <?php if ($model->range_type == $model::RANGE_DAY): ?>
                                <div class="px-1">
                                    <select name="month" class="form-control" onchange="this.form.submit()">
                                        <?php for ($i = 1; $i <= 12; $i++): ?>
                                            <option
                                                value="<?= $i ?>" <?= $month == $i ? 'selected' : '' ?> ><?= $i ?></option>
                                        <?php endfor; ?>
                                    </select>
                                </div>
                            <?php endif; ?>
                            <div class="px-1">
                                <input type="hidden" name="id" value="<?= $model->id ?>">
                            </div>
                        </div>
                    </form>
                </div>
                <div class="px-1">
                    <?= Html::a(Yii::t('biDashboard', 'run all widget'), 'javascript:void(0)',
                        [
                            'title' => Yii::t('biDashboard', 'run all widget'),
                            'aria-label' => Yii::t('biDashboard', 'run all widget'),
                            'data-reload-pjax-container' => 'p-jax-report-page-add',
                            'data-pjax' => '0',
                            'data-url' => Url::to(['/bidashboard/report-page/run-all-widgets', 'id' => $model->id, 'start_range' => $startRange, 'end_range' => $endRange]),
                            'class' => " p-jax-btn btn btn-info",
                            'data-title' => Yii::t('biDashboard', 'run all widget'),
                        ]); ?>
                </div>
                <div class="px-1">
                    <?= Html::a(Yii::t('biDashboard', 'add widget'), "javascript:void(0)",
                        [
                            'data-pjax' => '0',
                            'class' => "btn btn-primary",
                            'data-size' => 'modal-xl',
                            'data-title' => Yii::t('biDashboard', 'create'),
                            'data-toggle' => 'modal',
                            'data-target' => '#modal-pjax',
                            'data-url' => Url::to(['report-page/add', 'id' => $model->id]),
                            'data-handle-form-submit' => 1,
                            'data-show-loading' => 0,
                            'data-reload-pjax-container' => 'p-jax-report-page-add',
                            'data-reload-pjax-container-on-show' => 0
                        ]) ?>
                    <?= Html::a(Yii::t('biDashboard', 'share'), "javascript:void(0)",
                        [
                            'data-pjax' => '0',
                            'class' => "btn btn-primary",
                            'data-size' => 'modal-xl',
                            'data-title' => Yii::t('app', 'create'),
                            'data-toggle' => 'modal',
                            'data-target' => '#modal-pjax',
                            'data-url' => Url::to(['sharing-page/management', 'id' => $model->id]),
                            'data-handle-form-submit' => 1,
                            'data-show-loading' => 0,
                            'data-reload-pjax-container' => 'p-jax-report-page-add',
                            'data-reload-pjax-container-on-show' => 0
                        ]) ?>
                </div>
                <div class="px-1">
                    <?= Html::a(Yii::t('biDashboard', 'Delete'), ['delete', 'id' => $model->id], [
                        'class' => 'btn btn-danger',
                        'data' => [
                            'confirm' => Yii::t('biDashboard', 'Are you sure you want to delete this item?'),
                            'method' => 'post',
                        ],
                    ]) ?>
                </div>
            </div>
        </div>
    </div>
    <div class="table-responsive text-nowrap">
        <table class="table table-bordered bg-white">
            <thead class="table-dark">
            <tr>
                <th scope="col" class="text-center">ویجت</th>
                <?php
                for ($i = 1; $i <= $rangeDateNumber; $i++) {
                    if ($model->range_type == $model::RANGE_DAY) {
                        echo '<th scope="col" class="text-center">' . $i . '</th>';
                    } else {
                        echo '<th scope="col" class="text-center">' . $pdate->jdate_words(['mm' => $i], ' ') . '</th>';
                    }
                }
                ?>
            </tr>
            </thead>
            <tbody>
            <?php foreach ($pageWidgets as $pageWidget): ?>
                <?php
                $runWidget = null;
                $runWidget = $pageWidget->widget->lastResult($startRange, $endRange);
                if ($runWidget instanceof ReportWidgetResult):
                    ?>
                    <tr>
                        <th style="width: 17%">
                            <div class="border-bottom">

                                <?= Html::a('<i class="mdi mdi-chart-line"></i>', "javascript:void(0)",
                                    [
                                        'data-pjax' => '0',
                                        'class' => "btn btn-sm text-info",
                                        'data-size' => 'modal-xl',
                                        'data-title' => Yii::t('biDashboard', 'Chart'),
                                        'data-toggle' => 'modal',
                                        'data-target' => '#modal-pjax',
                                        'data-url' => Url::to(['report-widget/modal-show-chart', 'id' => $pageWidget->widget->id, 'field' => $pageWidget->report_widget_field, 'start_range' => $startRange, 'end_range' => $endRange, 'chart_type' => 'line']),
                                        'data-handle-form-submit' => 1,
                                        'data-show-loading' => 0,
                                        'data-reload-pjax-container' => 'p-jax-report-page-add',
                                        'data-reload-pjax-container-on-show' => 0
                                    ]) ?>

                                <?= Html::a('<i class="mdi mdi-launch"></i>', [$pageWidget->widget->getModelRoute()], ['target' => '_blank']) ?>

                                <?= Html::a('<i class="mdi mdi-reload"></i>', 'javascript:void(0)',
                                    [
                                        'title' => Yii::t('yii', 'reload'),
                                        'aria-label' => Yii::t('yii', 'reload'),
                                        'data-reload-pjax-container' => 'p-jax-report-page-add',
                                        'data-pjax' => '0',
                                        'data-url' => Url::to(['/bidashboard/report-widget/run', 'id' => $pageWidget->widget->id, 'start_range' => $startRange, 'end_range' => $endRange]),
                                        'class' => " p-jax-btn btn-sm text-info",
                                        'data-title' => Yii::t('yii', 'reload'),
                                    ]); ?>
                                <?= Html::a('<i class="mdi mdi-pencil"></i>', "javascript:void(0)",
                                    [
                                        'data-pjax' => '0',
                                        'class' => "btn btn-sm text-info",
                                        'data-size' => 'modal-xl',
                                        'data-title' => Yii::t('biDashboard', 'update',),
                                        'data-toggle' => 'modal',
                                        'data-target' => '#modal-pjax',
                                        'data-url' => Url::to(['/report-widget/update', 'id' => $pageWidget->widget->id]),
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
                                        'data-url' => Url::to(['/bidashboard/report-page-widget/delete', 'id_widget' => $pageWidget->widget->id, 'id_page' => $model->id]),
                                        'class' => " p-jax-btn btn-sm text-danger",
                                        'data-title' => Yii::t('yii', 'delete'),
                                        'data-toggle' => 'tooltip',
                                    ]); ?>
                            </div>
                            <div class=" text-left row p-3">
                                <div class="col-sm-12 d-flex justify-content-between">
                                    <span>ویجت گزارش :</span>
                                    <span class="bg-warning">
                                        <?= $pageWidget->widget->title ?>
                                    </span>
                                </div>
                                <div class="col-sm-12 d-flex justify-content-between">
                                    <span>فیلد ویجت گزارش :</span>
                                    <span class="bg-warning">
                                    <?= $pageWidget->report_widget_field ?>
                                    </span>
                                </div>
                            </div>
                            <div class="text-center text-info">
                                <?= Yii::$app->formatter->asRelativeTime($runWidget->created_at, 'now'); ?>
                            </div>
                        </th>
                        <?php
                        $formatter = Yii::$app->formatter;
                        if ($runWidget) {
                            for ($i = 1; $i <= $rangeDateNumber; $i++) {
                                if ($model->range_type == $model::RANGE_DAY) {
                                    $key = array_search($i, array_column($runWidget->result, 'day'));
                                } else {
                                    $key = array_search($i, array_column($runWidget->result, 'month'));
                                }
                                if ($key === false) {
                                    echo '<th scope="col"></th>';
                                } else {
                                    $resultData = key_exists($pageWidget->report_widget_field, $runWidget->result[$key]) ? $runWidget->result[$key][$pageWidget->report_widget_field] : '.::field error(1)::.';
                                    if ($pageWidget->report_widget_field_format == $pageWidget::FORMAT_CURRENCY) {
                                        $resultData = $formatter->asCurrency($resultData);
                                    }
                                    echo '<th scope="col" class="text-center" style="font-size: 20px;">' . $resultData . '</th>';
                                }
                            }
                        }
                        ?>
                    </tr>
                <?php endif; ?>
            <?php endforeach; ?>
            </tbody>
        </table>
    </div>
</div>
<?php Pjax::end(); ?>
</div>