<?php

namespace backend\models;

use Yii;

/**
 * This is the model class for table "warehouse".
 *
 * @property integer $id
 * @property string $address
 *
 * @property ProductHasConditionWarehouse[] $productHasConditionWarehouses
 */
class Warehouse extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'warehouse';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['address'], 'required'],
            [['address'], 'string', 'max' => 45],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'address' => 'Address',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getProductHasConditionWarehouses()
    {
        return $this->hasMany(ProductHasConditionWarehouse::className(), ['warehouse_id' => 'id']);
    }
}
