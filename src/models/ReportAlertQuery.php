<?php

namespace ziaadini\bidashboard\models;

use yii\db\ActiveQuery;
use yii2tech\ar\softdelete\SoftDeleteQueryBehavior;

class ReportAlertQuery extends ActiveQuery
{

    public function widgetAlerts(int $widgetId, string $widget_field)
    {
        return $this->where(['widget_id' => $widgetId])
            ->andWhere(['widget_field' => $widget_field]);
    }

    /**
     * {@inheritdoc}
     * @return ReportDashboard[]|array
     */
    public function all($db = null)
    {
        return parent::all($db);
    }

    /**
     * {@inheritdoc}
     * @return ReportDashboard|array|null
     */
    public function one($db = null)
    {
        return parent::one($db);
    }

    public function bySlaveId()
    {
        if (\Yii::$app->params['bi_slave_id'] ?? null) {
            return $this->onCondition([ReportAlert::tableName() . '.slave_id' => \Yii::$app->params['bi_slave_id']]);
        } else {
            return $this;
        }
    }

    public function behaviors()
    {
        return [
            'softDelete' => [
                'class' => SoftDeleteQueryBehavior::class,
            ],
        ];
    }
}
