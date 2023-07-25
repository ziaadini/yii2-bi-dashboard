<?php

namespace sadi01\bidashboard;

use sadi01\bidashboard\components\Env;
use sadi01\bidashboard\components\Pdate;
use WebApplication;
use Yii;
use yii\base\Application;
use yii\base\BootstrapInterface;
use yii\base\InvalidConfigException;
use yii\console\Application as YiiConsole;
use yii\i18n\PhpMessageSource;
use yii\web\HttpException;

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
                'class' => PhpMessageSource::class,
                'basePath' => __DIR__ . '/messages',
                'sourceLanguage' => 'en-US',
                'fileMap' => [
                    'biDashboard' => 'main.php',
                ],
            ];
        }

        Yii::$app->setComponents([
            'biDB' => require __DIR__ . '/config/db.php',
        ]);

        if (!(Yii::$app instanceof YiiConsole)) {
            if (!Env::get('BI_DB_DSN') or !Env::get('BI_DB_USERNAME') or !Env::get('BI_DB_PASSWORD')) {
                if (!Env::get('BI_DB_DSN')) {
                    $parameter = 'BI_DB_DSN';
                } elseif (!Env::get('BI_DB_USERNAME')) {
                    $parameter = 'BI_DB_USERNAME';
                } elseif (!Env::get('BI_DB_PASSWORD')) {
                    $parameter = 'BI_DB_PASSWORD';
                }
                throw new InvalidConfigException(Yii::t('biDashboard', 'The {env_parameter} parameter is not set, add the parameter in the env file of the project.', ['env_parameter' => $parameter]));
            }
        }

    }
}