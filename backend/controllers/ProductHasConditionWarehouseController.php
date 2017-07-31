<?php

namespace backend\controllers;

use Yii;
use backend\models\ProductHasConditionWarehouse;
use backend\models\ProductHasConditionWarehouseSearch;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;

/**
 * ProductHasConditionWarehouseController implements the CRUD actions for ProductHasConditionWarehouse model.
 */
class ProductHasConditionWarehouseController extends Controller
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
     * Lists all ProductHasConditionWarehouse models.
     * @return mixed
     */
    public function actionIndex()
    {
        $searchModel = new ProductHasConditionWarehouseSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Displays a single ProductHasConditionWarehouse model.
     * @param integer $product_id
     * @param integer $condition_id
     * @param integer $warehouse_id
     * @return mixed
     */
    public function actionView($product_id, $condition_id, $warehouse_id)
    {
        return $this->render('view', [
            'model' => $this->findModel($product_id, $condition_id, $warehouse_id),
        ]);
    }

    /**
     * Creates a new ProductHasConditionWarehouse model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate()
    {
        $model = new ProductHasConditionWarehouse();

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect(['view', 'product_id' => $model->product_id, 'condition_id' => $model->condition_id, 'warehouse_id' => $model->warehouse_id]);
        } else {
            return $this->render('create', [
                'model' => $model,
            ]);
        }
    }

    /**
     * Updates an existing ProductHasConditionWarehouse model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param integer $product_id
     * @param integer $condition_id
     * @param integer $warehouse_id
     * @return mixed
     */
    public function actionUpdate($product_id, $condition_id, $warehouse_id)
    {
        $model = $this->findModel($product_id, $condition_id, $warehouse_id);

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect(['view', 'product_id' => $model->product_id, 'condition_id' => $model->condition_id, 'warehouse_id' => $model->warehouse_id]);
        } else {
            return $this->render('update', [
                'model' => $model,
            ]);
        }
    }

    /**
     * Deletes an existing ProductHasConditionWarehouse model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param integer $product_id
     * @param integer $condition_id
     * @param integer $warehouse_id
     * @return mixed
     */
    public function actionDelete($product_id, $condition_id, $warehouse_id)
    {
        $this->findModel($product_id, $condition_id, $warehouse_id)->delete();

        return $this->redirect(['index']);
    }

    /**
     * Finds the ProductHasConditionWarehouse model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $product_id
     * @param integer $condition_id
     * @param integer $warehouse_id
     * @return ProductHasConditionWarehouse the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($product_id, $condition_id, $warehouse_id)
    {
        if (($model = ProductHasConditionWarehouse::findOne(['product_id' => $product_id, 'condition_id' => $condition_id, 'warehouse_id' => $warehouse_id])) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }
}
