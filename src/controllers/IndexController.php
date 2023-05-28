<?php

namespace sadi01\bidashboard\controllers;

use yii\web\Controller;
use sadi01\bidashboard\components\Pdate;

class IndexController extends Controller
{
    public function actionIndex(){
        
//        $p= new Pdate();
//        var_dump($p->jdate('y','123456'));
//        die();
        $this->layout = 'bid_main';
        return $this->render('index');
    }
}