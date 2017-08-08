<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use backend\models\Flat;
use backend\models\Building;
use yii\helpers\ArrayHelper;
use kartik\select2\Select2;
/* @var $this yii\web\View */
/* @var $model backend\models\Room */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="room-form">

    <?php $form = ActiveForm::begin(); ?>

    <?= $form->field($model, 'number')->textInput() ?>

    <?= $form->field($model, 'cost')->textInput() ?>

    <?= $form->field($model, 'type')->dropDownList(    
        [ 1 => 'Single Room', 2 => 'Double Room', 3 => 'Triple Room'],
        ['prompt' => 'Select type']
    )?>
    
    <?= $form->field($model_building, 'id')->widget(Select2::classname(), 
        [ 
            'data' =>  ArrayHelper::map(Building::find()->all(),'id','name'),
            'language' => 'en',
            'options' => ['placeholder' => 'Select building'],
            'pluginOptions' => [
            'allowClear' => true,
        ],
            'pluginEvents' => [
            'select2:select' => 'function() {$.post("index.php?r=room/lists&id='.'"+$(this).val(),function(data){$("select#room-flat_id").html(data);});}',
         ] 
    ]); ?>
    

    
    <?= $form->field($model, 'flat_id')->dropDownList(    
        ['prompt' => 'Select Flat']
    )?>
    
    
    <div class="form-group">
        <?= Html::submitButton($model->isNewRecord ? 'Create' : 'Update', ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>