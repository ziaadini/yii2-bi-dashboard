<?php

use ziaadini\bidashboard\models\ReportUser;
use yii\helpers\Html;
use yii\web\View;

/** @var ReportUser $model */
/** @var View $this */

?>
<div class="report-widget-create">
    <div class="page-content container-fluid text-left">
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