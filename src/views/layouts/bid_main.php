<?php
use Yii;
use yii\bootstrap5\Html;

/** @var \yii\web\View $this */
/** @var string $content */

//list(,$url) = Yii::$app->assetManager->publish('@sadi01/bidashboard/assets');
//$this->registerCssFile($url.'/theme/vendors/bundle.css');

?>
<?php $this->beginPage() ?>
    <!DOCTYPE html>
    <html lang="<?= Yii::$app->language ?>" class="h-100">
    <head>
        <meta charset="<?= Yii::$app->charset ?>">
        <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
        <?php $this->registerCsrfMetaTags() ?>
        <title><?= Html::encode($this->title) ?></title>
        <?php $this->head() ?>
        <meta http-equiv="Cache-Control" content="no-cache, no-store, must-revalidate" />
        <meta http-equiv="Pragma" content="no-cache" />
        <meta http-equiv="Expires" content="0" />
    </head>
    <body class="d-flex flex-column h-100">
    <?php $this->beginBody() ?>
            <?= $content ?>
    <?php $this->endBody() ?>
    </body>
    <?php if (isset($this->blocks['javascript'])): ?>
        <?= $this->blocks['javascript'] ?>
    <?php else: ?>
        <script></script>
    <?php endif; ?>
    </html>
<?php $this->endPage();

