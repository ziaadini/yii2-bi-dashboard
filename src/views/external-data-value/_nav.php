<?php

use yii\helpers\Html;
use yii\web\View;

/* @var $this View */
/* @var $model */

?>
<ul class="nav nav-tabs nav-fill bg-light pt-1">
    <li class="nav-item">
        <?= Html::a('نوع داده ها', ['external-data/index'],
            ['class' => Yii::$app->controller->action->uniqueId == 'intelligent/external-data/index' ? 'nav-link active' : 'nav-link']) ?>
    </li>
    <li class="nav-item">
        <?= Html::a('مقادیر داده ها', ['external-data-value/index'],
            ['class' => Yii::$app->controller->action->uniqueId == 'intelligent/external-data-value/index' ? 'nav-link active' : 'nav-link']) ?>
    </li>
</ul>