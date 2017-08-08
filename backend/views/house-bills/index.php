<?php

use yii\helpers\Html;
use yii\grid\GridView;
use backend\models\Counter;

/* @var $this yii\web\View */
/* @var $searchModel backend\models\HouseBillsSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Bills';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="counter-index">

    <h1><?= Html::encode($this->title) ?></h1>
    <?php  //echo $this->render('_search', ['model' => $searchModel]); ?>

   
    <?= GridView::widget([
        'dataProvider' => $dataProvider,
//        'filterModel' => $searchModel,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],
            
            'flat.building.name',
            'date:date',
//            [
//                //'attribute'=>'date',
//                'label'=>'Month',
//                'value' => function($model) {
//                            $return=date("M-Y",strtotime($model->date));
//		            return $return;
//	            },
//            ],  
            [
                'label'=>'Rent Cost',
                'value'=>'flat.cost'
                
            ],
            
            
            //'water_total',
            [
                'attribute'=>'water_total',
                'label'=>'Water',
                'value' => function($model) {
                return countWater($model);
                }
                

//                'value' => function($model) {
//                            
//                            $return=\backend\models\Tariff::findOne(1);
//                            return $return['gas_company_id'];
//                            //->tariff->waterCompany->tarifa_fixa_urbana
//	            },
                
            ],
            [
                'label'=>'Electricity',
                'value' => function($model) {
                return countElectricity($model);
                }
            ],
            [
                'label'=>'Gas'
            ],
            [
                'label'=>'Other Expenses'
            ],
                            [
                'label'=>'Dues'
            ],
            // 'gas_total',
            [
                'label'=>'Added By',
               // 'value'=>'user.person.name',
                'value' => function($model) {
		            return $model->user->person->name." ".$model->user->person->surname;
	            },
                               
            ],
           

            ['class' => 'yii\grid\ActionColumn'],
        ],
    ]); ?>
</div>
<?php
//function countWater($model)
//{
//    $days=(strtotime (Counter::findOne($model->id+1)['date'])-strtotime (Counter::findOne($model->id)['date']))/(60*60*24);
//    $water=Counter::findOne($model->id+1)['water_total']-Counter::findOne($model->id)['water_total'];
//    $return=0;
//    if($days>=0&&$water>=0){
//                            $return=
//                                (($days + 1) * $model->flat->tariff->waterCompany->tarifa_fixa_urbana) +
//                                (($days + 1) * $model->flat->tariff->waterCompany->tarifa_fixa_saneamento) +
//                                (($water) *  $model->flat->tariff->waterCompany->tarifa_variavel_saneamento) +
//                                (($water) *  $model->flat->tariff->waterCompany->um_residuos_solidos) +
//                                (($days + 1) * $model->flat->tariff->waterCompany->tarifa_fixa_rsu)+
//                               
//                                ((($days + 1) * $model->flat->tariff->waterCompany->tarifa_fixa_urbana) + 
//                                ($water * $model->flat->tariff->waterCompany->um_residuos_solidos)) * 0.06;
//
//                                if($water>5){
//                                    $return=$return+(5*$model->flat->tariff->waterCompany->um_escalao_cost)
//                                            +(5*$model->flat->tariff->waterCompany->um_escalao_cost)*0.06;
//                                    if($water>10){
//                                        $return=$return+(10*$model->flat->tariff->waterCompany->dois_escalao_cost)
//                                                +(10*$model->flat->tariff->waterCompany->dois_escalao_cost)*0.06;
//                                        if($water>15){
//                                             $return=$return+(($water-15)*$model->flat->tariff->waterCompany->tres_escalao_cost)+
//                                                     (($water-15)*$model->flat->tariff->waterCompany->tres_escalao_cost)*0.06;
//                                        }
//                                        else{
//                                            $return=$return+(($water-10)*$model->flat->tariff->waterCompany->tres_escalao_cost)+
//                                                     (($water-10)*$model->flat->tariff->waterCompany->tres_escalao_cost)*0.06;
//                                        }
//                                       
//                                    }
//                                    else{
//                                        $return=$return+(($water-5)*$model->flat->tariff->waterCompany->dois_escalao_cost)+
//                                                (($water-5)*$model->flat->tariff->waterCompany->dois_escalao_cost)*0.06;
//                                    }
//                                }
//                                else{
//                                    $return=$return+($water*$model->flat->tariff->waterCompany->um_escalao_cost)
//                                            +($water*$model->flat->tariff->waterCompany->um_escalao_cost)*0.06;
//                                }
//                                
//    }
//    return round($return,2)." €";
//}
//function countElectricity($model)
//{
//    $days=(strtotime (Counter::findOne($model->id+1)['date'])-strtotime (Counter::findOne($model->id)['date']))/(60*60*24);
//    $vazio=Counter::findOne($model->id+1)['vazio_value']-Counter::findOne($model->id)['vazio_value'];
//    $ponta=Counter::findOne($model->id+1)['ponta_value']-Counter::findOne($model->id)['ponta_value'];
//    $cheia=Counter::findOne($model->id+1)['cheia_value']-Counter::findOne($model->id)['cheia_value'];
//    $return=0;
//
//    if($days>=0&&$vazio>=0||$ponta>=0||$cheia>=0){
//  
//    $return=($vazio*$model->flat->tariff->electricityCompany->vazio_cost) + 
//    (($ponta + $cheia) * $model->flat->tariff->electricityCompany->ponta_cost)+   //day_cost?  
//    ((($days + 1) *$model->flat->tariff->electricityCompany->potencia_contratada_cost) * 
//    $model->flat->tariff->electricityCompany->national_taxa) + 
//    ($model->flat->tariff->electricityCompany->especial_consumo_taxa * ($vazio + $ponta+ $cheia)) + 
//    (($model->flat->tariff->electricityCompany->exloracao_taxa * ($days + 1)) *
//    $model->flat->tariff->electricityCompany->national_taxa) + 
//    (($model->flat->tariff->electricityCompany->contibuicao_audiovisual_cost * ($days + 1)) * 
//    $model->flat->tariff->electricityCompany->contibuicao_audiovisual_taxa);
//    }
//    return round($return,2)." €";
//}

