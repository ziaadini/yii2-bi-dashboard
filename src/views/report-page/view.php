<?php


use sadi01\bidashboard\models\ReportPageWidget;
use yii\helpers\Html;
use yii\helpers\Time;
use sadi01\bidashboard\models\ReportPage;
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
 */

$this->title = $model->title;
$this->params['breadcrumbs'][] = ['label' => Yii::t('app', 'Report Pages'), 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
$pdate = Yii::$app->pdate;
$allMonthTitle = [1=>'فروردین', 2=>'اردیبهشت', 3=>'خرداد',4=> 'تیر',5=> 'مرداد',6=> 'شهریور',7=> 'مهر',8=> 'آبان',9=> 'آذر',10=> 'دی',11=> 'بهمن',12=> 'اسفند'];



?>

<div class="report-page-view">
    <?php Pjax::begin(['id' => 'p-jax-report-page-add', 'enablePushState' => false]); ?>
    <div class="p-3 bg-white">

        <?php if ($model->range_type == $model::RANGE_DAY): ?>
            <span class="btn btn-success">
                روزانه
            </span>

        <?php else: ?>
            <span class="btn btn-success">
                ماهانه
            </span>
        <?= Html::dropDownList('انتخاب',
                null,
                $allMonthTitle,
                [
                    'class' => "",
                ]
            );

        ?>

        <?php endif; ?>


        <?= Html::a(Yii::t('biDashboard', 'Update'), "javascript:void(0)",
            [
                'data-pjax' => '0',
                'class' => "btn btn-primary",
                'data-size' => 'modal-xl',
                'data-title' => Yii::t('biDashboard', 'update'),
                'data-toggle' => 'modal',
                'data-target' => '#modal-pjax',
                'data-url' => Url::to(['report-page/update', 'id' => $model->id]),
                'data-handle-form-submit' => 1,
                'data-show-loading' => 0,
                'data-reload-pjax-container' => 'p-jax-report-page-add',
                'data-reload-pjax-container-on-show' => 0
            ]) ?>
        <?= Html::a(Yii::t('biDashboard', 'Delete'), ['delete', 'id' => $model->id], [
            'class' => 'btn btn-danger',
            'data' => [
                'confirm' => Yii::t('app', 'Are you sure you want to delete this item?'),
                'method' => 'post',
            ],
        ]) ?>
        <?= Html::a(Yii::t('biDashboard', 'add widget'), "javascript:void(0)",
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
                <table class="table table-bordered bg-white">
                    <thead class="table-dark">
                    <tr>
                        <th scope="col" class="text-center">ویجت</th>
                        <?php
                        for ($i=1;$i<=$rangeDateNumber;$i++){
                            if ($model->range_type == $model::RANGE_DAY) {
                                echo '<th scope="col" class="text-center">'.$i.'</th>';
                            }else{
                                echo '<th scope="col" class="text-center">'.$allMonthTitle[$i].'</th>';
                            }
                        }
                        ?>
                    </tr>
                    </thead>
                    <tbody>
                    <?php foreach ($pageWidgets as $pageWidget): ?>
                    <?php $runWidget = $pageWidget->widget->lastResult($startRange, $endRange); ?>
                        <tr>
                            <th style="width: 17%">
                                    <div class="border-bottom">
                                        <?= Html::a('<i class="mdi mdi-launch"></i>', [$pageWidget->widget->getModelRoute()],['target'=>'_blank']) ?>

                                        <?= Html::a('<i class="mdi mdi-reload"></i>', 'javascript:void(0)',
                                            [
                                                'title' => Yii::t('yii', 'reload'),
                                                'aria-label' => Yii::t('yii', 'reload'),
                                                'data-reload-pjax-container' => 'p-jax-report-page-add',
                                                'data-pjax' => '0',
                                                'data-url' => Url::to(['/bidashboard/report-widget/reload', 'id' => $pageWidget->widget->id]),
                                                'class' => " p-jax-btn btn-sm text-info",
                                                'data-title' => Yii::t('yii', 'reload'),
                                            ]); ?>
                                        <?= Html::a('<i class="mdi mdi-pencil"></i>', "javascript:void(0)",
                                            [
                                                'data-pjax' => '0',
                                                'class' => "btn btn-sm text-info",
                                                'data-size' => 'modal-xl',
                                                'data-title' => Yii::t('app', 'update',),
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
                                    <div class="col-12">
                                        <span>ویجت گزارش :</span>
                                        <span class="bg-warning"><?php echo $pageWidget->widget->title ?></span>
                                    </div>
                                    <div class="col-sm-6">
                                        <label>فیلد ویجت گزارش :</label>
                                        <span class="bg-warning">
                                            <?=
                                                $pageWidget->report_widget_field
                                            ?>
                                        </span>
                                    </div>
                                </div>
                                <div class="text-center text-info">
                                    <?=
                                        Yii::$app->formatter->asRelativeTime($runWidget->created_at, 'now');
                                    ?>
                                </div>
                            </th>
                            <?php
                                $formatter = \Yii::$app->formatter;
                                if ($runWidget) {
                                    for ($i=1;$i<=$rangeDateNumber;$i++){
                                        if ($model->range_type == $model::RANGE_DAY) {
                                            $key = array_search($i, array_column($runWidget->result, 'day'));
                                        }else{
                                            $key = array_search($i, array_column($runWidget->result, 'month'));
                                        }
                                        if ($key === false) {
                                            echo '<th scope="col"></th>';
                                        } else {
                                            $resultData = $runWidget->result[$key][$pageWidget->report_widget_field];
                                            if ($pageWidget->report_widget_field_format == $pageWidget::FORMAT_CURRENCY){
                                                $resultData = $formatter->asCurrency($resultData);
                                            }
                                            echo '<th scope="col" class="text-center" style="font-size: 20px;">' . $resultData . '</th>';
                                        }
                                    }
                                }
                            ?>
                        </tr>
                    <?php endforeach; ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
    <?php Pjax::end(); ?>
</div>