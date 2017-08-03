<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model backend\models\Tariff */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="tariff-form">

    <?php $form = ActiveForm::begin(); ?>

    <?= $form->field($model, 'flat_id')->textInput() ?>

    <?= $form->field($model, 'gas_company_id')->textInput() ?>

    <?= $form->field($model, 'electricity_company_id')->textInput() ?>

    <?= $form->field($model, 'water_company_id')->textInput() ?>

    <?= $form->field($model, 'gas_bottle_company_id')->textInput() ?>

    <div class="form-group">
        <?= Html::submitButton($model->isNewRecord ? 'Create' : 'Update', ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
