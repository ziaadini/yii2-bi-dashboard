<?php

namespace sadi01\bidashboard\models;

use yii2tech\ar\softdelete\SoftDeleteQueryBehavior;

/**
 * This is the ActiveQuery class for [[SharingPage]].
 *
 * @see SharingPage
 */
class SharingPageQuery extends \yii\db\ActiveQuery
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
     * @return SharingPage[]|array
     */
    public function all($db = null)
    {
        return parent::all($db);
    }

    /**
     * {@inheritdoc}
     * @return SharingPage|array|null
     */
    public function one($db = null)
    {
        return parent::one($db);
    }

    public function bySlaveId()
    {
        return $this->onCondition([SharingPage::tableName() . '.slave_id' => \Yii::$app->params['bi_slave_id']]);
    }
}
