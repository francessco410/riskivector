<?php

namespace backend\models;

use Yii;

/**
 * This is the model class for table "water_company".
 *
 * @property integer $id
 * @property string $name
 * @property double $um_escalao_cost
 * @property double $dois_escalao_cost
 * @property double $tres_escalao_cost
 * @property double $tarifa_fixa_urbana
 * @property double $tarifa_fixa_saneamento
 * @property double $um_residuos_solidos
 * @property double $tarifa_variavel_saneamento
 * @property double $tarifa_fixa_rsu
 *
 * @property Tariff[] $tariffs
 */
class WaterCompany extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'water_company';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['name', 'um_escalao_cost', 'dois_escalao_cost', 'tres_escalao_cost', 'tarifa_fixa_urbana', 'tarifa_fixa_saneamento', 'um_residuos_solidos', 'tarifa_variavel_saneamento', 'tarifa_fixa_rsu'], 'required'],
            [['um_escalao_cost', 'dois_escalao_cost', 'tres_escalao_cost', 'tarifa_fixa_urbana', 'tarifa_fixa_saneamento', 'um_residuos_solidos', 'tarifa_variavel_saneamento', 'tarifa_fixa_rsu'], 'number'],
            [['name'], 'string', 'max' => 255],
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
            'um_escalao_cost' => 'Um Escalao Cost',
            'dois_escalao_cost' => 'Dois Escalao Cost',
            'tres_escalao_cost' => 'Tres Escalao Cost',
            'tarifa_fixa_urbana' => 'Tarifa Fixa Urbana',
            'tarifa_fixa_saneamento' => 'Tarifa Fixa Saneamento',
            'um_residuos_solidos' => 'Um Residuos Solidos',
            'tarifa_variavel_saneamento' => 'Tarifa Variavel Saneamento',
            'tarifa_fixa_rsu' => 'Tarifa Fixa Rsu',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getTariffs()
    {
        return $this->hasMany(Tariff::className(), ['water_company_id' => 'id']);
    }
}
