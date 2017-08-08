<?php

namespace backend\models;

use Yii;

/**
 * This is the model class for table "building".
 *
 * @property integer $id
 * @property string $name
 * @property integer $number
 * @property integer $address_id
 *
 * @property Address $addressId
 * @property Flat[] $flats
 */
class Building extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'building';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['name', 'number', 'address_id'], 'required'],
            [['number', 'address_id', 'id'], 'integer'],
            [['name'], 'string', 'max' => 45],
            [['address_id'], 'exist', 'skipOnError' => true, 'targetClass' => Address::className(), 'targetAttribute' => ['address_id' => 'id']],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'Building Name',
            'name' => 'Name',
            'number' => 'Number',
            'address_id' => 'Address Id',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getAddressId()
    {
        return $this->hasOne(Address::className(), ['id' => 'address_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getFlats()
    {
        return $this->hasMany(Flat::className(), ['building_id' => 'id']);
    }
}
