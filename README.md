<p align="center">
    <a href="https://en.wikipedia.org/wiki/Business_intelligence" target="_blank" rel="external">
        <img src="https://raw.githubusercontent.com/Sadi01/yii2-bi-dashboard/master/src/img/yii.png" height="80px">
    </a>
    <a href="https://en.wikipedia.org/wiki/Business_intelligence" target="_blank" rel="external">
        <img src="https://raw.githubusercontent.com/Sadi01/yii2-bi-dashboard/master/src/img/BI.png" height="80px">
    </a>
    <h1 align="center">Business intelligence dashboard for Yii 2</h1>
    <br>
</p>

# Bidashboard

**Bidashboard** is a data visualization dashboard designed to provide insights into key metrics and data for business
intelligence purposes. It allows users to monitor and analyze various aspects of their business in real-time through
interactive charts and graphs.

This extension provides the Business Intelligence Dashboard for the [Yii framework 2.0](http://www.yiiframework.com).

For license information check the [LICENSE](LICENSE.md)-file.

Installation
------------

### Using Composer (Preferred Method):

The preferred way to install this extension is through [composer](http://getcomposer.org/download/):

```
composer require --prefer-dist sadi01/yii2-bi-dashboard:"*"
```

### Alternative Method:

If you prefer adding the bidashboard extension to your `composer.json` file manually, you can do so by adding the
following entry to the `require` section:

```json
{
  "require": {
    "sadi01/yii2-bi-dashboard": "*"
  }
}
```

After adding the entry, save the `composer.json` file and run the following command in the terminal or command prompt
within your project directory:

```
composer update
```

This command will fetch and install the bidashboard extension and its required dependencies into your Yii 2 project.

Configuration
-------------

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

Guides
-------------

- [Routes Guide](./src/guide/routes.md): Explains the purpose and functionalities of various routes in the bidashboard application.

- [Installation Guide](./src/guide/installation.md): Provides detailed instructions on how to install the bidashboard extension using Composer and alternative methods.

- [Usage Guide](./src/guide/usage.md): Offers a comprehensive overview of how to use the bidashboard extension, including how to configure the module and leverage its features.




Env
-------------
Create a new file named `.env` in the root directory of your project and add the following configuration:

```
BI_DB_DSN="mysql:host=localhost;dbname=DBname"
BI_DB_USERNAME="username"
BI_DB_PASSWORD="password"
BI_DB_TABLE_PREFIX=""
BI_DB_CHARSET=utf8
BI_DB_ENABLE_QUERY_CACHE=true
BI_DB_QUERY_CACHE_DURATION=5
BI_DB_ENABLE_SCHEMA_CACHE=true
BI_DB_SCHEMA_CACHE_DURATION=86400
BI_DB_SCHEMA_CACHE_COMPONENT="cache"
```

Make sure to replace `localhost` with the actual hostname or IP address of your MySQL database server.
Set `DBname`, `username`, and `password` to match your database name, database username, and password, respectively.
DB Migrations
-------------
DB Migrations
-------------

Run module migrations:

```php
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

How To Use
-------------
add to view model:

```php
use sadi01\bidashboard\widgets\ReportModalWidget;

<?= ReportModalWidget::widget([
    'queryParams' => $queryParams,
    'searchModel' => $searchModel,
    'searchRoute' => $searchRoute,
    'searchModelFormName' => $searchModelFormName,
]) ?>
```

add to search model:

```php
public function searchWidget(string $params,int $rangeType,int $startRange,int $endRange)
{
    $query = Invoice::find();
    $query->andFilterWhere(['between', 'updated_at', $startRange, $endRange]);
    if ($rangeType == ReportWidget::RANGE_TYPE_MONTHLY) {
    ...
     }
    elseif ($rangeType == ReportWidget::RANGE_TYPE_DAILY) {
    ...    
    }
    $dataProvider = new ActiveDataProvider([
        'query' => $query,
    ]);
    $this->load($params);
    return $dataProvider;
}
```
[more details](https://github.com/Sadi01/yii2-bi-dashboard/guide/usage)