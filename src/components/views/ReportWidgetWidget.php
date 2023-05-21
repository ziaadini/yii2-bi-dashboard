<?php

namespace sadi01\bidashboard\components\views;

use yii\bootstrap4\Modal;
use yii\helpers\Url;
use yii\web\View;
use Yii;

$this->title = 'Bi dashboard widget';

Modal::begin([
    'title' => '<h2>افزودن ویجت</h2>',
    'toggleButton' => [
        'label' => 'افزودن ویجت',
        'class' => 'btn btn-info'
    ],
    'centerVertical' => false,
    'size' => 'modal-xl',
]);
?>

<?= $this->render('@sadi01/bidashboard/views/report-widget/_form', [
    'model' => $model,
    'searchModel' => $searchModel,
    'params' => $params
]) ?>

<div class="table-responsive">
    <table class="table table-striped table-bordered">
        <thead>
        <tr>
            <th>ویژگی</th>
            <th>مقدار</th>
        </tr>
        </thead>
        <tbody>
        <?php foreach ($params as $Pkey => $Pvalue): ?>
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
