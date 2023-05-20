<?php

namespace sadi01\bidashboard\controllers;

use yii\web\Controller;

class IndexController extends Controller
{
    public function actionIndex(){
        $this->layout = 'bid_main';
        return $this->render('index');
    }
}