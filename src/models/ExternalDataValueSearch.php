<?php

namespace sadi01\bidashboard\models;

use yii\base\Model;
use yii\data\ActiveDataProvider;

/**
 * ExternalDataValueSearch represents the model behind the search form of `sadi01\bidashboard\models\ExternalDataValue`.
 */
class ExternalDataValueSearch extends ExternalDataValue
{
    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['id', 'external_data_id', 'status', 'created_at', 'created_by', 'updated_at', 'updated_by', 'deleted_at'], 'integer'],
            [['value'], 'number'],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function scenarios()
    {
        // bypass scenarios() implementation in the parent class
        return Model::scenarios();
    }

    /**
     * Creates data provider instance with search query applied
     *
     * @param array $params
     *
     * @return ActiveDataProvider
     */
    public function search($params)
    {
        $query = ExternalDataValue::find();

        $dataProvider = new ActiveDataProvider([
            'query' => $query,
        ]);

        $this->load($params);

        if (!$this->validate()) {
            $query->where('0=1');
            return $dataProvider;
        }

        $query->andFilterWhere(['like', 'value', $this->value]);
        $query->andFilterWhere(['=', 'external_data_id', $this->external_data_id]);

        return $dataProvider;
    }

    public function searchWidget(array $params, int $rangeType, int $startRange, int $endRange)
    {
        $query = ExternalDataValue::find();

        $dataProvider = new ActiveDataProvider([
            'query' => $query,
        ]);

        $this->load($params, '');

        if (!$this->validate()) {
            $query->where('0=1');
            return $dataProvider;
        }

        // grid filtering conditions
        $query->andFilterWhere([
            ExternalDataValue::tableName() . '.id' => $this->id,
            ExternalDataValue::tableName() . '.external_data_id' => $this->external_data_id,
            ExternalDataValue::tableName() . '.value' => $this->value,
            ExternalDataValue::tableName() . '.status' => $this->status,
            ExternalDataValue::tableName() . '.updated_at' => $this->updated_at,
            ExternalDataValue::tableName() . '.updated_by' => $this->updated_by,
            ExternalDataValue::tableName() . '.created_by' => $this->created_by,
            ExternalDataValue::tableName() . '.deleted_at' => $this->deleted_at,
        ]);

        $query->andFilterWhere(['between', ExternalDataValue::tableName() . '.created_at', $startRange, $endRange]);

        if ($rangeType == ReportWidget::RANGE_TYPE_MONTHLY) {
            $query->select([
                'total_count' => 'COUNT(' . ExternalDataValue::tableName() . '.id)',
                'total_amount' => 'SUM(' . ExternalDataValue::tableName() . '.value)',
                'year' => 'pyear(FROM_UNIXTIME(' . ExternalDataValue::tableName() . '.created_at))',
                'month' => 'pmonth(FROM_UNIXTIME(' . ExternalDataValue::tableName() . '.created_at))',
                'month_name' => 'pmonthname(FROM_UNIXTIME(' . ExternalDataValue::tableName() . '.created_at))',
            ]);
            $query
                ->groupBy('pyear(FROM_UNIXTIME(' . ExternalDataValue::tableName() . '.created_at)), pmonth(FROM_UNIXTIME(' . ExternalDataValue::tableName() . '.created_at))')
                ->orderBy(ExternalDataValue::tableName() . '.created_at');
        }

        if ($rangeType == ReportWidget::RANGE_TYPE_DAILY) {
            $query->select([
                'total_count' => 'COUNT(' . ExternalDataValue::tableName() . '.id)',
                'total_amount' => 'SUM(' . ExternalDataValue::tableName() . '.value)',
                'year' => 'pyear(FROM_UNIXTIME(' . ExternalDataValue::tableName() . '.created_at))',
                'day' => 'pday(FROM_UNIXTIME(' . ExternalDataValue::tableName() . '.created_at))',
                'month' => 'pmonth(FROM_UNIXTIME(' . ExternalDataValue::tableName() . '.created_at))',
                'month_name' => 'pmonthname(FROM_UNIXTIME(' . ExternalDataValue::tableName() . '.created_at))',
            ]);
            $query
                ->groupBy('pday(FROM_UNIXTIME(' . ExternalDataValue::tableName() . '.created_at)), pmonth(FROM_UNIXTIME(' . ExternalDataValue::tableName() . '.created_at)), pyear(FROM_UNIXTIME(' . ExternalDataValue::tableName() . '.created_at))')
                ->orderBy('FROM_UNIXTIME(' . ExternalDataValue::tableName() . '.created_at)');
        }

        return $dataProvider;
    }
}