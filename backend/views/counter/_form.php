<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use yii\helpers\ArrayHelper;
use backend\models\Flat;
use kartik\select2\Select2;
/* @var $this yii\web\View */
/* @var $model backend\models\Counter */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="counter-form">

    <?php $form = ActiveForm::begin(); ?>
    <?= $form->field($model, 'flat_id')->widget(Select2::classname(), 
        [ 
            'data' => ArrayHelper::map(Flat::findBySql("select flat.id,concat(building.name,' ',flat.number) as number from flat,building where flat.building_id=building.id")->all(),'id','number'),
            'language' => 'en',
            'options' => ['placeholder' => 'Select category'],
            'pluginOptions' => [
            'allowClear' => true
        ],
    ]); ?>

<!--Flat::findBySql("select flat.id,concat(building.name,' ',flat.number) as number from flat,building where flat.building_id=building.id")->all()-->
    <?= $form->field($model, 'water_total')->textInput() ?>

    <?= $form->field($model, 'vazio_value')->textInput() ?>

    <?= $form->field($model, 'ponta_value')->textInput() ?>

    <?= $form->field($model, 'cheia_value')->textInput() ?>

    <?= $form->field($model, 'gas_total')->textInput() ?>

    <?= $form->field($model, 'comment')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'counter_photo_id')->textInput() ?>

    <div class="form-group">
        <?= Html::submitButton($model->isNewRecord ? 'Create' : 'Update', ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
