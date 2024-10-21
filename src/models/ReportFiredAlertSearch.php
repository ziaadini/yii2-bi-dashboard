<?php

namespace ziaadini\bidashboard\models;

use yii\base\Model;
use yii\data\ActiveDataProvider;
use ziaadini\bidashboard\models\ReportFiredAlert;

class ReportFiredAlertSearch extends ReportFiredAlert
{
    public function rules()
    {
        return [
            [['id', 'alert_id', 'box_id', 'status', 'seen_status', 'seen_time', 'created_at', 'updated_at', 'deleted_at', 'updated_by', 'created_by'], 'integer'],
        ];
    }

    public function scenarios()
    {
        // bypass scenarios() implementation in the parent class
        return Model::scenarios();
    }

    public function search($params)
    {
        $query = ReportFiredAlert::find()->orderBy([
            'seen_status' => SORT_ASC,
            'seen_time' => SORT_DESC,
            'id' => SORT_DESC
        ]);

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
            'box_id' => $this->box_id,
            'alert_id' => $this->alert_id
        ]);

        return $dataProvider;
    }
}
