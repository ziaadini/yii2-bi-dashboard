<?php

namespace sadi01\bidashboard\models;

/**
 * This is the ActiveQuery class for [[ReportPageWidget]].
 *
 * @see ReportPageWidget
 */
class ReportPageWidgetQuery extends \yii\db\ActiveQuery
{
    /*public function active()
    {
        return $this->andWhere('[[status]]=1');
    }*/

    /**
     * {@inheritdoc}
     * @return ReportPageWidget[]|array
     */
    public function all($db = null)
    {
        return parent::all($db);
    }

    /**
     * {@inheritdoc}
     * @return ReportPageWidget|array|null
     */
    public function one($db = null)
    {
        return parent::one($db);
    }
}
