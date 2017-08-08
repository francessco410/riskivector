<?php

namespace backend\controllers;

use Yii;
use backend\models\StudentBooking;
use backend\models\StudentBookingSearch;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use backend\models\Person;
use backend\models\Tenant;
use backend\models\ProductHasConditionWarehouse;
use backend\models\Model;
use backend\models\Student;
use backend\models\Room;
use backend\models\Building;
use backend\models\Flat;
use backend\models\Warehouse;
use backend\models\Product;
use backend\models\Condition;

/**
 * StudentBookingController implements the CRUD actions for StudentBooking model.
 */
class StudentBookingController extends Controller
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
     * Lists all StudentBooking models.
     * @return mixed
     */
    public function actionIndex()
    {
        $searchModel = new StudentBookingSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }
    
    public function actionRegister(){
        return 'Hello World';
    }

    /**
     * Displays a single StudentBooking model.
     * @param integer $id
     * @return mixed
     */
    public function actionPicker($id){
        $this->layout = 'roomPickerLayout';
        Yii::$app->RoomPicker->init_picker($id);
    }


    public function actionView($id)
    {
        return $this->render('view', [
            'model' => $this->findModel($id),
        ]);
    }

    /**
     * Creates a new StudentBooking model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate($id)
    {
        $model = new StudentBooking();
        $model = $this->findModel($id);
        
        $model_student = new Student();
        $model_person = new Person();
        $model_tenant = new Tenant();
        $model_building = new Building();
        $model_flat = new Flat();
        $model_room = new Room();
        $model_PHCW = [new ProductHasConditionWarehouse];
        
        $model_student->load($model->getInformations());
        $model_person ->load($model->getInformations());
        $model_tenant ->load($model->getInformations());
        
        $default_kit = self::getDefaultKit();
        $model_PHCW = Model::createMultipleN(ProductHasConditionWarehouse::classname(), $default_kit, true);
        Model::loadMultiple($model_PHCW, $default_kit);
        
        
        
//        $modelPHCW = new ProductHasConditionWarehouse();
//        $modelPHCW -> product_id = $model->id;
//        $modelPHCW = $model -> productHasConditionWarehouses;
        

        if ($model_person->load(Yii::$app->request->post())) {
            
            
            $tmp = [
                'Building' =>
                [
                    'id' => 1,
                    //'name' => 'dsad',
                    //'number' => 2,
                    //'address_id' => 1,
                ],
            ];
            
           
            
            
            $model_student->load(Yii::$app->request->post());
            $model_person->load(Yii::$app->request->post());
            $model_tenant->load(Yii::$app->request->post());
            $model_building->load(Yii::$app->request->post());
            $model_flat->load(Yii::$app->request->post());
            $model_room->load(Yii::$app->request->post());
            
            
            
            echo '<pre>';
            echo '----------------------------------------------------------><br>';
            print_r($model_building);
            echo '----------------------------------------------------------><br>';
            print_r($model_flat);
            echo '----------------------------------------------------------><br>';
            print_r($model_room);
            echo '----------------------------------------------------------><br>';
            echo '</pre>';
            die();
            
            return $this->redirect(['view', 'id' => $model->id]);
        } else {
            return $this->render('create', [
                'model' => $model,
                'model_student' => $model_student,
                'model_person' => $model_person,
                'model_tenant' => $model_tenant,
                'model_building' => $model_building,
                'model_flat' => $model_flat,
                'model_room' => $model_room,
                'model_PHCW' => $model_PHCW,
                //'modelPHCW' => (empty($modelPHCW)) ? [new ProductHasConditionWarehouse] : $modelPHCW
                
            ]);
        }
    }

    /**
     * Updates an existing StudentBooking model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param integer $id
     * @return mixed
     */
    
    function getDefaultKit(){
        
//        $default_list = [
//            'Electric heater' => 1,
//            'TestBraganca' => 1,
//            'Summer blanket' => 1,
//            'Winter blanket' => 1,
//            'Blanket cover' => 1,
//            'Bed-sheet' => 2,
//            'Pillow' => 1,
//            'Pillow cover' => 1,
//            'Towel' => 2,
//            'Plate' => 1,
//            'Cup' => 1,
//            'Glass' => 1,
//            'Fork' => 1,
//            'Knife' => 1,
//            'Spoon' => 1,
//            'Bowl' => 1,
//            'Sim card' => 1,
//            '123' => 1,
//        ];
//        
        
        $default_list =
                [
                    '123' => 10,
                    'Plates' => 2,
                    '1º Sheets' => 5,
                ];
        
        $products_output = array();
        
        foreach ($default_list as $product => $amount){
            
            if(isset($product, $amount)){
                $product_id = Product::find()->where(['name' => $product])->one();
                $product_id = isset($product_id) ? $product_id->id : FALSE;
                if($product_id){
                    $valid = self::warehouseValidation($product_id);
                    $valid->amount = $amount;
                    $products_output[] = $valid;
                }
            }
        }

        
        $default_kit = 
        [
            'ProductHasConditionWarehouse' => [],
        ];

        foreach ($products_output as $item){
            array_push($default_kit['ProductHasConditionWarehouse'], $item->buildArray());
        }
        
        return $default_kit;
    }
    
    function warehouseValidation($id){
        $models = ProductHasConditionWarehouse::find()->where(['product_id' => $id])->all();
        $output = array();
        foreach ($models as $model){
            $model = isset($model) && $model->amount > 0 ? $model : NULL;
            if($model){
                $output[] = $model;
            }
        }
        
        if(isset($output)){
            $best = $output[0];
            foreach ($output as $product){
                $id = Condition::find()->where(['id' => $product->condition_id])->one();
                $id = isset($id) ? $id->id : false;
                $best = $id < $best->condition_id && $id != false ? $product : $best;
            }         
            return $best;
        }
        return false;
    }

    public function actionUpdate($id)
    {
        $model = $this->findModel($id);

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect(['view', 'id' => $model->id]);
        } else {
            return $this->render('update', [
                'model' => $model,
            ]);
        }
    }
    
    public function actionLists($id){
        $countFlats = Flat::find()
                ->where(['building_id' => $id])
                ->count();
        $flats = Flat::find()
                ->where(['building_id' => $id])
                ->all();
        if($countFlats > 0){
            foreach ($flats as $flat){
                echo "<option value='".$flat->building_id."'>".$flat->number."</option>";
            }
        }else{
            echo "<option> - </option>";
        }
    }

    /**
     * Deletes an existing StudentBooking model.
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
     * Finds the StudentBooking model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return StudentBooking the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = StudentBooking::findOne($id)) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }
}
