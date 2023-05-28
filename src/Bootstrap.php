<?php

namespace sadi01\bidashboard;

use sadi01\bidashboard\components\Pdate;
use WebApplication;
use Yii;
use yii\base\Application;
use yii\base\BootstrapInterface;
use yii\i18n\PhpMessageSource;

class Bootstrap implements BootstrapInterface
{
    /**
     * Bootstrap method to be called during application bootstrap stage.
     * @param Application $app the application currently running
     */
    public function bootstrap($app)
    {
        $app->set('pdate', [
            'class' => Pdate::class,
        ]);

        Yii::$app->params['bsVersion'] = 4;

        if (!isset($app->get('i18n')->translations['biDashboard*'])) {
            $app->get('i18n')->translations['biDashboard*'] = [
                'class' => PhpMessageSource::className(),
                'basePath' => __DIR__ . '/messages',
                'sourceLanguage' => 'en-US',
                'fileMap' => [
                    'biDashboard' => 'main.php',
                ],
            ];
        }
    }
}