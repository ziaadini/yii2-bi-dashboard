<?php

namespace sadi01\bidashboard;

use yii\web\AssetBundle;
class BiAssets extends AssetBundle
{
    public $sourcePath = '@sadi01/bidashboard/assets';

    public $css = [
        "bidashboard/dist/css/custom.css",
    ];

    public $js = [
        'bidashboard/dist/js/assets/libs/jquery.repeater/jquery.repeater.min.js',
        'bidashboard/dist/js/pjax-utility.js?v=1.2',
        'bidashboard/dist/js/custom.min.js?v=1.2',
    ];

    public $depends = [
        'yii\web\YiiAsset',
        'yii\bootstrap4\BootstrapPluginAsset',
    ];
}