<?php

use yii\helpers\Html;

/** @var yii\web\View $this */
/** @var ziaadini\bidashboard\models\ReportModelClass $model */

$this->title = Yii::t('biDashboard', 'Update Report Model Class: {name}', [
    'name' => $model->title,
]);
$this->params['breadcrumbs'][] = ['label' => Yii::t('biDashboard', 'Report Model Classes'), 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->title, 'url' => ['view', 'id' => $model->id]];
$this->params['breadcrumbs'][] = Yii::t('biDashboard', 'Update');
?>
<div class="page-content container-fluid text-left">
    <div class="work-report-index">
        <div class="panel-group m-bot20" id="accordion">
            <?= $this->render('_form', [
                'model' => $model,
            ]) ?>
        </div>
    </div>
</div>