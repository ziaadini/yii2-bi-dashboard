<?php

namespace sadi01\bidashboard\models;

use yii2tech\ar\softdelete\SoftDeleteQueryBehavior;
use yii\db\ActiveQuery;

/**
 * This is the ActiveQuery class for [[ExternalData]].
 *
 * @see ExternalData
 * @mixin SoftDeleteQueryBehavior
 */
class ExternalDataQuery extends ActiveQuery
{
    /**
     * {@inheritdoc}
     * @return ExternalData[]|array
     */
    public function all($db = null)
    {
        return parent::all($db);
    }

    /**
     * {@inheritdoc}
     * @return ExternalData|array|null
     */
    public function one($db = null)
    {
        return parent::one($db);
    }

    public function behaviors()
    {
        return [
            'softDelete' => [
                'class' => SoftDeleteQueryBehavior::class,
            ],
        ];
    }

    public function byClentId()
    {
        return $this->onCondition([ExternalData::tableName() . '.bi_client_id' => \Yii::$app->params['bi_client_id']]);
    }
}