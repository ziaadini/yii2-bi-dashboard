## Usage

Usage consists of two parts:
Data source section and View section

- The Data source  section: creating a query that returns data from the database, this part must be implemented in the search
  model

- The View section: Placing creation buttons and widget list in the model, to create widgets

> For example, we use the invoice table that stores the values of our financial invoices

## Usage/Data source section
In the "Data Source" section, it is imperative that you meticulously input your specific dataset into the system. This dataset holds the utmost importance as it serves as the foundation for the subsequent processes. It is noteworthy that your dataset can manifest in two distinct forms: a comprehensive file encapsulating the requisite information or an intricately crafted function designed to extract the desired data from a designated database.

Within the context of this illustration, a well-defined function has been meticulously crafted. This function undertakes the pivotal role of interfacing with the designated database, adeptly retrieving the pertinent dataset. Subsequently, this extracted dataset is seamlessly channeled to the designated widget, where it seamlessly integrates into the overall process flow.

To use this widget, Write a function in your search model that queries your database and returns the result data. Then,
in the widget section, use the names of these functions when placing the widget in your codes. Subsequently, when the
widget is triggered and this function is called, it retrieves the output data and stores it back in the database.

Four parameters, namely array $params, int $rangeType, int $startRange, and int $endRange, must be mandatory and
received by the function according to their specified types.

For example, let's assume we have a table called 'invoice' where financial invoice values of the system are stored.

Below is a sample code snippet that you can add to the search model 'invoice' to fetch data from the database:

```php
public function searchWidget(array $params,int $rangeType,int $startRange,int $endRange)
{
    $query = Invoice::find();
    
    $dataProvider = new ActiveDataProvider([
        'query' => $query,
    ]);
    $this->load($params, '');
    $query->andFilterWhere(['like', 'title', $this->title]);
    $query->andFilterWhere(['between', 'created_at', $startRange, $endRange]);
    
    if ($rangeType == ReportWidget::RANGE_TYPE_MONTHLY) {
        $query->select([
            'total_count' => 'COUNT(' . Invoice::tableName() . '.id)',
            'total_amount' => 'SUM(' . Invoice::tableName() . '.price)',
            'year' => 'pyear(FROM_UNIXTIME(' . Invoice::tableName() . '.created_at))',
            'month' => 'pmonth(FROM_UNIXTIME(' . Invoice::tableName() . '.created_at))',
            'month_name' => 'pmonthname(FROM_UNIXTIME(' . Invoice::tableName() . '.created_at))',
        ]);
        $query
            ->groupBy('pyear(FROM_UNIXTIME(' . Invoice::tableName() . '.created_at)), pmonth(FROM_UNIXTIME(' . Invoice::tableName() . '.created_at))')
            ->orderBy(Invoice::tableName() . '.created_at');
    }
    elseif ($rangeType == ReportWidget::RANGE_TYPE_DAILY) {
        $query->select([
            'total_count' => 'COUNT(' . Invoice::tableName() . '.id)',
            'total_amount' => 'SUM(' . Invoice::tableName() . '.price)',
            'year' => 'pyear(FROM_UNIXTIME(' . Invoice::tableName() . '.created_at))',
            'day' => 'pday(FROM_UNIXTIME(' . Invoice::tableName() . '.created_at))',
            'month' => 'pmonth(FROM_UNIXTIME(' . Invoice::tableName() . '.created_at))',
            'month_name' => 'pmonthname(FROM_UNIXTIME(' . Invoice::tableName() . '.created_at))',
        ]);
        $query
            ->groupBy('pday(FROM_UNIXTIME(' . Invoice::tableName() . '.created_at)), pmonth(FROM_UNIXTIME(' . Invoice::tableName() . '.created_at)), pyear(FROM_UNIXTIME(' . Invoice::tableName() . '.created_at))')
            ->orderBy('FROM_UNIXTIME(' . Invoice::tableName() . '.created_at)');
    }

    return $dataProvider;
}

```

By integrating this function into your search model, you can access the invoice data from the database and utilize it in
your widget accordingly.

In this query, [pdate](https://github.com/zoghal/PersianDate4MySQL) functions are used, which are installed on your
database when you run migration

Also, according to the type of widget (daily and monthly), the query output will be different

## output

Your data output should be an array, and each item in the array must have the fields "year" and "month". If your widget
type is daily, it must also include the "day" field. Additionally, you can add your custom fields and use them to
display data.

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

## Usage/View section
The "View section" becomes active when you perform a search in your model. After conducting the search, two buttons, "Create Widget" and "Display Widget List," will be shown, allowing you to interact with model widgets.

To use this widget, insert the following code into a index file:

```php
        <?= ReportModalWidget::widget([
            'queryParams' => $queryParams,
            'searchModel' => $searchModel,
            'searchModelMethod' => $searchWidget,
            'searchModelRunResultView' => $searchModelRunResultView,
            'searchRoute' => Yii::$app->request->pathInfo,
            'searchModelFormName' => $searchModelFormName,
            'outputColumn' => $outputColumn,
        ]) ?>
```

## Parameters Reference

| Parameter                    | Type                        | Description          | example                           |
|:-----------------------------|:----------------------------|:---------------------|:----------------------------------|
| `queryParams`                | `array`                     | **Required**         | ---                               |
| `searchModel`                | `string`                    | **Required**         | 'app\models\search\InvoiceSearch' |
| `searchModelMethod`          | `string`                    | **Required**         | 'searchWidget'                    |
| `searchModelRunResultView`   | `string`                    | **Required**         | 'view'                            |
| `searchRoute`                | `string`                    | **Required**         | 'invoice/index'                   |
| `searchModelFormName`        | `string`                    | **Required**         | 'InvoiceSearch'                   |
| `outputColumn`               | `array`                     | **Required**         | ---                               |

### queryParams ###

> Search parameters in the model that are received as an array

for example:

```php
$queryParams = array_filter(Yii::$app->request->getQueryParam('InvoiceSearch') ?: []);
```

### searchModel ###

> A string that contains the name of the class model that should be present in that database search method

for example:

```php
$searchModel = new InvoiceSearch();
```

### searchModelMethod ###

> A string that contains the name of the method that the widget should call and return

for example:

```php
$searchWidget = 'searchWidget';
```

### searchModelRunResultView ###

> A string that contains the name of the method that the widget should call and return

for example:

```php
$searchModelRunResultView = 'views/invoice/index.php';
```

### searchRoute ###

> A string containing the address of the page where the widget was created

for example:

```php
$searchRoute = Yii::$app->request->pathInfo;
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
$outputColumn =
[
    "day" => "روز",
    "year"=> "سال",
    "month"=> "ماه",
    "total_count"=> "تعداد",
    "total_amount"=> "جمع‌کل"
];
```


