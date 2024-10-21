<?php

use ziaadini\bidashboard\models\ReportFiredAlert;
use ziaadini\bidashboard\models\ReportFiredAlertSearch;
use ziaadini\bidashboard\widgets\grid\ActionColumn;
use ziaadini\bidashboard\widgets\grid\GridView;
use yii\data\ActiveDataProvider;
use yii\helpers\Html;
use yii\helpers\Url;
use yii\web\View;
use yii\widgets\Pjax;

/** @var View $this */
/** @var ReportFiredAlertSearch $searchModel */
/** @var ActiveDataProvider $dataProvider */

$this->title = Yii::t('biDashboard', 'Alerts');
$this->params['breadcrumbs'][] = ' ' . $this->title;
$this->registerJs("
    $('.seen_status').on('change', function() {
            var checkbox = $(this);
            var id = checkbox.val();
            var seen_status = checkbox.is(':checked') ? 1 : 0; // Ensure this variable is defined 
            console.log('hi');

        $.ajax({
            url: '" . \yii\helpers\Url::to(['report-fired-alert/change-seen-status']) . "',
            type: 'POST',
            data: {
                id: id,
                seen_status: seen_status, // Fixed the variable name here
                _csrf: yii.getCsrfToken()
            },
            success: function(data) {
                // Optionally handle success response here
            },
            error: function() {
                alert('خطا در تغییر بروزرسانی');
            }
        });
    });
");
?>
<style>
    .fa-bells {
        transition: color 0.5s ease;
    }
</style>
<div class="page-content container-fluid text-left p-0" id="main-wrapper">
    <?php Pjax::begin(['id' => 'p-jax-report-alert', 'enablePushState' => false]); ?>
    <div class="work-report-index card">
        <div class="panel-group m-bot20" id="accordion">
            <div class="card-body page-content container-fluid text-left p-0">
                <?= GridView::widget([
                    'dataProvider' => $dataProvider,
                    'rowOptions' => function (ReportFiredAlert $model, $key, $index, $grid) {
                        if ($model->seen_status == ReportFiredAlert::SEEN) {
                            return ['style' => 'opacity: .75; background-color: aliceblue;'];
                        }
                        return [];
                    },
                    'columns' => [
                        ['class' => 'yii\grid\SerialColumn'],
                        'id',
                        [
                            'attribute' => Yii::t('biDashboard', 'Alert Title'),
                            'value' => function (ReportFiredAlert $model) {
                                return $model->alert->title;
                            },
                        ],
                        [
                            'attribute' => Yii::t('biDashboard', 'Alert Description'),
                            'value' => function (ReportFiredAlert $model) {
                                return $model->alert->description;
                            },
                        ],
                        [
                            'attribute' => Yii::t('biDashboard', 'Ceiling Amount'),
                            'value' => function (ReportFiredAlert $model) {
                                if($model->alert->ceiling)
                                    return number_format($model->alert->ceiling);
                                else
                                    return '_';
                            },
                        ],
                        [
                            'attribute' => Yii::t('biDashboard', 'Floor Amount'),
                            'value' => function (ReportFiredAlert $model) {
                                if($model->alert->floor)
                                    return number_format($model->alert->floor);
                                else
                                    return '_';
                            },
                        ],
                        [
                            'attribute' => Yii::t('biDashboard', 'Widget'),
                            'value' => function (ReportFiredAlert $model) {
                                return $model->widget->title;
                            },
                        ],
                        [
                            'attribute' => Yii::t('biDashboard', 'Alert Reason'),
                            'format' => 'raw',
                            'value' => function (ReportFiredAlert $model) {
                                return ReportFiredAlert::showFiredAlertResult($model->result, $model->widget_field, $model->widget_id);
                            },
                        ],
                        [
                            'class' => \yii\grid\CheckboxColumn::class,
                            'checkboxOptions' => function (ReportFiredAlert $model, $key, $index, $column) {
                                return [
                                    'id' => $model->id,
                                    'value' => $model->id,
                                    'checked' => $model->seen_status ? true : false,
                                    'class' => 'seen_status',
                                ];
                            },
                            'header' => Yii::t('biDashboard', 'Seen'),
                        ],
                        [
                            'attribute' => 'مشاهده توسط',
                            'value' => function (ReportFiredAlert $model) {
                                return $model->user->fullName ?? '_';
                            },
                        ],
                        [
                            'attribute' => 'زمان مشاهده',
                            'value' => function (ReportFiredAlert $model) {
                                if ($model->seen_time === null) {
                                    return '_';
                                }
                                else {
                                    return Yii::$app->pdate->jdate('Y/m/d - H:i:s', $model->seen_time);
                                }
                            },
                        ],
                    ],
                    'summary' => "",
                ]); ?>
            </div>
        </div>
    </div>
    <?php Pjax::end(); ?>
</div>