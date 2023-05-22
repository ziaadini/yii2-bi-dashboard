<?php

use sadi01\bidashboard\models\ReportPage;
use yii\bootstrap4\Modal;
use yii\grid\ActionColumn;

use yii\grid\GridView;
use yii\helpers\Html;
use yii\helpers\Url;
use yii\widgets\Pjax;


$this->title = Yii::t('app', 'Report Pages');
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="report-page-index">

    <h1><?= Html::encode($this->title) ?></h1>

    <p>
        <?= Html::button(Yii::t('app', 'Create Report Page'), ['class' => 'btn btn-success', 'id' => 'create-report-page-btn']) ?>
    </p>

    <?php Pjax::begin(); ?>
    <?= $this->render('_search', ['model' => $searchModel]); ?>

    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],
            'title',
            'status',
            'range_type',
            'add_on',
            [
                'class' => ActionColumn::className(),
                'urlCreator' => function ($action, ReportPage $model, $key, $index, $column) {
                    return Url::toRoute([$action, 'id' => $model->id]);
                }
            ],
        ],
    ]); ?>

    <?php Pjax::end(); ?>

</div>

<?php
Modal::begin([
    'id' => 'create-report-page-modal',
]);

Pjax::begin(['id' => 'create-report-page-pjax']);
echo "jjdjdd";
Pjax::end();

Modal::end();

$this->registerJs('
    $(document).on("click", "#create-report-page-btn", function(e) {
        e.preventDefault();
        $("#create-report-page-modal").modal("show");
    });

    $(document).on("submit", "#create-report-page-pjax form", function(e) {
        e.preventDefault();
        $.pjax.submit(event, "#create-report-page-pjax");
    });
');
?>
