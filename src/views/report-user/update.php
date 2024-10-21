<?php

use yii\helpers\Html;
use yii\web\View;
use ziaadini\bidashboard\models\ReportUser;

/** @var View $this */
/** @var ReportUser $model */

?>
<div class="report-widget-create">
    <div class="page-content container-fluid text-left ">
        <div class="work-report-index ">
            <div class="panel-group m-bot20" id="accordion">
                <div class="card-body p-0">
                    <?= $this->render('_form', [
                        'model' => $model,
                    ]) ?>
                </div>
            </div>
        </div>
    </div>
</div>