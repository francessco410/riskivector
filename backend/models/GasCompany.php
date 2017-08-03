<?php

namespace backend\models;

use Yii;

/**
 * This is the model class for table "gas_company".
 *
 * @property integer $id
 * @property string $name
 * @property double $fator_conversao_kwh_e
 * @property double $consumo_gas
 * @property double $termo_fixo
 * @property double $especial_consumo_taxa
 * @property double $acesso_redes
 * @property double $national_taxa
 *
 * @property Tariff[] $tariffs
 */
class GasCompany extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'gas_company';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['id', 'name', 'fator_conversao_kwh_e', 'consumo_gas', 'termo_fixo', 'especial_consumo_taxa', 'acesso_redes', 'national_taxa'], 'required'],
            [['id'], 'integer'],
            [['fator_conversao_kwh_e', 'consumo_gas', 'termo_fixo', 'especial_consumo_taxa', 'acesso_redes', 'national_taxa'], 'number'],
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
            'fator_conversao_kwh_e' => 'Fator Conversao Kwh E',
            'consumo_gas' => 'Consumo Gas',
            'termo_fixo' => 'Termo Fixo',
            'especial_consumo_taxa' => 'Especial Consumo Taxa',
            'acesso_redes' => 'Acesso Redes',
            'national_taxa' => 'National Taxa',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getTariffs()
    {
        return $this->hasMany(Tariff::className(), ['gas_company_id' => 'id']);
    }
}
