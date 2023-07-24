<?php
use sadi01\bidashboard\components\Env;

return [
    'class' => 'yii\db\Connection',
    'dsn' => Env::get('BI_DB_DSN',''),
    'username' => Env::get('BI_DB_USERNAME',''),
    'password' => Env::get('BI_DB_PASSWORD',''),
    'charset' => 'utf8',
];