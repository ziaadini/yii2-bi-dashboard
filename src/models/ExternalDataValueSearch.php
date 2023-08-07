<?php

namespace sadi01\bidashboard\models;

use yii\base\Model;
use yii\data\ActiveDataProvider;
use sadi01\bidashboard\models\ExternalDataValue;

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

        // add conditions that should always apply here

        $dataProvider = new ActiveDataProvider([
            'query' => $query,
        ]);

        $this->load($params);

        if (!$this->validate()) {
            // uncomment the following line if you do not want to return any records when validation fails
            // $query->where('0=1');
            return $dataProvider;
        }

        // grid filtering conditions
        $query->andFilterWhere([
            'id' => $this->id,
            'external_data_id' => $this->external_data_id,
            'value' => $this->value,
            'status' => $this->status,
            'created_at' => $this->created_at,
            'created_by' => $this->created_by,
            'updated_at' => $this->updated_at,
            'updated_by' => $this->updated_by,
            'deleted_at' => $this->deleted_at,
        ]);

        return $dataProvider;
    }
}
