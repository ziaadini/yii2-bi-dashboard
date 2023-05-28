<?php

use sadi01\bidashboard\models\ReportPage;
use Yii;
use yii\helpers\Html;
use yii\web\View;

/** @var View $this */
/** @var ReportPage $model */

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