<?php

namespace sadi01\bidashboard;

use yii\web\AssetBundle;
class BiAssets extends AssetBundle
{
    public $sourcePath = '@sadi01/bidashboard/assets';

    public $css = [
        'bidashboard/dist/css/style.min.css',
        'bidashboard/dist/css/iranSansNumber.css',
    ];
    public $js = [
        'bidashboard/libs/jquery/dist/jquery.min.js',
        'bidashboard/libs/bootstrap/dist/js/bootstrap.min.js',
        'bidashboard/dist/js/app.min.js',
        'bidashboard/dist/js/app.init.mini-sidebar.js',
        'bidashboard/libs/perfect-scrollbar/dist/perfect-scrollbar.jquery.min.js',
        'bidashboard/dist/js/sidebarmenu.js',
        'bidashboard/dist/js/custom.min.js',
    ];
    public $depends = [
        'yii\web\YiiAsset',
        'yii\widgets\ActiveFormAsset',
        'yii\validators\ValidationAsset',
    ];

}