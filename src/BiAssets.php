<?php

namespace sadi01\bidashboard;

use yii\web\AssetBundle;

class BiAssets extends AssetBundle
{
    public $sourcePath = '@sadi01/bidashboard/assets';

    public $css = [
        'bidashboard/dist/css/fontiran.css',
        'bidashboard/dist/css/footable.bootstrap.min.css',
        'bidashboard/dist/css/horizontal-timeline.css',
        'bidashboard/dist/css/fonts/iranSansNumber/css/style.css',
        'bidashboard/dist/css/fonts/font-awesome/css/all.min.css',
        'bidashboard/dist/css/sweetalert2.min.css',
        "bidashboard/dist/css/custom.css",
        "bidashboard/dist/css/jalalidatepicker.min.css",
    ];

    public $js = [
        'bidashboard/dist/js/app.min.js',
        'bidashboard/dist/js/app-style-switcher.js',
        'bidashboard/dist/js/base.js',
        'bidashboard/dist/js/waves.js',
        'bidashboard/dist/js/smooth-scroll.min.js',
        'bidashboard/dist/js/app.init.mini-sidebar.js',
        'bidashboard/libs/perfect-scrollbar/dist/perfect-scrollbar.jquery.min.js',
        'bidashboard/dist/js/assets/libs/jquery.repeater/jquery.repeater.min.js',
        'bidashboard/dist/js/pjax-utility.js',
        'bidashboard/dist/js/jquery.pjax.js',
        'bidashboard/dist/js/sweetalert2.min.js',
        'bidashboard/dist/js/sweetalert2.all.min.js',
        'bidashboard/dist/js/sweet-alert.init.js',
        'bidashboard/dist/js/custom.min.js',
        'bidashboard/dist/js/sparkline/sparkline.js',
        'bidashboard/dist/js/utility.js',
        'bidashboard/dist/js/wordcloud.min.js',
    ];

    public $depends = [
        'yii\web\YiiAsset',
        'yii\bootstrap4\BootstrapPluginAsset',
        'miloschuman\highcharts\HighchartsAsset'
    ];
}