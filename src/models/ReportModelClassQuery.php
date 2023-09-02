<?php

namespace sadi01\bidashboard\models;

use yii2tech\ar\softdelete\SoftDeleteQueryBehavior;

/**
 * This is the ActiveQuery class for [[ReportModelClass]].
 *
 * @see ReportModelClass
 * @mixin SoftDeleteQueryBehavior
 */
class ReportModelClassQuery extends \yii\db\ActiveQuery
{

    /**
     * {@inheritdoc}
     * @return ReportModelClass[]|array
     */
    public function all($db = null)
    {
        return parent::all($db);
    }

    /**
     * {@inheritdoc}
     * @return ReportModelClass|array|null
     */
    public function one($db = null)
    {
        return parent::one($db);
    }

    public function behaviors(): array
    {
        return [
            'SoftDeleteQueryBehavior' => [
                'class' => SoftDeleteQueryBehavior::class,
            ],
        ];
    }

    public function bySlaveId()
    {
        if (\Yii::$app->params['bi_slave_id'] ?? null) {
            return $this->onCondition([ReportModelClass::tableName() . '.slave_id' => \Yii::$app->params['bi_slave_id']]);
        } else {
            return $this;
        }
    }
}
