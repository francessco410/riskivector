<?php

namespace backend\models;

use Yii;

/**
 * This is the model class for table "gas_bottle_company".
 *
 * @property integer $id
 * @property double $price
 *
 * @property Tariff[] $tariffs
 */
class GasBottleCompany extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'gas_bottle_company';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['price'], 'required'],
            [['price'], 'number'],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'price' => 'Price',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getTariffs()
    {
        return $this->hasMany(Tariff::className(), ['gas_bottle_company_id' => 'id']);
    }
}
