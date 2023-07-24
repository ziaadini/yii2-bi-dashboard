<?php

namespace sadi01\bidashboard\models;

use yii\base\Model;
use yii\data\ActiveDataProvider;


/**
 * SharingPageSearch represents the model behind the search form of `app\models\SharingPage`.
 */
class SharingPageSearch extends SharingPage
{
    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['id', 'page_id', 'expire_time', 'created_by', 'updated_by', 'created_at', 'updated_at', 'deleted_at'], 'integer'],
            [['access_key','expire_time'], 'safe'],
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
        $query = SharingPage::find();


        // add conditions that should always apply here

        $dataProvider = new ActiveDataProvider([
            'query' => $query,
        ]);

        $this->load($params);

        if (!$this->validate()) {

             $query->where('0=1');
            return $dataProvider;
        }




        // grid filtering conditions
        $query->andFilterWhere([
            'id' => $this->id,
            'page_id' => $this->page_id,
            'expire_time' => $this->expire_time,
            'created_by' => $this->created_by,
            'updated_by' => $this->updated_by,
            'created_at' => $this->created_at,
            'updated_at' => $this->updated_at,
            'deleted_at' => $this->deleted_at,
        ]);
        return $dataProvider;
    }
}
