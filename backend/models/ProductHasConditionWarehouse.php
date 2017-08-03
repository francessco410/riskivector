<?php

namespace backend\models;

use Yii;

/**
 * This is the model class for table "product_has_condition_warehouse".
 *
 * @property integer $product_id
 * @property integer $condition_id
 * @property integer $warehouse_id
 * @property integer $amount
 *
 * @property Condition $condition
 * @property Product $product
 * @property Warehouse $warehouse
 */
class ProductHasConditionWarehouse extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'product_has_condition_warehouse';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['condition_id', 'warehouse_id'], 'required'],
            [['product_id', 'condition_id', 'warehouse_id', 'amount'], 'integer'],
            [['condition_id'], 'exist', 'skipOnError' => true, 'targetClass' => Condition::className(), 'targetAttribute' => ['condition_id' => 'id']],
            [['product_id'], 'exist', 'skipOnError' => true, 'targetClass' => Product::className(), 'targetAttribute' => ['product_id' => 'id']],
            [['warehouse_id'], 'exist', 'skipOnError' => true, 'targetClass' => Warehouse::className(), 'targetAttribute' => ['warehouse_id' => 'id']],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'product_id' => 'Product ID',
            'condition_id' => 'Condition',
            'warehouse_id' => 'Warehouse',
            'amount' => 'Amount',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getCondition()
    {
        return $this->hasOne(Condition::className(), ['id' => 'condition_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getProduct()
    {
        return $this->hasOne(Product::className(), ['id' => 'product_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getWarehouse()
    {
        return $this->hasOne(Warehouse::className(), ['id' => 'warehouse_id']);
    }
}
