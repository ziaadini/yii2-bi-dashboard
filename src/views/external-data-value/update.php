<?php            //'created_by',
            //'updated_at',
            //'updated_by',
            //'deleted_at',

use yii\helpers\Html;

/** @var yii\web\View $this */
/** @var sadi01\bidashboard\models\ExternalDataValue $model */

$this->title = Yii::t('biDashboard', 'Update External Data Value: {name}', [
    'name' => $model->id,
]);
$this->params['breadcrumbs'][] = ['label' => Yii::t('biDashboard', 'External Data Values'), 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->id, 'url' => ['view', 'id' => $model->id]];
$this->params['breadcrumbs'][] = Yii::t('biDashboard', 'Update');
?>
<div class="external-data-value-update">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
