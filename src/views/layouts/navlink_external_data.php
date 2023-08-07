<?php

use yii\helpers\Html;

/**@var $isExternalDataValuePage boolean */
?>

<ul class="nav nav-tabs" id="myTab" role="tablist">
    <li class="nav-item col-sm-6 text-center">
        <?= Html::a(Yii::t('biDashboard', 'Data External'),
            ['/bidashboard/external-data/index'],
            ['class' => $isExternalDataValuePage ? 'nav-link' : 'nav-link active']); ?>
    </li>
    <li class="nav-item col-sm-6 text-center">
        <?= Html::a(Yii::t('biDashboard', 'Data External Value'),
            ['/bidashboard/external-data-value/index'],
            ['class' =>  $isExternalDataValuePage == 'true' ? 'nav-link active' : 'nav-link']); ?>
    </li>
</ul>