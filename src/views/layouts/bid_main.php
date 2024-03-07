<?php
/* @var $this \yii\web\View */

/* @var $content string */


use sadi01\bidashboard\BiAssets;
use sadi01\bidashboard\widgets\Alert;
use yii\bootstrap4\Modal;
use yii\helpers\Html;
use yii\helpers\Url;
use yii\widgets\Breadcrumbs;

BiAssets::register($this);

?>
<?php $this->beginPage() ?>
<!DOCTYPE html>
<html dir="rtl" lang="<?= Yii::$app->language ?>">
<head>
    <meta charset="<?= Yii::$app->charset ?>">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=no">
    <meta name="theme-color" content="#2874f0">
    <meta http-equiv="content-language" content="fa"/>
    <meta name="city" content="Kerman">
    <meta name="state" content="Kerman">
    <meta name="country" content="Iran">
    <?= Html::csrfMetaTags() ?>
    <link rel="shortcut icon" href="<?= Yii::getAlias('@web') . '/img/favicon-back.png'; ?>"/>
    <title><?= Html::encode($this->title) ?></title>
    <?php $this->head() ?>
</head>
<body>
<?php $this->beginBody(); ?>
<div class="preloader">
    <div class="lds-ripple">
        <div class="lds-pos"></div>
        <div class="lds-pos"></div>
    </div>
</div>

<div id="main-wrapper">
    <?= $this->render('_header') ?>
    <?= $this->render('_sidebar') ?>
    <div class="page-wrapper">
        <?php if (isset($this->params['breadcrumbs'])): ?>
            <div class="page-breadcrumb bg-white">
                <div class="row flex-column flex-md-row">
                    <div class="col-12 align-self-start align-self-md-center">
                        <nav class="mt-2">
                            <?= Breadcrumbs::widget([
                                'options' => ['class' => 'breadcrumb mb-0 justify-content-start  p-0 bg-white'],
                                'homeLink' => [
                                    'label' => '<span class="fal fa-home"></span>',
                                    'url' => Url::to(['site/index']),
                                    'encode' => false// Requested feature
                                ],
                                'links' => isset($this->params['breadcrumbs']) ? $this->params['breadcrumbs'] : [],
                                'itemTemplate' => "<li class=\"breadcrumb-item\">{link}</li>\n",
                                'activeItemTemplate' => "<li class=\"breadcrumb-item active text-overflow-ellipsis\">{link}</li>\n",
                            ]) ?>
                        </nav>
                    </div>
                    <div class="col-12 col-lg-6 mt-2 mt-lg-0">
                        <div class="row">
                            <div class="col-md-6">
                                <?= $this->render('_shortcut_business', ['base_url' => Url::to(['/business/index?id'])]) ?>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        <?php endif; ?>

        <div class="page-content container-fluid text-left">
            <div>
                <?= Alert::widget() ?>
            </div>
            <?= $content ?>
            <div class="modal fade top-modal-with-space" id="quickAccessModal" tabindex="-1" role="dialog"
                 aria-labelledby="myModalLabel" aria-hidden="true">
                <div class="modal-dialog modal-md">
                    <div class="modal-content-wrap">
                        <div class="modal-content">
                            <div class="modal-header">
                                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
                                <h4 class="modal-title">
                                    <span class="modal-title fas fa-rabbit-fast fa-2x text-danger"></span>
                                </h4>
                            </div>
                            <div class="modal-body">
                                <input type="text" class="form-control input-lg m-bot15"
                                       placeholder="کسب و کار، کاربر"
                                       id="shortCode" data-base-url="<?= Yii::$app->urlManager->baseUrl ?>">

                                <div id="accordionHelp" class="card material-card mt-3 mb-0 panel-group">
                                    <a class="card-header card-title accordion-toggle collapsed text-left" data-toggle="collapse"
                                       href="#collapseHelp"
                                       data-parent="#accordionHelp" aria-expanded="false"><i
                                                class="fal fa-question-circle"></i> راهنما</a>
                                    <div id="collapseHelp" class="card-body panel-collapse collapse"
                                         aria-expanded="false">
                                        <div class="feed-widget d-flex justify-content-between">
                                            <ul class="feed-body list-style-none w-100">
                                                <li class="feed-item d-flex align-items-center justify-content-between py-2">
                                                    <div>
                                                        <button class="btn btn-info btn-circle">
                                                            <i class="far fa-list text-white"></i>
                                                        </button>
                                                        <span class="ml-3 font-light">لیست کسب و کارها</span>
                                                    </div>
                                                    <div class="ml-5">
                                                        <span class="text-muted font-light">b + Enter </span>
                                                    </div>
                                                </li>
                                                <li class="feed-item d-flex align-items-center justify-content-between py-2">
                                                    <div>
                                                        <button class="btn btn-info btn-circle">
                                                            <i class="far fa-shopping-bag text-white"></i>
                                                        </button>
                                                        <span class="ml-3 font-light">جزئیات کسب و کار</span>
                                                    </div>
                                                    <div class="ml-5">
                                                        <span class="text-muted font-light">b + id + Enter ==> o12345 </span>
                                                    </div>
                                                </li>
                                                <hr>
                                            </ul>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <?php
    Modal::begin([
        'headerOptions' => ['id' => 'modalPjaxOverHeader-bi'],
        'id' => 'modal-pjax-over-bi',
        'bodyOptions' => [
            'id' => 'modalPjaxOverContent-bi',
            'class' => 'p-3 text-left',
            'data' => ['show-preloader' => 0]
        ],
        'options' => ['tabindex' => false, 'style' => 'z-index:1051;']
    ]); ?>
    <div class="text-center">
        <div class="spinner-border text-info" role="status" style="width: 3rem; height: 3rem;">
            <span class="sr-only">Loading...</span>
        </div>
    </div>
    <?php Modal::end(); ?>

    <?php
    Modal::begin([
        'headerOptions' => ['id' => 'modalPjaxHeader-bi'],
        'id' => 'modal-pjax-bi',
        'bodyOptions' => [
            'id' => 'modalPjaxContent-bi',
            'class' => 'p-3',
            'data' => ['show-preloader' => 0]
        ],
        'options' => ['tabindex' => false]
    ]); ?>
    <div class="text-center">
        <div class="spinner-border text-info" role="status" style="width: 3rem; height: 3rem;">
            <span class="sr-only">Loading...</span>
        </div>
    </div>
    <?php Modal::end(); ?>

    <?= $this->render('_footer') ?>
</div>
<?php $this->endBody() ?>
</body>
</html>
<?php $this->endPage() ?>