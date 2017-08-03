<?php

namespace backend\models;

use Yii;

/**
 * This is the model class for table "counter_photo".
 *
 * @property integer $id
 * @property string $name
 * @property string $path
 *
 * @property Counter[] $counters
 */
class CounterPhoto extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'counter_photo';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['name', 'path'], 'string', 'max' => 45],
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
            'path' => 'Path',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getCounters()
    {
        return $this->hasMany(Counter::className(), ['counter_photo_id' => 'id']);
    }
}
