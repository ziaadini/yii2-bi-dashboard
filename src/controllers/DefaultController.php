<?php

namespace sadi01\bidashboard\controllers;
use yii\web\Controller;

class DefaultController extends Controller
{
    public $layout = 'bid_main';

    public function actionIndex()
    {
        return $this->render('index');
    }
}