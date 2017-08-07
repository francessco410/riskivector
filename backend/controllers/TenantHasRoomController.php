<?php

namespace backend\controllers;

use Yii;
use backend\models\TenantHasRoom;
use backend\models\TenantHasRoomSearch;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;

/**
 * TenantHasRoomController implements the CRUD actions for TenantHasRoom model.
 */
class TenantHasRoomController extends Controller
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
     * Lists all TenantHasRoom models.
     * @return mixed
     */
    public function actionIndex()
    {
        $searchModel = new TenantHasRoomSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Displays a single TenantHasRoom model.
     * @param integer $tenant_id
     * @param integer $room_id
     * @return mixed
     */
    public function actionView($tenant_id, $room_id)
    {
        return $this->render('view', [
            'model' => $this->findModel($tenant_id, $room_id),
        ]);
    }

    /**
     * Creates a new TenantHasRoom model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate()
    {
        $model = new TenantHasRoom();

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect(['view', 'tenant_id' => $model->tenant_id, 'room_id' => $model->room_id]);
        } else {
            return $this->render('create', [
                'model' => $model,
            ]);
        }
    }

    /**
     * Updates an existing TenantHasRoom model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param integer $tenant_id
     * @param integer $room_id
     * @return mixed
     */
    public function actionUpdate($tenant_id, $room_id)
    {
        $model = $this->findModel($tenant_id, $room_id);

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect(['view', 'tenant_id' => $model->tenant_id, 'room_id' => $model->room_id]);
        } else {
            return $this->render('update', [
                'model' => $model,
            ]);
        }
    }

    /**
     * Deletes an existing TenantHasRoom model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param integer $tenant_id
     * @param integer $room_id
     * @return mixed
     */
    public function actionDelete($tenant_id, $room_id)
    {
        $this->findModel($tenant_id, $room_id)->delete();

        return $this->redirect(['index']);
    }

    /**
     * Finds the TenantHasRoom model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $tenant_id
     * @param integer $room_id
     * @return TenantHasRoom the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($tenant_id, $room_id)
    {
        if (($model = TenantHasRoom::findOne(['tenant_id' => $tenant_id, 'room_id' => $room_id])) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }
}
