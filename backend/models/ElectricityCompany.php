<?php

namespace backend\models;

use Yii;

/**
 * This is the model class for table "electricity_company".
 *
 * @property integer $id
 * @property string $name
 * @property double $vazio_cost
 * @property double $ponta_cost
 * @property double $cheia_cost
 * @property double $potencia_contratada_cost
 * @property double $national_taxa
 * @property double $especial_consumo_taxa
 * @property double $exloracao_taxa
 * @property double $contibuicao_audiovisual_cost
 * @property double $contibuicao_audiovisual_taxa
 *
 * @property Tariff[] $tariffs
 */
class ElectricityCompany extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'electricity_company';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['name', 'vazio_cost', 'ponta_cost', 'cheia_cost', 'potencia_contratada_cost', 'national_taxa', 'especial_consumo_taxa', 'exloracao_taxa', 'contibuicao_audiovisual_cost', 'contibuicao_audiovisual_taxa'], 'required'],
            [['vazio_cost', 'ponta_cost', 'cheia_cost', 'potencia_contratada_cost', 'national_taxa', 'especial_consumo_taxa', 'exloracao_taxa', 'contibuicao_audiovisual_cost', 'contibuicao_audiovisual_taxa'], 'number'],
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
            'vazio_cost' => 'Vazio Cost',
            'ponta_cost' => 'Ponta Cost',
            'cheia_cost' => 'Cheia Cost',
            'potencia_contratada_cost' => 'Potencia Contratada Cost',
            'national_taxa' => 'National Taxa',
            'especial_consumo_taxa' => 'Especial Consumo Taxa',
            'exloracao_taxa' => 'Exloracao Taxa',
            'contibuicao_audiovisual_cost' => 'Contibuicao Audiovisual Cost',
            'contibuicao_audiovisual_taxa' => 'Contibuicao Audiovisual Taxa',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getTariffs()
    {
        return $this->hasMany(Tariff::className(), ['electricity_company_id' => 'id']);
    }
}
