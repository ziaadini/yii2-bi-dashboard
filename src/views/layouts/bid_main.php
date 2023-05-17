<?php

use Yii;
use yii\bootstrap5\Html;
use sadi01\bidashboard\BiAssets;

$biAssets = BiAssets::register($this);
$url = $biAssets->baseUrl;

?>
<?php $this->beginPage() ?>
    <!DOCTYPE html>
    <html dir="rtl" lang="en">

    <head>
        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta charset="<?= Yii::$app->charset ?>">
        <?php $this->registerCsrfMetaTags() ?>
        <title><?= Html::encode($this->title) ?></title>
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <?php $this->head() ?>
    </head>

    <body>

    <div class="preloader">
        <div class="lds-ripple">
            <div class="lds-pos"></div>
            <div class="lds-pos"></div>
        </div>
    </div>

    <div id="main-wrapper">

        <!-- Topbar header -->
        <?= $this->render('@sadi01/bidashboard/views/layouts/topbar.php', ['url' => $url]) ?>
        <!-- Menu Sidebar-->
        <?= $this->render('@sadi01/bidashboard/views/layouts/sidebar.php', ['url' => $url]) ?>

        <div class="page-wrapper">
            <?php $this->beginBody() ?>
            <?= $content ?>
            <?php $this->endBody() ?>
            <footer class="footer text-center">
                هوش تجاری
                <a href="https://mobit.ir">مبیت</a>
            </footer>
        </div>

    </html>
<?php $this->endPage();

