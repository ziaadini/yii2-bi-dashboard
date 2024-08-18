### Prerequisites

Before installing and using the bidashboard, ensure you have the following prerequisites installed:

1. **PHP**: Ensure you have PHP installed on your server or local machine. The bidashboard is built for the Yii2
   framework, which requires PHP to be set up.

2. **Yii Framework 2.0**: Make sure you have the Yii framework version 2.0 (or higher) installed on your system.

3. **Composer**: The preferred way to install the bidashboard extension is through Composer. Make sure you have Composer
   installed. If you don't have Composer yet, you can download it
   from [getcomposer.org](http://getcomposer.org/download/).

4. **Other Dependencies**: The bidashboard extension may have other dependencies listed in the `composer.json` file,
   such as Yii2 Bootstrap, Kartik Grid, and others. Ensure these dependencies are installed as well.

### Installation

The preferred way to install this extension is through [composer](http://getcomposer.org/download/):

```bash
composer require --prefer-dist ziaadini/yii2-bi-dashboard:"*"
```

To use this extension, you have to configure the bidashboard module in your application configuration:

```php
return [
    //....
    'modules' => [
        'bidashboard' => [
            'class' => 'ziaadini\bidashboard\Module',
        ],
    ]
];
```

### Important

Important: You need to set the bi_slave_id parameter in your params.php configuration file. This parameter is crucial
for the proper functioning of the bidashboard extension. Make sure it's set to a valid value before proceeding further.

### Env
You have to add the database configuration to env, its example is in - [Env.example](./src/env-config/.env.example)

### DB Migrations

Run module migrations:

```bash
php yii migrate --migrationPath=@ziaadini/bidashboard/migrations
```

Or, Add migrations path in console application config:

```php
'controllerMap' => [
    'migrate' => [
        'class' => 'yii\console\controllers\MigrateController',
        'migrationNamespaces' => [
         
        ],
        'migrationPath' => [
            '@vendor/ziaadini/yii2-bi-dashboard/src/migrations',
            '@app/migrations'
        ]
    ],
],
```

## Handling PersianDate4MySQL in Migrations

The [PersianDate4MySQL](https://github.com/zoghal/PersianDate4MySQL) library is used to handle Persian (Jalali) dates in
MySQL migrations. The library provides six
handy functions that enable you to work with Persian dates seamlessly.

## License

BSD 3-Clause License

Copyright (c) 2023, Sadegh Shafii
All rights reserved.
[License](https://github.com/ziaadini/yii2-bi-dashboard/blob/master/LICENSE.md)
