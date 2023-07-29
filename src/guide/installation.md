
## Usage
To use this widget, insert the following code into a view file:
```php
        <?= ReportModalWidget::widget([
            'queryParams' => $queryParams,
            'searchModel' => $searchModel,
            'searchModelMethod' => $searchModelMethod,
            'searchRoute' => Yii::$app->request->pathInfo,
            'searchModelFormName' => $searchModelFormName,
            'outputColumn' => $outputColumn,
        ]) ?>

```
## Parameters Reference

| Parameter             | Type     | Description  | example                           |
|:----------------------|:---------|:-------------|:----------------------------------|
| `queryParams`         | `array`  | **Required** | [example](https://github.com/)    |
| `searchModel`         | `string` | **Required** | 'app\models\search\InvoiceSearch' |
| `searchModelMethod`   | `string` | **Required** | 'search'                          |
| `searchRoute`         | `string` | **Required** | 'invoice/index'                   |
| `searchModelFormName` | `string` | **Required** | 'InvoiceSearch'                   |
| `outputColumn`        | `array`  | **Required** | [example](https://github.com/)    |

### queryParams ###
> Search parameters in the model that are received as an array

for example:
```php
$queryParams = Yii::$app->request->getQueryParams();
```
### searchModel ###
> A string that contains the name of the class model that should be present in that database search method

for example:
```php
$searchModel = InvoiceSearch::class;
```
### searchModelMethod ###
> A string that contains the name of the method that the widget should call and return

for example:
```php
$searchModelMethod = 'search';
```
### searchRoute ###
> A string containing the address of the page where the widget was created

for example:
```php
$searchRoute = Yii::$app->request->getQueryParams();
```
### searchModelFormName ###
> A string containing the name of the model in which the search is performed

for example:
```php
$searchModelFormName = key(Yii::$app->request->getQueryParams());
```
### outputColumn ###
> An array that the programmer specifies which fields the query output data includes, these fields are used to display on pages and dashboards.

for example:
```php
[
    "day" => "روز",
    "year"=> "سال",
    "month"=> "ماه",
    "total_count"=> "تعداد",
    "total_amount"=> "جمع‌کل"
]