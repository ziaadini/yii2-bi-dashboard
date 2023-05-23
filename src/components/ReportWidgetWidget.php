<?php

namespace sadi01\bidashboard\components;

use Yii;
use app\models\UserModel;
use sadi01\bidashboard\models\ReportWidget;
use yii\base\Widget;
use yii\helpers\Html;

class ReportWidgetWidget extends Widget
{

    public $queryParams;
    public $searchModel;
    public $searchRoute;
    public $searchModelFormName;

    public function init()
    {
        parent::init();
    }

    public function run()
    {
        $model = new ReportWidget();

        return $this->render('ReportWidgetWidget',[
            'model' => $model,
            'queryParams' => $this->queryParams,
            'searchModel' => $this->searchModel,
            'searchRoute' => $this->searchRoute,
            'searchModelFormName' => $this->searchModelFormName,
        ]);
    }

}