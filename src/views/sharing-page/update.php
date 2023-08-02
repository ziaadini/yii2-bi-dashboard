<?php

use yii\helpers\Html;

/** @var yii\web\View $this */
/** @var app\models\SharingPage $model */

$this->title = Yii::t('biDashboard', 'Update Sharing Page: {name}', [
    'name' => $model->id,
]);
$this->params['breadcrumbs'][] = ['label' => Yii::t('biDashboard', 'Sharing Pages'), 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->id, 'url' => ['view', 'id' => $model->id]];
$this->params['breadcrumbs'][] = Yii::t('biDashboard', 'Update');
?>
<div class="report-widget-create">
    <div class="page-content container-fluid text-left pt-5">
        <div class="work-report-index card">
            <div class="panel-group m-bot20" id="accordion">
                <div class="card-body">
                    <?= $this->render('_form', [
                        'model' => $model,
                    ]) ?>
                </div>
            </div>
        </div>
    </div>
</div>
