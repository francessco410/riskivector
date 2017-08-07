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
use backend\models\ProductHasConditionWarehouse;
use backend\models\Model;
use backend\models\Warehouse;

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
        
        $modelPHCW = Model::createMultiple(ProductHasConditionWarehouse::classname());
        
        
        $default_kit = 
        [
            'ProductHasConditionWarehouse' => 
            [
                'warehouse_id' => 1,
                'condition_id',
                'amount',
            ],
            [
                'warehouse_id',
                'condition_id',
                'amount',
            ],
        ];
        Model::loadMultiple($modelPHCW, $default_kit);
        
        
        
//        $modelPHCW = new ProductHasConditionWarehouse();
//        $modelPHCW -> product_id = $model->id;
//        $modelPHCW = $model -> productHasConditionWarehouses;
        

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
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
