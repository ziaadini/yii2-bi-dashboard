<?php

use yii\helpers\Html;
use yii\widgets\DetailView;

/** @var yii\web\View $this */
/** @var sadi01\bidashboard\models\ReportModelClass $model */

$this->title = $model->id;
$this->params['breadcrumbs'][] = ['label' => Yii::t('biDashboard', 'Report Model Classes'), 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
\yii\web\YiiAsset::register($this);
?>
<div class="report-widget-view">

    <div class="page-content container-fluid text-left pt-5">
        <div class="work-report-index card">
            <div class="panel-group m-bot20" id="accordion">
                <div class="card-header d-flex justify-content-between">
                    <h4 class="panel-title">
                        <?= Html::encode($this->title) ?>
                    </h4>
                    <div>
                        <?= Html::a(Yii::t('biDashboard', 'Update'), ['update', 'id' => $model->id], ['class' => 'btn btn-primary']) ?>
                        <?= Html::a(Yii::t('biDashboard', 'Delete'), ['delete', 'id' => $model->id], [
                            'class' => 'btn btn-danger',
                            'data' => [
                                'confirm' => Yii::t('biDashboard', 'Are you sure you want to delete this item?'),
                                'method' => 'post',
                            ],
                        ]) ?>
                    </div>
                </div>
                <div class="card-body">
                    <?= DetailView::widget([
                        'model' => $model,
                        'attributes' => [
                            'id',
                            'title',
                            'search_model_class',
                            'search_model_method',
                            'search_model_run_result_view',
                            [
                                'attribute' => 'status',
                                'value' => function ($data) {
                                    return $data->itemAlias('Status',$data->status);
                                },
                            ],
                        ],
                    ]) ?>
                </div>
            </div>
        </div>
    </div>

</div>
