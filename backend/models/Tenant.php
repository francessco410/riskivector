<?php

namespace backend\models;

use Yii;

/**
 * This is the model class for table "tenant".
 *
 * @property integer $id
 * @property integer $smoker
 * @property integer $person_id
 * @property string $departure_date
 * @property double $arrears
 * @property double $debt
 * @property double $credits
 *
 * @property Person $person
 * @property TenantFine[] $tenantFines
 * @property TenantHasProduct[] $tenantHasProducts
 * @property Product[] $products
 * @property TenantHasRoom[] $tenantHasRooms
 * @property Room[] $rooms
 */
class Tenant extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'tenant';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['smoker', 'person_id', 'departure_date'], 'required'],
            [['smoker', 'person_id'], 'integer'],
            [['departure_date'], 'safe'],
            [['arrears', 'debt', 'credits'], 'number'],
            [['person_id'], 'exist', 'skipOnError' => true, 'targetClass' => Person::className(), 'targetAttribute' => ['person_id' => 'id']],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'smoker' => 'Smoker',
            'person_id' => 'Person ID',
            'departure_date' => 'Departure Date',
            'arrears' => 'Arrears',
            'debt' => 'Debt',
            'credits' => 'Credits',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getPerson()
    {
        return $this->hasOne(Person::className(), ['id' => 'person_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getTenantFines()
    {
        return $this->hasMany(TenantFine::className(), ['tenant_id' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getTenantHasProducts()
    {
        return $this->hasMany(TenantHasProduct::className(), ['tenant_id' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getProducts()
    {
        return $this->hasMany(Product::className(), ['id' => 'product_id'])->viaTable('tenant_has_product', ['tenant_id' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getTenantHasRooms()
    {
        return $this->hasMany(TenantHasRoom::className(), ['tenant_id' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getRooms()
    {
        return $this->hasMany(Room::className(), ['id' => 'room_id'])->viaTable('tenant_has_room', ['tenant_id' => 'id']);
    }
}
