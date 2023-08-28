<?php

namespace sadi01\bidashboard\controllers;

use yii\filters\AccessControl;
use yii\filters\VerbFilter;
use yii\web\Controller;

class DefaultController extends Controller
{
    public $layout = 'bid_main';

    public function behaviors()
    {
        return array_merge(
            parent::behaviors(),
            [
//                'access' => [
//                    'class' => AccessControl::class,
//                    'rules' =>
//                        [
//                            [
//                                'allow' => true,
//                                'roles' => ['BI/Default/index'],
//                                'actions' => [
//                                    'index'
//                                ]
//                            ],
//                        ]
//                ],
                'verbs' => [
                    'class' => VerbFilter::class,
                    'actions' => [
                        'index' => ['GET'],
                    ],
                ],
            ]
        );
    }

    public function actionIndex()
    {
        return $this->render('index');
    }
}