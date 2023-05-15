<?php

namespace sadi01\bidashboard\assets;

use yii\web\AssetBundle;

class AppAsset extends AssetBundle
{
    public $sourcePath = '@sadi01/bidashboard/assets/theme';


    public $css = [
    ];
    public $js = [
    ];
    public $depends = [
        'yii\web\YiiAsset',
        'yii\bootstrap5\BootstrapAsset',
        'yii\widgets\ActiveFormAsset',
        'yii\validators\ValidationAsset',
    ];
}