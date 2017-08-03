<?php

namespace backend\models;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use backend\models\Bill;

/**
 * BillSearch represents the model behind the search form about `backend\models\Bill`.
 */
class BillSearch extends Bill
{
    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['ID', 'rent_cost', 'counter_id'], 'integer'],
            [['water', 'electricity', 'gas', 'other_expences', 'dues'], 'number'],
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
        $query = Bill::find();

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
            'ID' => $this->ID,
            'rent_cost' => $this->rent_cost,
            'water' => $this->water,
            'electricity' => $this->electricity,
            'gas' => $this->gas,
            'other_expences' => $this->other_expences,
            'dues' => $this->dues,
            'counter_id' => $this->counter_id,
        ]);

        return $dataProvider;
    }
}
