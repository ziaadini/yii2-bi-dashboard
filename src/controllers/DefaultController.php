<?php

namespace sadi01\bidashboard\controllers;

class DefaultController extends \yii\web\Controller
{
    public function actionIndex()
    {
        $this->layout = 'bid_main';
        return $this->render('index');
    }

}
