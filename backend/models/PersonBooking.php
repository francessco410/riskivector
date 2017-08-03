<?php

namespace backend\models;

use Yii;

/**
 * This is the model class for table "person_booking".
 *
 * @property integer $id
 * @property string $name
 * @property string $surname
 * @property string $email
 * @property string $sex
 * @property string $country
 * @property integer $smoker
 * @property string $photo
 *
 * @property StudentBooking[] $studentBookings
 */
class PersonBooking extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'person_booking';
    }

    /**
     * @return \yii\db\Connection the database connection used by this AR class.
     */
    public static function getDb()
    {
        return Yii::$app->get('db_front');
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['name', 'surname', 'email', 'sex', 'country', 'smoker', 'photo'], 'required'],
            [['smoker'], 'integer'],
            [['name', 'surname', 'email', 'sex', 'country', 'photo'], 'string', 'max' => 45],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'name' => 'Name',
            'surname' => 'Surname',
            'email' => 'Email',
            'sex' => 'Sex',
            'country' => 'Country',
            'smoker' => 'Smoker',
            'photo' => 'Photo',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getStudentBookings()
    {
        return $this->hasMany(StudentBooking::className(), ['person_booking_id' => 'id']);
    }
}
