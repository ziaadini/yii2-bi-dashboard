
## Usage/View
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
```

## Usage/SearchModel

To use this widget, insert the following code into a method in saerch Model class file:

```php
public function searchWidget(string $params,int $rangeType,int $startRange,int $endRange)
{
    $query = Invoice::find();
    $query->andFilterWhere(['between', 'updated_at', $startRange, $endRange]);
    if ($rangeType == ReportWidget::RANGE_TYPE_MONTHLY) {
        $query->select([
            'total_count' => 'COUNT(' . Invoice::tableName() . '.id)',
            'total_amount' => 'SUM(' . Invoice::tableName() . '.price)',
            'year' => 'pyear(FROM_UNIXTIME(' . Invoice::tableName() . '.updated_at))',
            'month' => 'pmonth(FROM_UNIXTIME(' . Invoice::tableName() . '.updated_at))',
            'month_name' => 'pmonthname(FROM_UNIXTIME(' . Invoice::tableName() . '.updated_at))',
        ]);
        $query
            ->groupBy('pyear(FROM_UNIXTIME(' . Invoice::tableName() . '.updated_at)), pmonth(FROM_UNIXTIME(' . Invoice::tableName() . '.updated_at))')
            ->orderBy(Invoice::tableName() . '.updated_at');
    }
    elseif ($rangeType == ReportWidget::RANGE_TYPE_DAILY) {
        $query->select([
            'total_count' => 'COUNT(' . Invoice::tableName() . '.id)',
            'total_amount' => 'SUM(' . Invoice::tableName() . '.price)',
            'year' => 'pyear(FROM_UNIXTIME(' . Invoice::tableName() . '.updated_at))',
            'day' => 'pday(FROM_UNIXTIME(' . Invoice::tableName() . '.updated_at))',
            'month' => 'pmonth(FROM_UNIXTIME(' . Invoice::tableName() . '.updated_at))',
            'month_name' => 'pmonthname(FROM_UNIXTIME(' . Invoice::tableName() . '.updated_at))',
        ]);
        $query
            ->groupBy('pday(FROM_UNIXTIME(' . Invoice::tableName() . '.updated_at)), pmonth(FROM_UNIXTIME(' . Invoice::tableName() . '.updated_at)), pyear(FROM_UNIXTIME(' . Invoice::tableName() . '.updated_at))')
            ->orderBy('FROM_UNIXTIME(' . Invoice::tableName() . '.updated_at)');
    }

    $dataProvider = new ActiveDataProvider([
        'query' => $query,
    ]);
    $this->load($params);
    return $dataProvider;
}

```

