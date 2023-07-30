### Prerequisites

Before installing and using the bidashboard, ensure you have the following prerequisites installed:

1. **PHP**: Ensure you have PHP installed on your server or local machine. The bidashboard is built for the Yii2 framework, which requires PHP to be set up.

2. **Yii Framework 2.0**: Make sure you have the Yii framework version 2.0 (or higher) installed on your system.

3. **Composer**: The preferred way to install the bidashboard extension is through Composer. Make sure you have Composer installed. If you don't have Composer yet, you can download it from [getcomposer.org](http://getcomposer.org/download/).

4. **Other Dependencies**: The bidashboard extension may have other dependencies listed in the `composer.json` file, such as Yii2 Bootstrap, Kartik Grid, and others. Ensure these dependencies are installed as well.

### Installation

The preferred way to install this extension is through [composer](http://getcomposer.org/download/):

```bash
composer require --prefer-dist sadi01/yii2-bi-dashboard:"*"
```

To use this extension, you have to configure the bidashboard module in your application configuration:

```php
return [
    //....
    'modules' => [
        'bidashboard' => [
            'class' => 'sadi01\bidashboard\Module',
        ],
    ]
];
```

### DB Migrations

Run module migrations:

```bash
php yii migrate --migrationPath=@sadi01/bidashboard/migrations
```

Or, Add migrations path in console application config:

```php
'controllerMap' => [
    'migrate' => [
        'class' => 'yii\console\controllers\MigrateController',
        'migrationNamespaces' => [
            'sadi01\bidashboard\migrations',
        ],
    ],
],
```
## License

BSD 3-Clause License

Copyright (c) 2023, Sadegh Shafii
All rights reserved.
[License](https://github.com/Sadi01/yii2-bi-dashboard/blob/master/LICENSE.md)