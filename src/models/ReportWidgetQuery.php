<?php

namespace ziaadini\bidashboard\models;

use yii\db\ActiveQuery;
use yii2tech\ar\softdelete\SoftDeleteBehavior;
use yii2tech\ar\softdelete\SoftDeleteQueryBehavior;

/**
 * This is the ActiveQuery class for [[\ziaadini\bidashboard\models\ReportWidget]].
 *
 * @see ReportWidget
 *
 * @mixin SoftDeleteQueryBehavior
 */
class ReportWidgetQuery extends ActiveQuery
{
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

    /**
     * @return \string[][]
     */
    public function behaviors(): array
    {
        return [
            'SoftDeleteQueryBehavior' => [
                'class' => SoftDeleteQueryBehavior::class,
            ],
        ];
    }

    public function bySlaveId()
    {
        if (\Yii::$app->params['bi_slave_id'] ?? null) {
            return $this->onCondition([ReportWidget::tableName() . '.slave_id' => \Yii::$app->params['bi_slave_id']]);
        } else {
            return $this;
        }
    }
}
