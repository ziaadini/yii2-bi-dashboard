<?php

use yii\helpers\Html;

/** @var yii\web\View $this */
/** @var sadi01\bidashboard\models\ReportWidget $model */

$this->title = Yii::t('biDashboard', 'Create Report Widget');
$this->params['breadcrumbs'][] = ['label' => Yii::t('biDashboard', 'Report Widgets'), 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="report-widget-create">
    <div class="page-content container-fluid text-left pt-5">
        <div class="work-report-index card">
            <div class="panel-group m-bot20" id="accordion">
                <div class="card-body">
                    <?= $this->render('_form', [
                        'model' => $model,
                        'searchModelClass' => $searchModelClass,
                        'searchModelMethod' => $searchModelMethod,
                        'searchModelRunResultView' => $searchModelRunResultView,
                        'searchRoute' => $search_route,
                        'searchModelFormName' => $search_model_form_name,
                        'queryParams' => json_decode($queryParams),
                    ]) ?>
                </div>
            </div>
        </div>
    </div>
</div>
