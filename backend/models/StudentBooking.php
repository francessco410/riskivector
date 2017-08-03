<?php

namespace backend\models;

use Yii;

/**
 * This is the model class for table "student_booking".
 *
 * @property integer $id
 * @property string $course
 * @property string $home_university
 * @property string $arrival_date
 * @property integer $months
 * @property integer $room_type
 * @property integer $kit
 * @property string $date
 * @property integer $validated
 * @property string $coment
 * @property integer $person_booking_id
 *
 * @property PersonBooking $personBooking
 */
class StudentBooking extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'student_booking';
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
            [['course', 'home_university', 'arrival_date', 'months', 'room_type', 'kit', 'date', 'person_booking_id'], 'required'],
            [['arrival_date', 'date'], 'safe'],
            [['months', 'room_type', 'kit', 'validated', 'person_booking_id'], 'integer'],
            [['course', 'home_university', 'coment'], 'string', 'max' => 45],
            [['person_booking_id'], 'exist', 'skipOnError' => true, 'targetClass' => PersonBooking::className(), 'targetAttribute' => ['person_booking_id' => 'id']],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'course' => 'Course',
            'home_university' => 'Home University',
            'arrival_date' => 'Arrival Date',
            'months' => 'Months',
            'room_type' => 'Room Type',
            'kit' => 'Kit',
            'date' => 'Date',
            'validated' => 'Validated',
            'coment' => 'Coment',
            'person_booking_id' => 'Person Booking ID',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getPersonBooking()
    {
        return $this->hasOne(PersonBooking::className(), ['id' => 'person_booking_id']);
    }
}
