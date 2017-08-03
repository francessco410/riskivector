<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model backend\models\StudentBookingSearch */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="student-booking-search">

    <?php $form = ActiveForm::begin([
        'action' => ['index'],
        'method' => 'get',
    ]); ?>

    <?= $form->field($model, 'id') ?>

    <?= $form->field($model, 'course') ?>

    <?= $form->field($model, 'home_university') ?>

    <?= $form->field($model, 'arrival_date') ?>

    <?= $form->field($model, 'months') ?>

    <?php // echo $form->field($model, 'room_type') ?>

    <?php // echo $form->field($model, 'kit') ?>

    <?php // echo $form->field($model, 'date') ?>

    <?php // echo $form->field($model, 'validated') ?>

    <?php // echo $form->field($model, 'coment') ?>

    <?php // echo $form->field($model, 'person_booking_id') ?>

    <div class="form-group">
        <?= Html::submitButton('Search', ['class' => 'btn btn-primary']) ?>
        <?= Html::resetButton('Reset', ['class' => 'btn btn-default']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
