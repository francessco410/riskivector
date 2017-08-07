<?php

namespace backend\models;

use Yii;

/**
 * This is the model class for table "room".
 *
 * @property integer $id
 * @property integer $number
 * @property double $cost
 * @property integer $type
 * @property integer $flat_id
 *
 * @property Flat $flat
 * @property RoomHasProduct[] $roomHasProducts
 * @property Product[] $products
 * @property RoomPhoto[] $roomPhotos
 * @property TenantHasRoom[] $tenantHasRooms
 * @property Tenant[] $tenants
 */
class Room extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'room';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['number', 'type', 'flat_id'], 'integer'],
            [['cost', 'type', 'flat_id'], 'required'],
            [['cost'], 'number'],
            [['flat_id'], 'exist', 'skipOnError' => true, 'targetClass' => Flat::className(), 'targetAttribute' => ['flat_id' => 'id']],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'Room Number',
            'number' => 'Number',
            'cost' => 'Cost',
            'type' => 'Type',
            'flat_id' => 'Flat Number',
            'fullName' => Yii::t('app', 'Full Name'),
        ];
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
    public function getRoomHasProducts()
    {
        return $this->hasMany(RoomHasProduct::className(), ['room_id' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getProducts()
    {
        return $this->hasMany(Product::className(), ['id' => 'product_id'])->viaTable('room_has_product', ['room_id' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getRoomPhotos()
    {
        return $this->hasMany(RoomPhoto::className(), ['room_id' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getTenantHasRooms()
    {
        return $this->hasMany(TenantHasRoom::className(), ['room_id' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getTenants()
    {
        return $this->hasMany(Tenant::className(), ['id' => 'tenant_id'])->viaTable('tenant_has_room', ['room_id' => 'id']);
    }
    
    public function getNameSurname(){
        $out = '';
        foreach (self::getInformation() as $info){
            $out .= $info['name'].' '.$info['surname'].'<br>';
        }
        
        return $out;
    }
    
    public function getInformation(){
        $tenants = $this->tenantHasRooms;
        $persons_arr = array();
        $output_arr = array();
        foreach ($tenants as $thr){
            $check_out_date = date($thr->check_out_date);
            if($check_out_date > date('Y-m-d') || !isset($thr->departure_date)){
                $tenant=Tenant::find()->where(['id' => $thr->tenant_id])->one();
                $person = Person::find()->where([
                   'id' => $tenant->person_id
               ])->one(); 
                
               $flat = Flat::find()->where(['id' => $this->flat_id])->one();
               $building = Building::find()->where(['id' => $flat->building_id])->one();
               $out_name = $building->name.' '.$flat->number;
                
               $output_arr[] = ['name' => $person->name, 
                                'surname' => $person->surname, 
                                'accommodation_date' => TenantHasRoom::find()->where(['tenant_id'=>$tenant->id,'check_out_date'=>null])->one()->accommodation_date,
                                'departure_date' => $date = isset($tenant->departure_date) ? $tenant->departure_date : ' - ',
                                'number' => $this->number,
                                'type' => $this->type,
                                'flat_name' => $out_name,
                                'photo' => $this->roomPhotos,
                               ];
               
            }
        }
        return $output_arr;
    }
}
