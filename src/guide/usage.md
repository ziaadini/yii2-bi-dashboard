
## Usage

Usage consists of two parts:
Query section and widget section

- The Query section: creating a query that returns data from the database, this part must be implemented in the search model

- The widget section: Placing creation buttons and widget list in the model, to create widgets

> For example, we use the invoice table that stores the values of our financial invoices


## Usage/Query section

To use this widget, Write a function in your search model that queries your database and returns the result data. Then, pass the information from this function to the widget when creating it. Subsequently, when the widget is triggered and this function is called, it retrieves the output data and stores it back in the database.

Four parameters, namely string $params, int $rangeType, int $startRange, and int $endRange, must be mandatory and received by the function according to their specified types.

For example, let's assume we have a table called 'invoice' where financial invoice values of the system are stored.

Below is a sample code snippet that you can add to the search model 'invoice' to fetch data from the database:

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
By integrating this function into your search model, you can access the invoice data from the database and utilize it in your widget accordingly.

In this query, [pdate](https://github.com/zoghal/PersianDate4MySQL) functions are used, which are installed on your database when you run migration

Also, according to the type of widget (daily and monthly), the query output will be different


example output query:
```php
 array:4 [
  0 => array:5 [
    "total_count" => 1
    "total_amount" => "2000"
    "year" => "1402"
    "month" => "1"
    "month_name" => "فروردین"
  ]
  1 => array:5 [
    "total_count" => 1
    "total_amount" => "1000"
    "year" => "1402"
    "month" => "2"
    "month_name" => "اردیبهشت"
  ]
  2 => array:5 [
    "total_count" => 9
    "total_amount" => "12000"
    "year" => "1402"
    "month" => "3"
    "month_name" => "خرداد"
  ]
  3 => array:5 [
    "total_count" => 1
    "total_amount" => "5000"
    "year" => "1402"
    "month" => "6"
    "month_name" => "شهریور"
  ]
]
```







## Usage/widget section
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
    "total_amount"=> "جمع‌کل",
]
```


