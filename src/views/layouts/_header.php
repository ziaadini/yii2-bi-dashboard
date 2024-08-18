<?php

use yii\helpers\Html;
use yii\helpers\Url;
use yii\web\View;

$url = Yii::$app->assetManager->getPublishedUrl('@ziaadini/bidashboard/assets');

/* @var $this View */
?>
<header class="topbar custom_background_color2">
    <nav class="navbar top-navbar navbar-expand-md navbar-dark">
        <div class="navbar-header">
            <!-- This is for the sidebar toggle which is visible on mobile only -->
            <a class="nav-toggler waves-effect waves-light d-block d-md-none" href="javascript:void(0)">
                <i class="fal fa-bars"></i></a>
            <a class="navbar-brand" href="<?= Url::to(['/bidashboard']) ?>">
                <!-- Logo icon -->
                <b class="logo-icon">
                    <!--                    --><?php //= Html::img($url.'/bidashboard/images/BI.png', ['style' => 'background-color: white; height: 20px;','href'=>'javascript:void(0)','id'=>'logo-close']) 
                                                ?>
                    <?= Html::img($url . '/bidashboard/images/BI.png', ['style' => 'height: 50px;', 'href' => 'javascript:void(0)', 'id' => 'logo-expand']) ?>
                </b>
                <!--End Logo icon -->
            </a>



            <!-- ============================================================== -->
            <!-- End Logo -->
            <!-- ============================================================== -->
            <!-- ============================================================== -->
            <!-- Toggle which is visible on mobile only -->
            <!-- ============================================================== -->
            <a class="topbartoggler d-block d-md-none waves-effect waves-light" href="javascript:void(0)"
                data-toggle="collapse" data-target="#navbarSupportedContent" aria-controls="navbarSupportedContent"
                aria-expanded="false" aria-label="Toggle navigation"><i class="fal fa-ellipsis-h"></i></a>
        </div>
        <!-- ============================================================== -->
        <!-- End Logo -->
        <!-- ============================================================== -->
        <div class="navbar-collapse collapse custom_background_color2" id="navbarSupportedContent">
            <!-- ============================================================== -->
            <!-- toggle and nav items -->
            <!-- ============================================================== -->
            <ul class="navbar-nav float-left mr-auto ">

                <!-- ============================================================== -->
                <!-- Logo -->
                <!-- ============================================================== -->
                <li class="nav-item d-none d-md-block" id="button-collapse">
                    <a class="nav-link sidebartoggler waves-effect waves-light" href="javascript:void(0)" data-sidebartype="mini-sidebar">
                        <i class="fal fa-bars font-18"></i>
                    </a>
                </li>
            </ul>
            <a class="text-white" href="<?= Url::to(['/']) ?>">
                <div class="">
                    <span class="fa fa-home"></span>
                    <?= Yii::t('biDashboard', 'Return To Home') ?>
                </div>
            </a>
        </div>
    </nav>
</header>