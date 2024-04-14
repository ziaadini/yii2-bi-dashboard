<?php

use yii\helpers\Html;
use yii\helpers\Url;
use yii\widgets\DetailView;
use sadi01\bidashboard\models\ReportModelClass;
use sadi01\bidashboard\models\ReportPage;
use yii\web\View;
use sadi01\bidashboard\models\ReportWidgetResult;

use yii\widgets\Pjax;

/** @var yii\web\View $this */
/**
 * @var $modelRoute string
 * @var $runWidget ReportWidgetResult
 * @var sadi01\bidashboard\models\ReportWidget $model
 */

$this->title = $model->title;
$this->params['breadcrumbs'][] = ['label' => Yii::t('biDashboard', 'Report Widgets'), 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<?php Pjax::begin(['id' => 'p-jax-report-widget', 'enablePushState' => false]); ?>
<div class="report-widget-view">
    <div class="page-content container-fluid text-left">
        <div class="work-report-index card">
            <div class="panel-group m-bot20" id="accordion">
                <div class="card-header d-flex justify-content-between">
                    <h4 class="panel-title">
                        <?= Html::encode($this->title) ?>
                    </h4>
                    <div>
                        <?= Html::a(
                            Yii::t('biDashboard', 'Show model'),
                            [$modelRoute],
                            [
                                'data-pjax' => '0',
                                'target' => '_blank',
                                'class' => 'btn btn-info rounded-md',
                            ]
                        ) ?>
                    </div>
                </div>
                <div class="card-body">
                    <?= DetailView::widget([
                        'model' => $model,
                        'attributes' => [
                            'id',
                            'title',
                            'description',
                            [
                                'attribute' => 'search_model_class',
                                'value' => function ($data) {
                                    return ReportModelClass::itemAlias('list', $data->search_model_class);
                                },
                            ],
                            'search_model_method',
                            [
                                'attribute' => 'status',
                                'value' => function ($data) {
                                    return $data->itemAlias('Status', $data->status);
                                },
                            ],
                            [
                                'attribute' => 'range_type',
                                'value' => function ($data) {
                                    return $data->itemAlias('RangeTypes', $data->range_type);
                                },
                            ],
                            [
                                'attribute' => 'visibility',
                                'value' => function ($data) {
                                    return $data->itemAlias('Visibility', $data->visibility);
                                },
                            ],
                            [
                                'attribute' => 'updated_at',
                                'value' => function ($item) {
                                    return Yii::$app->pdate->jdate('Y/m/d-h:i', $item->updated_at);
                                }
                            ],
                            [
                                'attribute' => 'created_at',
                                'value' => function ($item) {
                                    return Yii::$app->pdate->jdate('Y/m/d-h:i', $item->created_at);
                                }
                            ],
                        ],
                    ]) ?>
                </div>
                <div class="card-body">
                    <h4>پارامترهای ورودی</h4>
                    <table class="table table-striped table-bordered text-center kv-grid-table">
                        <thead class="kv-table-header w1">
                        <tr>
                            <th>پارامتر</th>
                            <th>مقدار</th>
                        </tr>
                        </thead>
                        <tbody>
                        <?php foreach ($model->params as $key => $value): ?>
                            <tr>
                                <td><?= $key ?></td>
                                <td><?= json_encode($value) ?></td>
                            </tr>
                        <?php endforeach; ?>
                        </tbody>
                    </table>
                </div>
                <div class="card-body">
                    <h4>پارامترهای خروجی</h4>
                    <table class="table table-striped table-bordered text-center kv-grid-table">
                        <thead class="kv-table-header w1">
                        <tr>
                            <th>پارامتر</th>
                            <th>مقدار</th>
                        </tr>
                        </thead>
                        <tbody>
                        <?php foreach ($model->outputColumn as $key => $value): ?>
                            <tr>
                                <td><?= $value['column_name'] ?></td>
                                <td><?= $value['column_title'] ?></td>
                            </tr>
                        <?php endforeach; ?>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>
<?php Pjax::end(); ?>
