<?php

use yii\helpers\Html;
use yii\widgets\DetailView;

/** @var yii\web\View $this */
/** @var sadi01\bidashboard\models\ExternalDataValue $model */

$this->title = $model->id;
$this->params['breadcrumbs'][] = ['label' => Yii::t('biDashboard', 'External Data Values'), 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="external-data-value-view">

    <h1><?= Html::encode($this->title) ?></h1>

    <p>
        <?= Html::a(Yii::t('biDashboard', 'Update'), ['update', 'id' => $model->id], ['class' => 'btn btn-primary']) ?>
        <?= Html::a(Yii::t('biDashboard', 'Delete'), ['delete', 'id' => $model->id], [
            'class' => 'btn btn-danger',
            'data' => [
                'confirm' => Yii::t('biDashboard', 'Are you sure you want to delete this item?'),
                'method' => 'post',
            ],
        ]) ?>
    </p>

    <?= DetailView::widget([
        'model' => $model,
        'attributes' => [
            'id',
            'external_data_id',
            'value',
        ],
    ]) ?>

</div>
