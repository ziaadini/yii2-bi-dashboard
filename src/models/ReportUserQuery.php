<?php

namespace ziaadini\bidashboard\models;

use yii\db\ActiveQuery;
use yii2tech\ar\softdelete\SoftDeleteQueryBehavior;

class ReportUserQuery extends ActiveQuery
{

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
            return $this->onCondition([ReportUser::tableName() . '.slave_id' => \Yii::$app->params['bi_slave_id']]);
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
