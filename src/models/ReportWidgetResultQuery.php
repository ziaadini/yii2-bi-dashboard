<?php

namespace ziaadini\bidashboard\models;

use yii2tech\ar\softdelete\SoftDeleteQueryBehavior;

/**
 * This is the ActiveQuery class for [[ReportWidgetResult]].
 *
 * @see ReportWidgetResult
 */
class ReportWidgetResultQuery extends \yii\db\ActiveQuery
{
    public function behaviors()
    {
        return [
            'softDelete' => [
                'class' => SoftDeleteQueryBehavior::class,
            ],
        ];
    }

    /**
     * {@inheritdoc}
     * @return ReportWidgetResult[]|array
     */
    public function all($db = null)
    {
        return parent::all($db);
    }

    /**
     * {@inheritdoc}
     * @return ReportWidgetResult|array|null
     */
    public function one($db = null)
    {
        return parent::one($db);
    }

    public function bySlaveId()
    {
        if (\Yii::$app->params['bi_slave_id'] ?? null) {
            return $this->onCondition([ReportWidgetResult::tableName() . '.slave_id' => \Yii::$app->params['bi_slave_id']]);
        } else {
            return $this;
        }
    }
}
