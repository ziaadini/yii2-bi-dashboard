<?php

use yii\helpers\Html;

/** @var yii\web\View $this */
/** @var app\models\SharingPage $model */

$this->title = Yii::t('app', 'Create Sharing Page');
$this->params['breadcrumbs'][] = ['label' => Yii::t('app', 'Sharing Pages'), 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="report-widget-create">
    <div class="page-content container-fluid text-left pt-5">
        <div class="work-report-index">
            <div class="panel-group m-bot20" id="accordion">
                <div class="report-page-create">
                    <h1><?= Html::encode($this->title) ?></h1>
                    <?= $this->render('_form', [
                        'model' => $model,
                    ]) ?>
                </div>
            </div>
        </div>
    </div>
</div>
