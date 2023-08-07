<?php

use yii\helpers\Html;

/** @var yii\web\View $this */
/** @var sadi01\bidashboard\models\ExternalData $model */

$this->title = Yii::t('biDashboard', 'Update External Data: {name}', [
    'name' => $model->title,
]);
$this->params['breadcrumbs'][] = ['label' => Yii::t('biDashboard', 'External Datas'), 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->title, 'url' => ['view', 'id' => $model->id]];
$this->params['breadcrumbs'][] = Yii::t('biDashboard', 'Update');
?>
<div class="external-data-update">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
