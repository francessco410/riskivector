<?php

use yii\helpers\Html;
use yii\grid\GridView;

/* @var $this yii\web\View */
/* @var $searchModel backend\models\StudentBookingSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Student Bookings';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="student-booking-index">

    <h1><?= Html::encode($this->title) ?></h1>
    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>

<!--    <p>
        <?= Html::a('Create Student Booking', ['create'], ['class' => 'btn btn-success']) ?>
    </p>-->
    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],
            [
                'label'=>'Name',
                'attribute' => 'person_booking_id',
                'value'=> function($model){
                    return $model->personBooking->name.' '.$model->personBooking->surname;
               }
            ],
            [
                'attribute' => 'country',
                'value' => 'personBooking.country'
            ],
            'personBooking.email',
            'arrival_date:date',
            [
                'attribute' => 'room_type',
                'value'=> function($model){
                    $out = '';
                    switch ($model->room_type){
                        case 1:
                            $out = 'Single room';
                            break;
                        case 2:
                            $out = 'Double room';
                            break;
                        default :
                            $out = 'Other';
                            break;;
                    }
                    return $out;
                }
            ],
            [
                'attribute' => 'kit',
                'value'=> function($model){
                    return $out = $model->kit == 1 ? 'Yes' : 'No';
                }
            ],
            // 'room_type',
            // 'kit',
            'date:date',
            // 'validated',
             'coment',
            // 'person_booking_id',

            ['class' => 'yii\grid\ActionColumn',
             'template' => '{create} {view}  {update} {delete}',
             'buttons' => [
                'create' => function ($url) {
                    return Html::a(
                        '<span class="glyphicon glyphicon-plus"></span>',
                        $url, 
                        [
                            'title' => 'Create',
                            'data-pjax' => '0',
                        ]
                    );
                },
            ],   
                
            ],
        ],
    ]); ?>
</div>
