<?php

namespace backend\models;

use Yii;

/**
 * This is the model class for table "tenant_has_room".
 *
 * @property integer $tenant_id
 * @property integer $room_id
 * @property string $accommodation_date
 * @property string $check_out_date
 *
 * @property Room $room
 * @property Tenant $tenant
 */
class TenantHasRoom extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'tenant_has_room';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['tenant_id', 'room_id', 'accommodation_date'], 'required'],
            [['tenant_id', 'room_id'], 'integer'],
            [['accommodation_date', 'check_out_date'], 'safe'],
            [['room_id'], 'exist', 'skipOnError' => true, 'targetClass' => Room::className(), 'targetAttribute' => ['room_id' => 'id']],
            [['tenant_id'], 'exist', 'skipOnError' => true, 'targetClass' => Tenant::className(), 'targetAttribute' => ['tenant_id' => 'id']],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'tenant_id' => 'Tenant ID',
            'room_id' => 'Room ID',
            'accommodation_date' => 'Accommodation Date',
            'check_out_date' => 'Check Out Date',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getRoom()
    {
        return $this->hasOne(Room::className(), ['id' => 'room_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getTenant()
    {
        return $this->hasOne(Tenant::className(), ['id' => 'tenant_id']);
    }
}
