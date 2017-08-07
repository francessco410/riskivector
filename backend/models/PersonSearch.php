<?php

namespace backend\models;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use backend\models\Person;

/**
 * PersonSearch represents the model behind the search form about `backend\models\Person`.
 */
class PersonSearch extends Person
{   
    public $fullName;
    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['id'], 'integer'],
            [['name', 'surname', 'email', 'sex', 'country', 'photo', 'phone','fullName'], 'safe'],
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
        $query = Person::find();

        // add conditions that should always apply here
        
        
        $dataProvider = new ActiveDataProvider([
            'query' => $query,
        ]);
        
        $dataProvider->setSort([
        'attributes' => [ 
            'fullName' => [
                'asc' => ['name' => SORT_ASC, 'surname' => SORT_ASC],
                'desc' => ['name' => SORT_DESC, 'surname' => SORT_DESC],
                'label' => 'Full Name',
                'default' => SORT_ASC
            ],
        ]
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
        ]);

        $query->andFilterWhere(['like', 'name', $this->name])
            ->andFilterWhere(['like', 'surname', $this->surname])
            ->andFilterWhere(['like', 'email', $this->email])
            ->andFilterWhere(['like', 'sex', $this->sex])
            ->andFilterWhere(['like', 'country', $this->country])
            ->andFilterWhere(['like', 'photo', $this->photo])
            ->andFilterWhere(['like', 'phone', $this->phone])
            ->andFilterWhere(['=', "concat(name,' ',surname)", $this->name_surname])
            ->andWhere('name LIKE "%' . $this->fullName . '%" ' .
                       'OR surname LIKE "%' . $this->fullName . '%"'
            );

        return $dataProvider;
    }
}
