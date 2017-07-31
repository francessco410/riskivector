<?php

namespace backend\controllers;

use Yii;
use backend\models\Product;
use backend\models\ProductSearch;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use yii\helpers\ArrayHelper;
use backend\models\Warehouse;
use backend\models\Condition;
use backend\models\ProductHasConditionWarehouse;
use backend\models\Model;

/**
 * ProductController implements the CRUD actions for Product model.
 */
class ProductController extends Controller
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
     * Lists all Product models.
     * @return mixed
     */
    public function actionIndex()
    {
        $searchModel = new ProductSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Displays a single Product model.
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
     * Creates a new Product model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate()
    {
        $model = new Product();

        $modelPHCW = [new ProductHasConditionWarehouse];

        if ($model->load(Yii::$app->request->post())) {

            $modelPHCW = Model::createMultiple(ProductHasConditionWarehouse::classname());
            Model::loadMultiple($modelPHCW, Yii::$app->request->post());

            // validate all models
            $valid = $model->validate();
            $valid = Model::validateMultiple($modelPHCW) && $valid;
            
            // echo '<pre>';
            // print_r($modelPHCW);
            // echo '</pre>';
            // die();

            if ($valid) {
                $transaction = \Yii::$app->db->beginTransaction();
                try {
                    if ($flag = $model->save(false)) {
                        foreach ($modelPHCW as $modelphcw) {
                            $modelphcw->product_id = $model->id;
                            if (! ($flag = $modelphcw->save(false))) {
                                $transaction->rollBack();
                                break;
                            }
                        }
                    }
                    if ($flag) {
                        $transaction->commit();
                        return $this->redirect(['view', 'id' => $model->id]);
                    }
                } catch (Exception $e) {
                    $transaction->rollBack();
                }
            }
            //----------------------------->
            
            //$var_warehouse = ArrayHelper::getValue(Yii::$app->request->post(), 'Product.warehouses');
            //$var_condition = ArrayHelper::getValue(Yii::$app->request->post(), 'Product.conditions');
            
//            echo '<pre>';
//            print_r($var_condition);
//            echo '</pre>';
            
            //$model_warehouse = Warehouse::findOne($var_warehouse);
            //$model_condition = Condition::findOne($var_condition);
            
            
            //$model->link('warehouses', $model_warehouse, ['condition_id' => $model_condition->id]);
            return $this->redirect(['view', 'id' => $model->id]);
        } else {
            return $this->render('create', [
                'model' => $model,
                'modelPHCW' => (empty($modelPHCW)) ? [new ProductHasConditionWarehouse] : $modelPHCW
            ]);
        }
    }

    /**
     * Updates an existing Product model.
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
     * Deletes an existing Product model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param integer $id
     * @return mixed
     */
    public function actionDelete($id)
    {
        //$model = $this->findModel($id);
        $model_product = Product::findOne(Yii::$app->request->get('id'));
                
        $warehouses = $model_product -> getWarehouses_custom();
       
        
        $model_product->unlink('warehouses', $warehouses[0],$delete = true);
        
        
        $this->findModel($id)->delete();

        return $this->redirect(['index']);
    }

    /**
     * Finds the Product model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return Product the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = Product::findOne($id)) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }
}
