<?php

namespace sadi01\bidashboard\models;

use yii\db\ActiveQuery;
use yii2tech\ar\softdelete\SoftDeleteQueryBehavior;

/**
 * This is the ActiveQuery class for [[ReportPage]].
 *
 * @see ReportPage
 *
 * @mixin SoftDeleteQueryBehavior
 */
class ReportPageQuery extends ActiveQuery
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
     * @return ReportPage[]|array
     */
    public function all($db = null)
    {
        return parent::all($db);
    }

    /**
     * {@inheritdoc}
     * @return ReportPage|array|null
     */
    public function one($db = null)
    {
        return parent::one($db);
    }
}