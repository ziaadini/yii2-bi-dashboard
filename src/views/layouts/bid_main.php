<?php

use Yii;
use yii\bootstrap5\Html;

/** @var \yii\web\View $this */

list(, $url) = Yii::$app->assetManager->publish('@sadi01/bidashboard/assets');

$this->registerCssFile($url . '/bidashboard/dist/css/style.min.css');

$this->registerJsFile($url . '/bidashboard/libs/jquery/dist/jquery.min.js');
$this->registerJsFile($url . '/bidashboard/libs/bootstrap/dist/js/bootstrap.min.js');
$this->registerJsFile($url . '/bidashboard/dist/js/app.min.js');
$this->registerJsFile($url . '/bidashboard/dist/js/app.init.mini-sidebar.js');
$this->registerJsFile($url . '/bidashboard/libs/perfect-scrollbar/dist/perfect-scrollbar.jquery.min.js');
$this->registerJsFile($url . '/bidashboard/dist/js/sidebarmenu.js');
$this->registerJsFile($url . '/bidashboard/dist/js/custom.min.js');
$this->registerJsFile($url . '/bidashboard/dist/js/custom.min.js',['position' => $this::POS_READY]);

$this->registerJsFile($url . '/bidashboard/libs/fullcalendar/dist/fullcalendar.min.js');

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
        <?php $this->beginContent('@sadi01/bidashboard/views/layouts/topbar.php', ['url' => $url]); ?>
        <?php $this->endContent(); ?>

        <!-- Menu Sidebar-->
        <?php $this->beginContent('@sadi01/bidashboard/views/layouts/sidbar.php', ['url' => $url]); ?>
        <?php $this->endContent(); ?>


        <div class="page-wrapper">
            <?php $this->beginBody() ?>
            <?= $content ?>
            <?php $this->endBody() ?>
            <footer class="footer text-center">
                هوش تجاری
                <a href="https://mobit.ir">مبیت</a>
            </footer>
        </div>
    </div>

    </html>
<?php $this->endPage();

