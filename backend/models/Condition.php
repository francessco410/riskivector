<?php

namespace backend\models;

use Yii;

/**
 * This is the model class for table "condition".
 *
 * @property integer $id
 * @property string $type
 *
 * @property ProductHasConditionWarehouse[] $productHasConditionWarehouses
 */
class Condition extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'condition';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['type'], 'required'],
            [['type'], 'string', 'max' => 45],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'type' => 'Type',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getProductHasConditionWarehouses()
    {
        return $this->hasMany(ProductHasConditionWarehouse::className(), ['condition_id' => 'id']);
    }
}
