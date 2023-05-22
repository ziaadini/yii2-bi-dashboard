<?php

namespace sadi01\bidashboard\models\query;

/**
 * This is the ActiveQuery class for [[\sadi01\bidashboard\models\ReportModelClass]].
 *
 * @see \sadi01\bidashboard\models\ReportModelClass
 */
class ReportModelClassQuery extends \yii\db\ActiveQuery
{
    /*public function active()
    {
        return $this->andWhere('[[status]]=1');
    }*/

    /**
     * {@inheritdoc}
     * @return \sadi01\bidashboard\models\ReportModelClass[]|array
     */
    public function all($db = null)
    {
        return parent::all($db);
    }

    /**
     * {@inheritdoc}
     * @return \sadi01\bidashboard\models\ReportModelClass|array|null
     */
    public function one($db = null)
    {
        return parent::one($db);
    }
}
