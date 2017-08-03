<?php

namespace backend\models;

use Yii;

/**
 * This is the model class for table "tariff".
 *
 * @property integer $flat_id
 * @property integer $gas_company_id
 * @property integer $electricity_company_id
 * @property integer $water_company_id
 * @property integer $gas_bottle_company_id
 *
 * @property ElectricityCompany $electricityCompany
 * @property Flat $flat
 * @property GasBottleCompany $gasBottleCompany
 * @property GasCompany $gasCompany
 * @property WaterCompany $waterCompany
 */
class Tariff extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'tariff';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['flat_id', 'gas_company_id', 'electricity_company_id', 'water_company_id', 'gas_bottle_company_id'], 'required'],
            [['flat_id', 'gas_company_id', 'electricity_company_id', 'water_company_id', 'gas_bottle_company_id'], 'integer'],
            [['flat_id'], 'unique'],
            [['electricity_company_id'], 'exist', 'skipOnError' => true, 'targetClass' => ElectricityCompany::className(), 'targetAttribute' => ['electricity_company_id' => 'id']],
            [['flat_id'], 'exist', 'skipOnError' => true, 'targetClass' => Flat::className(), 'targetAttribute' => ['flat_id' => 'id']],
            [['gas_bottle_company_id'], 'exist', 'skipOnError' => true, 'targetClass' => GasBottleCompany::className(), 'targetAttribute' => ['gas_bottle_company_id' => 'id']],
            [['gas_company_id'], 'exist', 'skipOnError' => true, 'targetClass' => GasCompany::className(), 'targetAttribute' => ['gas_company_id' => 'id']],
            [['water_company_id'], 'exist', 'skipOnError' => true, 'targetClass' => WaterCompany::className(), 'targetAttribute' => ['water_company_id' => 'id']],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'flat_id' => 'Flat ID',
            'gas_company_id' => 'Gas Company ID',
            'electricity_company_id' => 'Electricity Company ID',
            'water_company_id' => 'Water Company ID',
            'gas_bottle_company_id' => 'Gas Bottle Company ID',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getElectricityCompany()
    {
        return $this->hasOne(ElectricityCompany::className(), ['id' => 'electricity_company_id']);
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
    public function getGasBottleCompany()
    {
        return $this->hasOne(GasBottleCompany::className(), ['id' => 'gas_bottle_company_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getGasCompany()
    {
        return $this->hasOne(GasCompany::className(), ['id' => 'gas_company_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getWaterCompany()
    {
        return $this->hasOne(WaterCompany::className(), ['id' => 'water_company_id']);
    }
}
