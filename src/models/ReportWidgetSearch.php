<?php

namespace sadi01\bidashboard\models;

use yii\base\Model;
use yii\data\ActiveDataProvider;
use sadi01\bidashboard\models\ReportWidget;

/**
 * ReportWidgetSearch represents the model behind the search form of `sadi01\bidashboard\models\ReportWidget`.
 */
class ReportWidgetSearch extends ReportWidget
{
    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['id', 'status', 'deleted_at', 'range_type', 'visibility', 'updated_at', 'created_at', 'updated_by', 'created_by'], 'integer'],
            [['title', 'description', 'search_model_method', 'search_model_run_result_view', 'add_on', 'search_model_class'], 'safe'],
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
        $query = ReportWidget::find();

        // add conditions that should always apply here

        $dataProvider = new ActiveDataProvider([
            'query' => $query,
        ]);

        $this->load($params);

        if (!$this->validate()) {
            // uncomment the following line if you do not want to return any records when validation fails
            $query->where('0=1');
            return $dataProvider;
        }

        // grid filtering conditions
        $query->andFilterWhere([
            'id' => $this->id,
            'search_model_class' => $this->search_model_class,
            'search_model_method'=>$this->search_model_method,
            'status' => $this->status,
            'deleted_at' => $this->deleted_at,
            'range_type' => $this->range_type,
            'visibility' => $this->visibility,
            'updated_at' => $this->updated_at,
            'created_at' => $this->created_at,
            'updated_by' => $this->updated_by,
            'created_by' => $this->created_by,
        ]);

        $query->andFilterWhere(['like', 'title', $this->title])
            ->andFilterWhere(['like', 'description', $this->description])
            ->andFilterWhere(['like', 'search_model_class', $this->search_model_class])
            ->andFilterWhere(['like', 'search_model_method', $this->search_model_method])
            ->andFilterWhere(['like', 'search_model_run_result_view', $this->search_model_run_result_view])
            ->andFilterWhere(['like', 'add_on', $this->add_on]);

        return $dataProvider;
    }
}