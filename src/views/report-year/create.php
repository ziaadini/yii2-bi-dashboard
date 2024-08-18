<?php

use yii\helpers\Html;

/** @var yii\web\View $this */
/** @var ziaadini\bidashboard\models\ReportYear $model */

$this->title = Yii::t('app', 'Create Report Year');
$this->params['breadcrumbs'][] = ['label' => Yii::t('app', 'Report Years'), 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="report-year-create">
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