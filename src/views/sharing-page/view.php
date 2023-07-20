<?php

use yii\helpers\Html;
use yii\widgets\DetailView;
use yii\helpers\Url;

// Import the Url class

/** @var yii\web\View $this */
/** @var app\models\SharingPage $model */

$this->title = $model->id;
$this->params['breadcrumbs'][] = ['label' => Yii::t('app', 'Sharing Pages'), 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
\yii\web\YiiAsset::register($this);
?>
<div class="report-widget-view">

    <div class="page-content container-fluid text-left pt-5">
        <div class="work-report-index card">
            <div class="panel-group m-bot20" id="accordion">
                <div class="card-header d-flex justify-content-between">
                    <h4 class="panel-title"><?= Html::encode($this->title) ?></h4>

                    <p>
                        <?= Html::a(Yii::t('biDashboard', 'Update'), ['update', 'id' => $model->id], ['class' => 'btn btn-primary']) ?>
                        <?= Html::a(Yii::t('biDashboard', 'Delete'), ['delete', 'id' => $model->id], [
                            'class' => 'btn btn-danger ',
                            'data' => [
                                'confirm' => Yii::t('app', 'Are you sure you want to delete this item?'),
                                'method' => 'post',
                            ],
                        ]) ?>
                        <?php
                        // 'Expire' button added based on the provided example
                        if ($model->expire_time > time()) {
                            echo Html::a('Expire', 'javascript:void(0)', [
                                'title' => Yii::t('yii', 'Expired'),
                                'aria-label' => Yii::t('yii', 'Expired'),
                                'data-reload-pjax-container' => 'p-jax-sharing-page',
                                'data-pjax' => '0',
                                'data-url' => Url::to(['/bidashboard/sharing-page/expire', 'id_key' => $model->id, 'page_id' => $model->page_id]), // Use Url::to() to generate the URL
                                'class' => 'p-jax-btn btn btn-info',
                                'data-title' => Yii::t('yii', 'Expired'),
                            ]);
                        }
                        ?>
                    </p>
                </div>
            </div>
            <div class="card-body">
                <?= DetailView::widget([
                    'model' => $model,
                    'attributes' => [
                        'page_id',
                        'access_key',
                        'expire_time:datetime',
                        'created_by',
                        'updated_by',
                        'created_at:datetime',
                        'updated_at:datetime',
                        'deleted_at:datetime',
                    ],
                ]) ?>
            </div>
        </div>
    </div>
</div>
