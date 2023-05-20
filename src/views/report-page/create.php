<?php

use yii\helpers\Html;

/** @var yii\web\View $this */
/** @var \ReportPage $model */

$this->title = Yii::t('app', 'Create Report Page');
$this->params['breadcrumbs'][] = ['label' => Yii::t('app', 'Report Pages'), 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="report-page-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
