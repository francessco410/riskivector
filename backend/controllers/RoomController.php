<?php

namespace backend\controllers;

use Yii;
use backend\models\Room;
use backend\models\RoomSearch;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use backend\models\Person;
use backend\models\Building;
use backend\models\Flat;

/**
 * RoomController implements the CRUD actions for Room model.
 */
class RoomController extends Controller
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
     * Lists all Room models.
     * @return mixed
     */
    public function actionIndex()
    {
        $searchModel = new RoomSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Displays a single Room model.
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
     * Creates a new Room model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate()
    {
        $model = new Room();
        $model_building = new \backend\models\Building();
        

        if ($model->load(Yii::$app->request->post())) {
            $model->save();
            return $this->redirect(['view', 'id' => $model->id]);
        } else {
            return $this->render('create', [
                'model' => $model,
                'model_building'=>$model_building,
            ]);
        }
    }

    /**
     * Updates an existing Room model.
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

    /**
     * Deletes an existing Room model.
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
     * Finds the Room model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return Room the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = Room::findOne($id)) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
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
                echo "<option value='".$flat->id."'>".$flat->number."</option>";
            }
        }else{
            echo "<option> - </option>";
        }
    }
    public function actionRooms(){
//        $countFlats = Flat::find()
//                ->where(['building_id' => $id])
//                ->count();
        $flats = Flat::find()
                ->one();
        $roomsCount = Room::find()
                ->where(['flat_id' => $flats->id])
                ->count();
        $rooms = Room::find()
                ->where(['flat_id' => $flats->id])
                ->one();
        echo '<div class="btn-group" data-toggle="buttons">';
        if($roomsCount > 0){
            foreach ($rooms as $room){
                //echo "<option value='".$flat->id."'>".$flat->number."</option>";
                echo '<label class="btn btn-primary">'+
                      "<input type='radio' name='options' id='option.'$room->id'.' autocomplete='off' checked> .'$room->number'."
                      +'</label>';
            }
        }else{
            echo "<option> - </option>";
        }
        echo '</div>';
        
//        <div class="btn-group" data-toggle="buttons">
//  <label class="btn btn-primary active">
//    <input type="radio" name="options" id="option1" autocomplete="off" checked> Radio 1
//  </label>
//  <label class="btn btn-primary">
//    <input type="radio" name="options" id="option2" autocomplete="off"> Radio 2
//  </label>
//  <label class="btn btn-primary">
//    <input type="radio" name="options" id="option3" autocomplete="off"> Radio 3
//  </label>
//    </div>
    }
    
}
