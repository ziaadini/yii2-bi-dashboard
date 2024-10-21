<?php

use ziaadini\bidashboard\models\ReportAlert;
use yii\helpers\Html;
use yii\web\View;

/** @var ReportAlert $model */
/** @var View $this */

$this->title = Yii::t('biDashboard', 'Create Alert');
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="report-widget-create">
    <div class="page-content text-left">
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