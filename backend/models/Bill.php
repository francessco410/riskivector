<?php

namespace backend\models;

use Yii;

/**
 * This is the model class for table "bill".
 *
 * @property integer $ID
 * @property integer $rent_cost
 * @property double $water
 * @property double $electricity
 * @property double $gas
 * @property double $other_expences
 * @property double $dues
 * @property integer $counter_id
 *
 * @property Counter $counter
 */
class Bill extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'bill';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['rent_cost', 'water', 'electricity', 'counter_id'], 'required'],
            [['rent_cost', 'counter_id'], 'integer'],
            [['water', 'electricity', 'gas', 'other_expences', 'dues'], 'number'],
            [['counter_id'], 'exist', 'skipOnError' => true, 'targetClass' => Counter::className(), 'targetAttribute' => ['counter_id' => 'id']],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'ID' => 'ID',
            'rent_cost' => 'Rent Cost',
            'water' => 'Water',
            'electricity' => 'Electricity',
            'gas' => 'Gas',
            'other_expences' => 'Other Expences',
            'dues' => 'Dues',
            'counter_id' => 'Counter ID',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getCounter()
    {
        return $this->hasOne(Counter::className(), ['id' => 'counter_id']);
    }
}
