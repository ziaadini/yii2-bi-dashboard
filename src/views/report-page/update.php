<?php

use yii\helpers\Html;
use yii\web\View;
use sadi01\bidashboard\models\ReportPage;
use Yii;

/** @var View $this */
/** @var ReportPage $model */

$this->title = Yii::t('app', 'Update Report Page: {name}', [
    'name' => $model->title,
]);
$this->params['breadcrumbs'][] = ['label' => Yii::t('app', 'Report Pages'), 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->title, 'url' => ['view', 'id' => $model->id]];
$this->params['breadcrumbs'][] = Yii::t('app', 'Update');
?>
<div class="report-widget-create">
    <div class="page-content container-fluid text-left ">
        <div class="work-report-index ">
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