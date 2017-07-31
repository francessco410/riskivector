<?php

namespace backend\models;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use backend\models\ProductHasConditionWarehouse;

/**
 * ProductHasConditionWarehouseSearch represents the model behind the search form about `backend\models\ProductHasConditionWarehouse`.
 */
class ProductHasConditionWarehouseSearch extends ProductHasConditionWarehouse
{
    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['product_id', 'condition_id', 'warehouse_id', 'amount'], 'integer'],
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
        $query = ProductHasConditionWarehouse::find();

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
            'product_id' => $this->product_id,
            'condition_id' => $this->condition_id,
            'warehouse_id' => $this->warehouse_id,
            'amount' => $this->amount,
        ]);

        return $dataProvider;
    }
}
