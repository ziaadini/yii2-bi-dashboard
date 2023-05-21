<?php

namespace sadi01\bidashboard\models;


use yii\db\ActiveQuery;
/**
 * This is the ActiveQuery class for [[ReportPage]].
 *
 * @see ReportPage
 */
class ReportPageQuery extends ActiveQuery
{

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

    public function active()
    {
        return $this->andWhere('[[status]]=1');
    }
}
