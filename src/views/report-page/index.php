<?php

use sadi01\bidashboard\models\ReportPage;
use sadi01\bidashboard\models\ReportPageSearch;
use yii\data\ActiveDataProvider;
use yii\bootstrap4\Modal;
use yii\grid\ActionColumn;
use yii\grid\GridView;
use yii\helpers\Html;
use yii\helpers\Url;
use yii\web\View;
use yii\widgets\Pjax;

/** @var View $this */
/** @var ReportPageSearch $searchModel */
/** @var ActiveDataProvider $dataProvider */

$this->title = Yii::t('app', 'Report Pages');
$this->params['breadcrumbs'][] = $this->title;

?>

<div class="page-content container-fluid text-left pt-5" id="main-wrapper">
    <?php Pjax::begin(['id' => 'p-jax-report-page', 'enablePushState' => false]); ?>
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
                    <?= Html::a(Yii::t('biDashboard', 'create'), "javascript:void(0)",
                        [
                            'data-pjax' => '0',
                            'class' => "btn btn-primary",
                            'data-size' => 'modal-xl',
                            'data-title' => Yii::t('app', 'create'),
                            'data-toggle' => 'modal',
                            'data-target' => '#modal-pjax',
                            'data-url' => Url::to(['report-page/create']),
                            'data-handle-form-submit' => 1,
                            'data-reload-pjax-container' => 'p-jax-report-page'
                        ]) ?>
                </div>
            </div>
            <div class="card-body page-content container-fluid text-left">
                <div id="collapseSearch" class="panel-collapse collapse" aria-expanded="false">
                  <?= $this->render('_search', ['model' => $searchModel]); ?>
                </div>
                <?= GridView::widget([
                    'dataProvider' => $dataProvider,
                    'columns' => [
                        ['class' => 'yii\grid\SerialColumn'],
                        'title',
                        [
                            'attribute' => 'status',
                            'value' => function ($model) {

                                return ReportPage::itemAlias('Status',$model->status);
                            },
                        ],
                        [
                            'attribute' => 'range_type',
                            'value' => function ($model) {
                                return ReportPage::itemAlias('range_type',$model->range_type);
                            },
                        ],
                        [
                            'class' => ActionColumn::class,
                            'urlCreator' => function ($action, ReportPage $model, $key, $index, $column) {
                                return Url::toRoute([$action, 'id' => $model->id]);
                            }
                        ],
                    ],
                ]); ?>
            </div>
        </div>
    </div>
<?php Pjax::end(); ?>
</div>