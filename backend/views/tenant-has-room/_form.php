<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model backend\models\TenantHasRoom */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="tenant-has-room-form">

    <?php $form = ActiveForm::begin(); ?>

    <?= $form->field($model, 'tenant_id')->textInput() ?>

    <?= $form->field($model, 'room_id')->textInput() ?>

    <?= $form->field($model, 'accommodation_date')->textInput() ?>

    <?= $form->field($model, 'check_out_date')->textInput() ?>

    <div class="form-group">
        <?= Html::submitButton($model->isNewRecord ? 'Create' : 'Update', ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
