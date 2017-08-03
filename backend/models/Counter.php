<?php

namespace backend\models;

use Yii;
use common\models\User;

/**
 * This is the model class for table "counter".
 *
 * @property integer $id
 * @property integer $flat_id
 * @property string $date
 * @property double $water_total
 * @property double $vazio_value
 * @property double $ponta_value
 * @property double $cheia_value
 * @property double $gas_total
 * @property string $comment
 * @property integer $user_id
 * @property integer $counter_photo_id
 *
 * @property Bill[] $bills
 * @property Flat $flat
 * @property User $user
 * @property CounterPhoto $counterPhoto
 */
class Counter extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'counter';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['flat_id', 'cheia_value', 'gas_total', 'user_id', 'counter_photo_id'], 'required'],
            [['flat_id', 'user_id', 'counter_photo_id'], 'integer'],
            [['date'], 'safe'],
            [['water_total', 'vazio_value', 'ponta_value', 'cheia_value', 'gas_total'], 'number'],
            [['comment'], 'string', 'max' => 255],
            [['flat_id'], 'exist', 'skipOnError' => true, 'targetClass' => Flat::className(), 'targetAttribute' => ['flat_id' => 'id']],
            [['user_id'], 'exist', 'skipOnError' => true, 'targetClass' => User::className(), 'targetAttribute' => ['user_id' => 'id']],
            [['counter_photo_id'], 'exist', 'skipOnError' => true, 'targetClass' => CounterPhoto::className(), 'targetAttribute' => ['counter_photo_id' => 'id']],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'flat_id' => 'Flat ID',
            'date' => 'Date',
            'water_total' => 'Water Total',
            'vazio_value' => 'Vazio Value',
            'ponta_value' => 'Ponta Value',
            'cheia_value' => 'Cheia Value',
            'gas_total' => 'Gas Total',
            'comment' => 'Comment',
            'user_id' => 'User ID',
            'counter_photo_id' => 'Counter Photo ID',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getBills()
    {
        return $this->hasMany(Bill::className(), ['counter_id' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getFlat()
    {
        return $this->hasOne(Flat::className(), ['id' => 'flat_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getUser()
    {
        return $this->hasOne(User::className(), ['id' => 'user_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getCounterPhoto()
    {
        return $this->hasOne(CounterPhoto::className(), ['id' => 'counter_photo_id']);
    }
}
