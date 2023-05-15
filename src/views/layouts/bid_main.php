<?php
use Yii;
use yii\bootstrap5\Html;
?>
<?php $this->beginPage() ?>
    <!DOCTYPE html>
    <html lang="<?= Yii::$app->language ?>" class="h-100">
    <head>
        <meta charset="<?= Yii::$app->charset ?>">
        <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
        <?php $this->registerCsrfMetaTags() ?>
        <title><?= Html::encode($this->title) ?></title>
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

