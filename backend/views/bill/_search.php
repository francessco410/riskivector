<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model backend\models\BillSearch */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="bill-search">

    <?php $form = ActiveForm::begin([
        'action' => ['index'],
        'method' => 'get',
    ]); ?>

    <?= $form->field($model, 'ID') ?>

    <?= $form->field($model, 'rent_cost') ?>

    <?= $form->field($model, 'water') ?>

    <?= $form->field($model, 'electricity') ?>

    <?= $form->field($model, 'gas') ?>

    <?php // echo $form->field($model, 'other_expences') ?>

    <?php // echo $form->field($model, 'dues') ?>

    <?php // echo $form->field($model, 'counter_id') ?>

    <div class="form-group">
        <?= Html::submitButton('Search', ['class' => 'btn btn-primary']) ?>
        <?= Html::resetButton('Reset', ['class' => 'btn btn-default']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
