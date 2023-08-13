<?php

/** @var yii\web\View $this */
/** @var sadi01\bidashboard\models\ExternalDataValue $model */

$this->title = Yii::t('biDashboard', 'Create External Data Value');
$this->params['breadcrumbs'][] = ['label' => Yii::t('biDashboard', 'External Data Values'), 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
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
