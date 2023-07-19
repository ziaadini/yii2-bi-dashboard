<?php

use sadi01\bidashboard\models\ReportPage;
use Yii;
use yii\helpers\Html;
use yii\web\View;

/** @var View $this */
/** @var ReportPage $model */

$this->title = Yii::t('biDashboard', 'Create Report Page');
$this->params['breadcrumbs'][] = ['label' => Yii::t('biDashboard', 'Report Pages'), 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="report-widget-create">
    <div class="page-content container-fluid text-left pt-5">
        <div class="work-report-index">
            <div class="panel-group m-bot20" id="accordion">
                <div class="report-page-create">

                    <?= $this->render('_form', [
                        'model' => $model,
                    ]) ?>

                </div>
            </div>
        </div>
    </div>
</div>