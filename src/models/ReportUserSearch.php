<?php

namespace ziaadini\bidashboard\models;

use yii\data\Sort;
use ziaadini\bidashboard\models\ReportUser;
use yii\base\Model;
use yii\data\ActiveDataProvider;

class ReportUserSearch extends ReportUser
{
    public function rules()
    {
        return [
            [['id', 'status', 'created_at', 'updated_at', 'deleted_at', 'updated_by', 'created_by'], 'integer'],
            [['first_name', 'last_name', 'phone_number', 'email'], 'safe'],
        ];
    }

    public function scenarios()
    {
        // bypass scenarios() implementation in the parent class
        return Model::scenarios();
    }

    public function search($params)
    {
        $query = ReportUser::find();

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
            'status' => $this->status,
            'created_at' => $this->created_at,
            'updated_at' => $this->updated_at,
            'deleted_at' => $this->deleted_at,
            'updated_by' => $this->updated_by,
            'created_by' => $this->created_by,
        ]);

        $query->andFilterWhere(['like', 'first_name', $this->first_name])
            ->andFilterWhere(['like', 'last_name', $this->last_name])
            ->andFilterWhere(['like', 'phone_numer', $this->phone_number])
            ->andFilterWhere(['like', 'email', $this->email]);

        return $dataProvider;
    }
}
