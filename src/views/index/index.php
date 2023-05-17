<?php

use yii\helpers\Url;
use yii\web\View;

$this->title = 'Bi dashboard';
$url = Yii::$app->assetManager->getPublishedUrl('@sadi01/bidashboard/assets');

?>


<div class="page-breadcrumb bg-light">
    <div class="row">
        <div class="col-lg-3 col-md-4 col-xs-12 align-self-center text-left">
            <h5 class="font-medium text-uppercase mb-0">داشبورد</h5>
        </div>
        <div class="col-lg-9 col-md-8 col-xs-12 align-self-center">
            <nav aria-label="breadcrumb" class="mt-2 float-md-right float-left" style="direction: rtl;">
                <ol class="breadcrumb mb-0 justify-content-end p-0 bg-light">
                    <li class="breadcrumb-item">
                        <a href="<?php Url::to(['/bidashboard/index']) ?>">هوش تجاری</a>
                    </li>
                    <li class="breadcrumb-item active" aria-current="page">
                        داشبورد
                    </li>
                </ol>
            </nav>
        </div>
    </div>
</div>

<div class="page-content container-fluid">

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
