<?php

namespace sadi01\bidashboard\components\views;

use yii\bootstrap4\Modal;
use yii\helpers\Url;
use yii\web\View;
use yii\widgets\Pjax;
use Yii;

$this->title = 'Bi dashboard widget';
if (!$queryParams){
    return false;
}
Pjax::begin(['id' => 'modal_create_bidashboard_widget']);

Modal::begin([
    'title' => Yii::t('biDashboard', 'add widget'),
    'id' => 'bidashboard_modal',
    'toggleButton' => [
        'label' => Yii::t('biDashboard', 'add widget'),
        'class' => 'btn btn-info',
    ],
    'centerVertical' => false,
    'size' => 'modal-xl',
]);
?>

<?= $this->render('@sadi01/bidashboard/views/report-widget/_form', [
    'model' => $model,
    'searchModel' => $searchModel,
    'queryParams' => $queryParams
]) ?>
<div class="table-responsive">
    <table class="table table-striped table-bordered">
        <thead>
        <tr>
            <th><?= Yii::t('biDashboard', 'attribute') ?></th>
            <th><?= Yii::t('biDashboard', 'value') ?></th>
        </tr>
        </thead>
        <tbody>
        <?php foreach ($queryParams as $Pkey => $Pvalue): ?>
            <tr>
                <td>
                    <?= Yii::t('app', $Pkey) ?>
                </td>
                <td>
                    <?= $Pvalue ?>
                </td>
            </tr>
        <?php endforeach; ?>
        </tbody>
    </table>
</div>

<?php Modal::end(); ?>
<?php Pjax::end(); ?>
