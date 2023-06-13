<?php

namespace sadi01\bidashboard\models;

use yii2tech\ar\softdelete\SoftDeleteQueryBehavior;

/**
 * This is the ActiveQuery class for [[ReportPageWidget]].
 *
 * @see ReportPageWidget
 */
class ReportPageWidgetQuery extends \yii\db\ActiveQuery
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
