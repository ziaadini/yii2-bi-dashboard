<?php

namespace sadi01\bidashboard\models;

use yii\db\ActiveQuery;
use sadi01\bidashboard\models\ReportWidget;
use yii2tech\ar\softdelete\SoftDeleteBehavior;
use yii2tech\ar\softdelete\SoftDeleteQueryBehavior;

/**
 * This is the ActiveQuery class for [[\sadi01\bidashboard\models\ReportWidget]].
 *
 * @see ReportWidget
 */
class ReportWidgetQuery extends ActiveQuery
{
    /*public function active()
    {
        return $this->andWhere('[[status]]=1');
    }*/

    public function behaviors()
    {
        return [
            'softDelete' => [
                'class' => SoftDeleteQueryBehavior::class,
            ],
            'softDeleteBehavior' => [
                'class' => SoftDeleteBehavior::class,
                'softDeleteAttributeValues' => [
                    'isDeleted' => true
                ],
            ],
        ];
    }

    /**
     * {@inheritdoc}
     * @return ReportWidget[]|array
     */
    public function all($db = null)
    {
        return parent::all($db);
    }

    /**
     * {@inheritdoc}
     * @return ReportWidget|array|null
     */
    public function one($db = null)
    {
        return parent::one($db);
    }
}
