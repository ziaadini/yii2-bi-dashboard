<?php

use yii\helpers\Html;


$this->title = 'Bi Dashboard';
$url = Yii::$app->assetManager->getPublishedUrl('@sadi01/bidashboard/assets');

$this->params['breadcrumbs'][] = $this->title;

?>

<div class="report-widget-view">

    <div class="page-content container-fluid text-left">
        <div class="work-report-index card">
            <div class="panel-group m-bot20" id="accordion">
                <div class="card-header d-flex justify-content-between">
                    <h4 class="panel-title pt-2">
                        <?= Html::encode($this->title) ?>
                    </h4>
                </div>
                <div class="card-body">
                    <div class="row">
                        <div class="col-md-12">
                            <div class="card">
                                <div class="card-body text-center">
                                    <img src="<?=$url?>/bidashboard/images/BI.png" class="img-fluid w-50">
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
