<?php

namespace backend\models;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use backend\models\Counter;
use backend\models\Address;

/**
 * HouseBillsSearch represents the model behind the search form about `backend\models\Counter`.
 */
class HouseBillsSearch extends Counter
{
    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['id', 'flat_id', 'user_id', 'counter_photo_id'], 'integer'],
            [['date', 'comment'], 'safe'],
            [['water_total', 'vazio_value', 'ponta_value', 'cheia_value', 'gas_total'], 'number'],
        ];
    }

    /**
     * @inheritdoc
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
        $query = Counter::find();

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
            'flat_id' => $this->flat_id,
            'date' => $this->date,
            'water_total' => $this->water_total,
            'vazio_value' => $this->vazio_value,
            'ponta_value' => $this->ponta_value,
            'cheia_value' => $this->cheia_value,
            'gas_total' => $this->gas_total,
            'user_id' => $this->user_id,
            'counter_photo_id' => $this->counter_photo_id,
        ]);

        $query->andFilterWhere(['like', 'comment', $this->comment]);

        return $dataProvider;
    }
}
