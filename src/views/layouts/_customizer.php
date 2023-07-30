<?php

use yii\web\View;

/* @var $this View */
?>
<aside class="customizer" dir="rtl">
    <a href="javascript:void(0)" id="customizer_spin" class="service-panel-toggle bg-info">
        <i class="fa fa-universal-access fa-2x"></i>
    </a>
    <div class="customizer-body">
        <ul class="nav customizer-tab" role="tablist">
            <li class="nav-item">
                <a class="nav-link active" id="pills-home-tab" data-toggle="pill" href="#panels" role="tab"
                   aria-controls="pills-home" aria-selected="true">
                    <i class="fas fa-desktop font-20"></i>
                </a>
            </li>
        </ul>
        <div class="tab-content" id="pills-tabContent">
            <!-- Tab 1 -->
            <div class="tab-pane fade show active" id="panels" role="tabpanel" aria-labelledby="pills-home-tab">
                <?= $this->render('_modules') ?>
            </div>
            <!-- End Tab 1 -->
        </div>
    </div>
</aside>