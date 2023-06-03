<?php

namespace sadi01\bidashboard\models;

/**
 * This is the ActiveQuery class for [[ReportWidgetResult]].
 *
 * @see ReportWidgetResult
 */
class ReportWidgetResultQuery extends \yii\db\ActiveQuery
{
    /*public function active()
    {
        return $this->andWhere('[[status]]=1');
    }*/

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
}
