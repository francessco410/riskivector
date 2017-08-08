<?php

namespace backend\models;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use backend\models\Room;

/**
 * RoomSearch represents the model behind the search form about `backend\models\Room`.
 */
class RoomSearch extends Room
{
    public $tenant_list;
    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['id', 'number', 'type'], 'integer'],
            [['cost'], 'number'],
            [['flat_id','tenant_list'],'safe']
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
        $query = Room::find();
        
        // add conditions that should always apply here
        $query->joinWith('flat');
        $query->joinWith('flat.building');
        $query->joinWith('tenantHasRooms.tenant.person');
        
        $dataProvider = new ActiveDataProvider([
            'query' => $query,
        ]);
         $dataProvider->sort->attributes['tenant_list'] = [
            'asc' => ['person.name' => SORT_ASC],
            'desc' => ['person.name' => SORT_DESC],
             
        ];
         
        $this->load($params);

        if (!$this->validate()) {
            // uncomment the following line if you do not want to return any records when validation fails
            // $query->where('0=1');
            return $dataProvider;
        }
        

        // grid filtering conditions
        $query->andFilterWhere([
            'id' => $this->id,
            'number' => $this->number,
            'cost' => $this->cost,
            'type' => $this->type,
        ]);
         $query->orFilterWhere(['like', 'building.name', $this->flat_id])
               ->orFilterWhere(['like', 'flat.number', $this->flat_id])
               ->orFilterWhere(['like', 'person.name', $this->tenant_list])
               ->orFilterWhere(['like', 'person.surname', $this->tenant_list]);

        return $dataProvider;
    }
}
