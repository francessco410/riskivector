<?php

namespace backend\controllers;

use Yii;
use backend\models\Bill;
use backend\models\BillSearch;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use backend\models\Counter; 

/**
 * BillController implements the CRUD actions for Bill model.
 */
class BillController extends Controller
{
    /**
     * @inheritdoc
     */
    public function behaviors()
    {
        return [
            'verbs' => [
                'class' => VerbFilter::className(),
                'actions' => [
                    'delete' => ['POST'],
                ],
            ],
        ];
    }

    /**
     * Lists all Bill models.
     * @return mixed
     */
    public function actionIndex()
    {
        $searchModel = new BillSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Displays a single Bill model.
     * @param integer $id
     * @return mixed
     */
    public function actionView($id)
    {
        return $this->render('view', [
            'model' => $this->findModel($id),
        ]);
    }

    /**
     * Creates a new Bill model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate()
    {
        $model = new Bill();

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect(['view', 'id' => $model->ID]);
        } else {
            return $this->render('create', [
                'model' => $model,
            ]);
        }
    }

    /**
     * Updates an existing Bill model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param integer $id
     * @return mixed
     */
    public function actionUpdate($id)
    {
        $model = $this->findModel($id);

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect(['view', 'id' => $model->ID]);
        } else {
            return $this->render('update', [
                'model' => $model,
            ]);
        }
    }

    /**
     * Deletes an existing Bill model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param integer $id
     * @return mixed
     */
    public function actionDelete($id)
    {
        $this->findModel($id)->delete();

        return $this->redirect(['index']);
    }

    /**
     * Finds the Bill model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return Bill the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = Bill::findOne($id)) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }
    public function createBill($model)
    {
        $bill= new Bill();
        $bill->rent_cost=Bill::findBySql("select sum(cost) as rent_cost FROM room WHERE flat_id='$model->flat_id'")->one()->rent_cost;
        $bill->water= self::countWater($model);
//        echo '<pre>';
//        print_r($bill->water);
//        echo '<pre>';
//        die();
        $bill->electricity= self::countElectricity($model);
        $bill->gas=self::countGas($model);
        $bill->other_expences=self::countExpences($model);
        $bill->dues=$bill->other_expences+$bill->gas+$bill->electricity+$bill->water+$bill->rent_cost;
        $bill->counter_id=$model->id;
        return $bill->save()?true:false;
    }
       
    function countWater($model)
{
    $id= Counter::find()->where(['flat_id'=>$model->flat_id])->orderBy('id desc')->limit(2)->all();
    if(count($id)<2){
        return 0;
    }
    $days=(strtotime (Counter::findOne($id[0]['id'])['date'])-strtotime (Counter::findOne($id[1]['id'])['date']))/(60*60*24);
    $water=Counter::findOne($id[0]['id'])['water_total']-Counter::findOne($id[1]['id'])['water_total'];
    $return=0;
    $model= \backend\models\WaterCompany::findBySql("SELECT * FROM water_company wc
                                                    INNER JOIN tariff ta on wc.id=ta.water_company_id 
                                                    INNER join flat fl on ta.flat_id=fl.id where fl.id='$model->flat_id'")->one();
    if($days>=0&&$water>=0){
                            $return=
                                (($days + 1) * $model->tarifa_fixa_urbana) +
                                (($days + 1) * $model->tarifa_fixa_saneamento) +
                                (($water) *  $model->tarifa_variavel_saneamento) +
                                (($water) *  $model->um_residuos_solidos) +
                                (($days + 1) * $model->tarifa_fixa_rsu)+
                               
                                ((($days + 1) * $model->tarifa_fixa_urbana) + 
                                ($water * $model->um_residuos_solidos)) * 0.06;

                                if($water>5){
                                    $return=$return+(5*$model->um_escalao_cost)
                                            +(5*$model->um_escalao_cost)*0.06;
                                    if($water>10){
                                        $return=$return+(10*$model->dois_escalao_cost)
                                                +(10*$model->dois_escalao_cost)*0.06;
                                        if($water>15){
                                             $return=$return+(($water-15)*$model->tres_escalao_cost)+
                                                     (($water-15)*$model->tres_escalao_cost)*0.06;
                                        }
                                        else{
                                            $return=$return+(($water-10)*$model->tres_escalao_cost)+
                                                     (($water-10)*$model->tres_escalao_cost)*0.06;
                                        }
                                       
                                    }
                                    else{
                                        $return=$return+(($water-5)*$model->dois_escalao_cost)+
                                                (($water-5)*$model->dois_escalao_cost)*0.06;
                                    }
                                }
                                else{
                                    $return=$return+($water*$model->um_escalao_cost)
                                            +($water*$model->um_escalao_cost)*0.06;
                                }
                                
    }
    return round($return,2);
}
function countElectricity($model)
{
    $id= Counter::find()->where(['flat_id'=>$model->flat_id])->orderBy('id desc')->limit(2)->all();
    if(count($id)<2){
        return 0;
    }
    $days=(strtotime (Counter::findOne($id[0]['id'])['date'])-strtotime (Counter::findOne($id[1]['id'])['date']))/(60*60*24);
    $vazio=Counter::findOne($id[0]['id'])['vazio_value']-Counter::findOne($id[1]['id'])['vazio_value'];
    $ponta=Counter::findOne($id[0]['id'])['ponta_value']-Counter::findOne($id[1]['id'])['ponta_value'];
    $cheia=Counter::findOne($id[0]['id'])['cheia_value']-Counter::findOne($id[1]['id'])['cheia_value'];
    $return=0;
    $model= \backend\models\ElectricityCompany::findBySql("SELECT * FROM electricity_company ec
                                                     INNER JOIN tariff ta on ec.id=ta.electricity_company_id 
                                                     INNER join flat fl on ta.flat_id=fl.id where fl.id='$model->flat_id'")->one();
    if($days>=0&&$vazio>=0||$ponta>=0||$cheia>=0){
  
    $return=($vazio*$model->vazio_cost) + 
    (($ponta + $cheia) * $model->ponta_cost)+   //day_cost?  
    ((($days + 1) *$model->potencia_contratada_cost) * 
    $model->national_taxa) + 
    ($model->especial_consumo_taxa * ($vazio + $ponta+ $cheia)) + 
    (($model->exloracao_taxa * ($days + 1)) *
    $model->national_taxa) + 
    (($model->contibuicao_audiovisual_cost * ($days + 1)) * 
    $model->contibuicao_audiovisual_taxa);
    }
    return round($return,2);
}
function countGas($model)
{
    $id= Counter::find()->where(['flat_id'=>$model->flat_id])->orderBy('id desc')->limit(2)->all();
    if(count($id)<2){
        return 0;
    }
    $days=(strtotime (Counter::findOne($id[0]['id'])['date'])-strtotime (Counter::findOne($id[1]['id'])['date']))/(60*60*24);
    $gas=Counter::findOne($id[0]['id'])['gas_total']-Counter::findOne($id[1]['id'])['gas_total'];
    $return=0;
    $model= \backend\models\GasCompany::findBySql("SELECT * FROM gas_company gc
                                                     INNER JOIN tariff ta on gc.id=ta.gas_company_id 
                                                     INNER join flat fl on ta.flat_id=fl.id where fl.id='$model->flat_id'")->one();
    if($days>=0&&$gas>0){
  
    $return=($gas * $model->fator_conversao_kwh_e * $model->consumo_gas) + (($days + 1) * $model->termo_fixo) +
    ($gas * $model->fator_conversao_kwh_e * $model->especial_consumo_taxa) +
    (($days + 1) * $model->acesso_redes) * $model->national_taxa;
    return round($return,2);
}
}
function countExpences($model)
{
    $id= Counter::find()->where(['flat_id'=>$model->flat_id])->orderBy('id desc')->limit(2)->all();
    if(count($id)<2){
        return 0;
    }
    $date1=$id[0]['date'];
    $date2=$id[1]['date'];
    $flat_id=$id[0]['flat_id'];
    $return=Bill::findBySql("SELECT sum(amount)as other_expences FROM tenant_fine tf 
                   INNER join tenant te on tf.tenant_id=te.id 
                   inner join tenant_has_room thr on te.id=thr.tenant_id 
                   INNER join room r on thr.room_id=r.id 
                   inner join flat f on r.flat_id=f.id 
                   WHERE f.id='$flat_id' and tf.date BETWEEN '$date2' and '$date1'
                   and thr.check_out_date BETWEEN '$date2' and '$date1' 
                   or thr.check_out_date is null;")->one();
    return $return->other_expences;
}
}
