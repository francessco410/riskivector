<?php

namespace backend\models;

use Yii;

/**
 * This is the model class for table "tenant_fine".
 *
 * @property integer $id
 * @property string $object
 * @property string $date
 * @property string $comment
 * @property integer $tenant_id
 * @property double $amount
 *
 * @property Tenant $tenant
 */
class TenantFine extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'tenant_fine';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['object', 'date', 'tenant_id', 'amount'], 'required'],
            [['date'], 'safe'],
            [['tenant_id'], 'integer'],
            [['amount'], 'number'],
            [['object', 'comment'], 'string', 'max' => 255],
            [['tenant_id'], 'exist', 'skipOnError' => true, 'targetClass' => Tenant::className(), 'targetAttribute' => ['tenant_id' => 'id']],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'object' => 'Object',
            'date' => 'Date',
            'comment' => 'Comment',
            'tenant_id' => 'Tenant ID',
            'amount' => 'Amount',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getTenant()
    {
        return $this->hasOne(Tenant::className(), ['id' => 'tenant_id']);
    }
}
