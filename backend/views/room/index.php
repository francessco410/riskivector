<?php

use yii\helpers\Html;
use yii\grid\GridView;
use backend\models\Building;
use backend\models\Flat;
use backend\models\Tenant;
use backend\models\Person;

/* @var $this yii\web\View */
/* @var $searchModel backend\models\RoomSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Rooms';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="room-index">

    <h1><?= Html::encode($this->title) ?></h1>
    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>

    <p>
        <?= Html::a('Create Room', ['create'], ['class' => 'btn btn-success']) ?>
    </p>
    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],
            [
                'attribute' => 'stud',
                'format'=>'raw',
                'value'=> function($model){
                    $flat = Flat::find()->where(['id' => $model->flat_id])->one();
                    $building = Building::find()->where(['id' => $flat->building_id])->one();
                    return $out_name = $building->name.' '.$flat->number;
               }
            ],
            [
                'attribute' => 'students_name',
                'format'=>'raw',
                'value'=> function($model){
                    $out = '';
                    $array = $model->getInformation();
                    $amount = isset($array) ? count($array) : 0;
                    $type = $model->type;
                    

                    foreach ($model->getInformation() as $info){
                        $out .= $info['name'].' '.$info['surname'].'<br>';
                    }
                    $links = $type - $amount;
                    
                    while ($links > 0){
                        $out .= '<a href="index.php?r=tenant-has-room/create">Register Student</a><br>';
                        $links--;
                    }
                    
                    //$out = substr($out, 0, -4);
                    return $out;
               }
            ],     
            [
                'attribute' => 'arrival_date',
                'format'=>'raw',
                'value'=> function($model){
                    $out = '';
                    foreach ($model->getInformation() as $info){
                        $out .= $info['accommodation_date'].'<br>';
                    }
                    return $out;
               }
            ],
            'number',
            [
                'attribute' => 'type',
                'format'=>'raw',
                'value'=> function($model){
                    $out = 'undefined';
                       switch ($model->type){
                        case 1:
                            $out = 'Single Room';
                            break;
                        case 2:
                            $out = 'Double Room';
                            break;
                        case 3:
                            $out = 'Triple Room';
                            break;
                    }
                    return $out;
               }
            ],
            [
                'attribute' => 'departure_date',
                'format'=>'raw',
                'value'=> function($model){
                    $out = '';
                    foreach ($model->getInformation() as $info){
                        $out .= $info['departure_date'].'<br>';
                    }
                    return $out;
               }
            ],       

            ['class' => 'yii\grid\ActionColumn'],
        ],
    ]); ?>
</div>
