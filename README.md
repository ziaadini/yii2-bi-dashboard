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

This extension provides the Business Intelligence Dashboard for the [Yii framework 2.0](http://www.yiiframework.com).

For license information check the [LICENSE](LICENSE.md)-file.

Installation
------------

The preferred way to install this extension is through [composer](http://getcomposer.org/download/):


```
composer require --prefer-dist sadi01/yii2-bi-dashboard:"*"
```

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

How To Use
-------------

```php
<?= ReportWidgetWidget::widget(['params' => $params, 'searchModel' => $searchModel]) ?>
```