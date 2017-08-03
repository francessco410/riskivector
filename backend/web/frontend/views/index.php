<?php

use yii\helpers\Html;
use yii\grid\GridView;

/* @var $this yii\web\View */
/* @var $searchModel frontend\models\StudentBookingSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Student Bookings';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="student-booking-index">

    <h1><?= Html::encode($this->title) ?></h1>
    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>

    <p>
        <?= Html::a('Create Student Booking', ['create'], ['class' => 'btn btn-success']) ?>
    </p>
    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],

            'id',
            'course',
            'home_university',
            'arrival_date',
            'months',
            // 'room_type',
            // 'kit',
            // 'date',
            // 'validated',
            // 'person_booking_id',

            ['class' => 'yii\grid\ActionColumn'],
        ],
    ]); ?>
</div>
