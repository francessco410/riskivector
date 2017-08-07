<?php

use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $model backend\models\StudentBooking */

$this->title = 'Create Student Booking';
$this->params['breadcrumbs'][] = ['label' => 'Student Bookings', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="student-booking-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
        'model_student' => $model_student,
        'model_person' => $model_person,
        'model_tenant' => $model_tenant,
        'model_building' => $model_building,
        'model_flat' => $model_flat,
        'model_room' => $model_room,
        'model_PHCW' => $model_PHCW,
    ]) ?>

</div>
