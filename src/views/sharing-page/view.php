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
?>
<div class="report-widget-view">

    <div class="page-content container-fluid text-left pt-5">
        <div class="work-report-index card">
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