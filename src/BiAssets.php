<?php

namespace sadi01\bidashboard;

use yii\web\AssetBundle;
class BiAssets extends AssetBundle
{
    public $sourcePath = '@sadi01/bidashboard/assets';

    public $css = [
        'bidashboard/dist/css/style.min.css',
        'bidashboard/dist/css/iranSansNumber.css',
        'bidashboard/dist/css/sweetalert2.min.css',
    ];
    public $js = [
        'bidashboard/libs/jquery/dist/jquery.min.js',
        'bidashboard/libs/bootstrap/dist/js/bootstrap.min.js',
        'bidashboard/dist/js/app.min.js',
        'bidashboard/dist/js/app.init.mini-sidebar.js',
        'bidashboard/libs/perfect-scrollbar/dist/perfect-scrollbar.jquery.min.js',
        'bidashboard/dist/js/sidebarmenu.js',
        'bidashboard/dist/js/custom.min.js',
        'bidashboard/dist/js/pjax-utility.js',
        'bidashboard/dist/js/jquery.pjax.js',
        'bidashboard/dist/js/SweetAlert.js',
        'bidashboard/dist/js/sweetalert2.min.js',
        'bidashboard/dist/js/sweetalert2.all.min.js',
        'bidashboard/dist/js/sweet-alert.init.js',

    ];
    public $depends = [
        'yii\web\YiiAsset',
        'yii\widgets\ActiveFormAsset',
        'yii\validators\ValidationAsset',
    ];

}