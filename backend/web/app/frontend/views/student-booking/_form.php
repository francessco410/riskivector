<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model frontend\models\StudentBooking */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="student-booking-form">

    <?php $form = ActiveForm::begin(); ?>

    <?= $form->field($model, 'course')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'home_university')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'arrival_date')->textInput() ?>

    <?= $form->field($model, 'months')->textInput() ?>

    <?= $form->field($model, 'room_type')->textInput() ?>

    <?= $form->field($model, 'kit')->textInput() ?>

    <?= $form->field($model, 'date')->textInput() ?>

    <?= $form->field($model, 'validated')->textInput() ?>

    <?= $form->field($model, 'person_booking_id')->textInput() ?>

    <div class="form-group">
        <?= Html::submitButton($model->isNewRecord ? 'Create' : 'Update', ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
