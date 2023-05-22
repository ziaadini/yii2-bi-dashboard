<?php

use yii\helpers\Html;

/** @var yii\web\View $this */
/** @var sadi01\bidashboard\models\ReportModelClass $model */

$this->title = Yii::t('biDashboard', 'Create Report Model Class');
$this->params['breadcrumbs'][] = ['label' => Yii::t('biDashboard', 'Report Model Classes'), 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="report-widget-create">
    <div class="page-content container-fluid text-left pt-5">
        <div class="work-report-index card">
            <div class="panel-group m-bot20" id="accordion">
                <div class="card-header d-flex justify-content-between">
                    <h4 class="panel-title">
                        <?= Html::encode($this->title) ?>
                    </h4>
                </div>
                <div class="card-body">
                    <?= $this->render('_form', [
                        'model' => $model,
                    ]) ?>
                </div>
            </div>
        </div>
    </div>
</div>
