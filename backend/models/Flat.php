<?php

namespace backend\models;

use Yii;

/**
 * This is the model class for table "flat".
 *
 * @property integer $id
 * @property string $number
 * @property double $cost
 * @property string $bank_account
 * @property integer $owner_id
 * @property integer $building_id
 *
 * @property Bill[] $bills
 * @property Counter[] $counters
 * @property Building $building
 * @property Room[] $rooms
 * @property Tariff $tariff
 */
class Flat extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'flat';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['number', 'cost', 'bank_account', 'owner_id', 'building_id'], 'required'],
            [['cost'], 'number'],
            [['owner_id', 'building_id'], 'integer'],
            [['number', 'bank_account'], 'string', 'max' => 45],
            [['building_id'], 'exist', 'skipOnError' => true, 'targetClass' => Building::className(), 'targetAttribute' => ['building_id' => 'id']],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'Flat Number',
            'number' => 'Number',
            'cost' => 'Cost',
            'bank_account' => 'Bank Account',
            'owner_id' => 'Owner ID',
            'building_id' => 'Building ID',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getBills()
    {
        return $this->hasMany(Bill::className(), ['flat_id' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getCounters()
    {
        return $this->hasMany(Counter::className(), ['flat_id' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getBuilding()
    {
        return $this->hasOne(Building::className(), ['id' => 'building_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getRooms()
    {
        return $this->hasMany(Room::className(), ['flat_id' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getTariff()
    {
        return $this->hasOne(Tariff::className(), ['flat_id' => 'id']);
    }
}
