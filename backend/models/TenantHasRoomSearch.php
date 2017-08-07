<?php

namespace backend\models;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use backend\models\TenantHasRoom;

/**
 * TenantHasRoomSearch represents the model behind the search form about `backend\models\TenantHasRoom`.
 */
class TenantHasRoomSearch extends TenantHasRoom
{
    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['tenant_id', 'room_id'], 'integer'],
            [['accommodation_date', 'check_out_date'], 'safe'],
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
        $query = TenantHasRoom::find();

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
            'tenant_id' => $this->tenant_id,
            'room_id' => $this->room_id,
            'accommodation_date' => $this->accommodation_date,
            'check_out_date' => $this->check_out_date,
        ]);

        return $dataProvider;
    }
}
