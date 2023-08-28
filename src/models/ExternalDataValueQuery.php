<?php

namespace sadi01\bidashboard\models;

use yii2tech\ar\softdelete\SoftDeleteQueryBehavior;
use yii\db\ActiveQuery;

/**
 * This is the ActiveQuery class for [[ExternalDataValue]].
 *
 * @see ExternalDataValue
 * @mixin SoftDeleteQueryBehavior
 */
class ExternalDataValueQuery extends ActiveQuery
{
    /**
     * {@inheritdoc}
     * @return ExternalDataValue[]|array
     */
    public function all($db = null)
    {
        return parent::all($db);
    }

    /**
     * {@inheritdoc}
     * @return ExternalDataValue|array|null
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
        return $this->onCondition([ExternalDataValue::tableName() . '.bi_slave_id' => \Yii::$app->params['bi_slave_id']]);
    }
}
