<?php

namespace backend\models;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use backend\models\StudentBooking;

/**
 * StudentBookingSearch represents the model behind the search form about `backend\models\StudentBooking`.
 */
class StudentBookingSearch extends StudentBooking
{
    public $country;
    public $name;
    
    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['id', 'months', 'room_type', 'kit', 'validated'], 'integer'],
            [['course', 'home_university', 'arrival_date', 'date', 'coment', 'personBooking.country', 'personBooking.name', 'person_booking_id'], 'safe'],
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
        $query = StudentBooking::find();

        // add conditions that should always apply here
        $query->joinWith('personBooking');
        
        $dataProvider = new ActiveDataProvider([
            'query' => $query,
        ]);
        
        $dataProvider->sort->attributes['country'] = [
            'asc' => ['person_booking.country' => SORT_ASC],
            'desc' => ['person_booking.country' => SORT_DESC],
        ];
        
        $dataProvider->sort->attributes['person_booking_id'] = [
            'asc' => ['person_booking.name' => SORT_ASC],
            'desc' => ['person_booking.name' => SORT_DESC],
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
            'arrival_date' => $this->arrival_date,
            'months' => $this->months,
            'room_type' => $this->room_type,
            'kit' => $this->kit,
            'date' => $this->date,
            'validated' => $this->validated,
            'person_booking_id' => $this->person_booking_id,
        ]);

        $query->andFilterWhere(['like', 'course', $this->course])
            ->andFilterWhere(['like', 'home_university', $this->home_university])
            ->andFilterWhere(['like', 'coment', $this->coment])
            ->andFilterWhere(['like', 'person_booking.country', $this->country])
            ->orFilterWhere(['like', 'person_booking.name', $this->person_booking_id])
            ->orFilterWhere(['like', 'person_booking.surname', $this->person_booking_id]);
        

        return $dataProvider;
    }
}
