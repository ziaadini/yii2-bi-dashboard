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
<div class="page-content container-fluid text-left">
    <div class="work-report-index">
        <div class="panel-group m-bot20" id="accordion">

            <?= $this->render('_form', [
                'model' => $model,
            ]) ?>

        </div>
    </div>
</div>
