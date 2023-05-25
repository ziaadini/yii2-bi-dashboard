<?php

namespace sadi01\bidashboard\models;
use yii2tech\ar\softdelete\SoftDeleteQueryBehavior;
use yii\db\ActiveQuery;
/**
 * This is the ActiveQuery class for [[ReportPage]].
 *
 * @see ReportPage
 */
class ReportPageQuery extends ActiveQuery
{
    public function behaviors()
    {
        return [
            'softDelete' => [
                'class' => SoftDeleteQueryBehavior::className(),
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
