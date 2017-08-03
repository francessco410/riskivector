<?php

namespace backend\models;

use Yii;

/**
 * This is the model class for table "product".
 *
 * @property integer $id
 * @property string $name
 * @property integer $category_id
 *
 * @property Category $category
 * @property ProductHasConditionWarehouse[] $productHasConditionWarehouses
 * @property RoomHasProduct[] $roomHasProducts
 * @property Room[] $rooms
 * @property TenantHasProduct[] $tenantHasProducts
 * @property Tenant[] $tenants
 */
class Product extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'product';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['name', 'category_id'], 'required'],
            [['category_id'], 'integer'],
            [['name'], 'string', 'max' => 45],
            [['category_id'], 'exist', 'skipOnError' => true, 'targetClass' => Category::className(), 'targetAttribute' => ['category_id' => 'id']],
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
            'category_id' => 'Category Name',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getCategory()
    {
        return $this->hasOne(Category::className(), ['id' => 'category_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getProductHasConditionWarehouses()
    {
        return $this->hasMany(ProductHasConditionWarehouse::className(), ['product_id' => 'id']);
    }
    
    public function getWarehouses()
    {
        return $this->hasMany(Warehouse::className(), ['id' => 'warehouse_id'])
                ->viaTable('product_has_condition_warehouse', ['product_id' => 'id']);
    }
    
    public function getWarehouses_custom()
    {
        return Warehouse::findBySql("SELECT warehouse_id as id FROM product_has_condition_warehouse WHERE product_id={$this->id}")->all();
    }
    
    public function getConditions()
    {
        return $this->hasMany(Condition::className(), ['id' => 'condition_id'])
                ->viaTable('product_has_condition_warehouse', ['product_id' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getRoomHasProducts()
    {
        return $this->hasMany(RoomHasProduct::className(), ['product_id' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getRooms()
    {
        return $this->hasMany(Room::className(), ['id' => 'room_id'])->viaTable('room_has_product', ['product_id' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getTenantHasProducts()
    {
        return $this->hasMany(TenantHasProduct::className(), ['product_id' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getTenants()
    {
        return $this->hasMany(Tenant::className(), ['id' => 'tenant_id'])->viaTable('tenant_has_product', ['product_id' => 'id']);
    }
    
    
}
