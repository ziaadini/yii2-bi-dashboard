<?php

use sadi01\bidashboard\models\ReportModelClass;
use yii\helpers\Html;
use yii\helpers\Url;
use yii\grid\ActionColumn;
use yii\grid\GridView;
use yii\widgets\Pjax;
/** @var yii\web\View $this */
/** @var sadi01\bidashboard\models\search\SearchReportModelClass $searchModel */
/** @var yii\data\ActiveDataProvider $dataProvider */

$this->title = Yii::t('biDashboard', 'Report Model Classes');
$this->params['breadcrumbs'][] = $this->title;
?>

<div class="page-content container-fluid text-left pt-5">
    <div class="work-report-index card">
        <div class="panel-group m-bot20" id="accordion">
            <div class="card-header d-flex justify-content-between">
                <h4 class="panel-title">
                    <a class="accordion-toggle collapsed" data-toggle="collapse" data-parent="#accordion"
                       href="#collapseSearch" aria-expanded="false">
                        <i class="mdi mdi-search-web"></i> جستجو
                    </a>
                </h4>
                <div>
                    <?= Html::a(Yii::t('biDashboard', 'Create Report Model Class'), ['create'], ['class' => 'btn btn-success']) ?>
                </div>
            </div>
            <div class="card-body">
                <?php Pjax::begin(); ?>
                <div id="collapseSearch" class="panel-collapse collapse" aria-expanded="false">
                    <?php echo $this->render('_search', ['model' => $searchModel]); ?>
                </div>

                <?= GridView::widget([
                    'dataProvider' => $dataProvider,
                    'filterModel' => $searchModel,
                    'columns' => [
                        ['class' => 'yii\grid\SerialColumn'],

                        'id',
                        'title',
                        'search_model_class',
                        'search_model_method',
                        'search_model_run_result_view',
                        'status',
                        [
                            'class' => ActionColumn::className(),
                            'urlCreator' => function ($action, ReportModelClass $model, $key, $index, $column) {
                                return Url::toRoute([$action, 'id' => $model->id]);
                            }
                        ],
                    ],
                ]); ?>
                <?php Pjax::end(); ?>
            </div>
        </div>
    </div>