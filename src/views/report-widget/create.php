<?php

use yii\helpers\Html;

/**
 * @var yii\web\View $this
 * @var sadi01\bidashboard\models\ReportWidget $model
 * @var $queryString string
 * @var $queryParams array
 * @var $output_column array
 */
$this->title = Yii::t('biDashboard', 'Create Report Widget');
$this->params['breadcrumbs'][] = ['label' => Yii::t('biDashboard', 'Report Widgets'), 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="report-widget-create">
    <div class="page-content container-fluid text-left">
        <div class="work-report-index card">
            <div class="panel-group m-bot20" id="accordion">
                <div class="card-body">
                    <?= $this->render('_form', [
                        'model' => $model,
                        'queryParams' => $queryParams,
                        'output_column' => $output_column,
                    ]) ?>
                </div>
            </div>
        </div>
    </div>
</div>
