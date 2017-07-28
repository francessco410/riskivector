<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "building".
 *
 * @property integer $id
 * @property string $name
 * @property integer $number
 * @property integer $address_id1
 *
 * @property Address $addressId1
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
            [['name', 'number', 'address_id1'], 'required'],
            [['number', 'address_id1'], 'integer'],
            [['name'], 'string', 'max' => 45],
            [['address_id1'], 'exist', 'skipOnError' => true, 'targetClass' => Address::className(), 'targetAttribute' => ['address_id1' => 'id']],
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
            'number' => 'Number',
            'address_id1' => 'Address Id1',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getAddressId1()
    {
        return $this->hasOne(Address::className(), ['id' => 'address_id1']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getFlats()
    {
        return $this->hasMany(Flat::className(), ['building_id' => 'id']);
    }
}
