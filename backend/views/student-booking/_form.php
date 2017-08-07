<?php

use yii\helpers\Html;
use yii\helpers\ArrayHelper;
use yii\widgets\ActiveForm;
use yii\helpers\Url;
use kartik\select2\Select2;
use backend\models\Building;
use backend\models\Room;
use backend\models\Warehouse;
use backend\models\Condition;
use backend\models\Product;
use wbraganca\dynamicform\DynamicFormWidget;
use amilna\elevatezoom\ElevateZoom;

/* @var $this yii\web\View */
/* @var $model backend\models\StudentBooking */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="student-booking-form">

    <?php $form = ActiveForm::begin(['id' => 'dynamic-form']); ?>
    
    <?= $form->field($model_person, 'name')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model_person, 'surname')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model_person, 'email')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model_person, 'sex')->textInput() ?>

    <?= $form->field($model_person, 'country')->textInput() ?>
    
    <?php 
        $images = ['/advanced/backend/web/upload/id.jpg'];

	echo ElevateZoom::widget([
 		'images'=>$images,
		'baseUrl'=>'@web/upload',
		'smallPrefix'=>'/thumbs',
		'mediumPrefix'=>'/thumbs',
	]);
    ?>
        
    <?= $form->field($model_person, 'phone')->textInput() ?>

    <?= $form->field($model_student, 'home_university')->textInput() ?>

    <?= $form->field($model_tenant, 'smoker')->textInput() ?>
    
    <?= $form->field($model_tenant, 'departure_date')->textInput() ?>
    
    <?= $form->field($model_building, 'id')->widget(Select2::classname(), 
        [ 
            'data' =>  ArrayHelper::map(Building::find()->all(),'id','name'),
            'language' => 'en',
            'options' => ['placeholder' => 'Select building'],
            'pluginOptions' => [
            'allowClear' => true,
        ],
            'pluginEvents' => [
            'select2:select' => 'function() {$.post("index.php?r=student-booking/lists&id='.'"+$(this).val(),function(data){$("select#flat-id").html(data);});}',
         ] 
    ]); ?>
    
    <?= $form->field($model_flat, 'id')->dropDownList(    
        ArrayHelper::map(\backend\models\Flat::find()->all(),'id','number'),
        ['prompt' => 'Select flat']
    )?>
    
    <?= $form->field($model_room, 'id')->widget(Select2::classname(), 
        [ 
            'data' =>  ArrayHelper::map(\backend\models\Flat::find()->all(),'id','number'),
            'language' => 'en',
            'options' => ['placeholder' => 'Select flat'],
            'pluginOptions' => [
            //'allowClear' => true
        ],
    ]); ?>
    
    
    <div class="row">
        <div class="panel panel-default">
            <div class="panel-heading"><h5>Utility Kit</h5></div>
            <div class="panel-body">
                 <?php DynamicFormWidget::begin([
                    'widgetContainer' => 'dynamicform_wrapper', // required: only alphanumeric characters plus "_" [A-Za-z0-9_]
                    'widgetBody' => '.container-items', // required: css class selector
                    'widgetItem' => '.item', // required: css class
                    'limit' => 10, // the maximum times, an element can be cloned (default 999)
                    'min' => 1, // 0 or 1 (default 1)
                    'insertButton' => '.add-item', // css class
                    'deleteButton' => '.remove-item', // css class
                    'model' => $model_PHCW[0],
                    'formId' => 'dynamic-form',
                    'formFields' => [
                        'warehouse_id',
                        'condition_id',
                        'amount', 
                    ],
                ]); ?>

                <div class="container-items"><!-- widgetContainer -->
                <?php foreach ($model_PHCW as $i => $model_PHCW): ?>
                    <div class="item panel panel-default"><!-- widgetBody -->
                        <div class="panel-heading">
                            <h3 class="panel-title pull-left">Product</h3>
                            <div class="pull-right">
                                <button type="button" class="add-item btn btn-success btn-xs"><i class="glyphicon glyphicon-plus"></i></button>
                                <button type="button" class="remove-item btn btn-danger btn-xs"><i class="glyphicon glyphicon-minus"></i></button>
                            </div>
                            <div class="clearfix"></div>
                        </div>
                        <div class="panel-body">
                            <?php
                                // necessary for update action.
                                if (! $model_PHCW->isNewRecord) {
                                    echo Html::activeHiddenInput($model_PHCW, "[{$i}]product_id");
                                }
                            ?>
                            
                            <div class="row">
                                <div class="col-sm-6">
                                    <?= $form->field($model_PHCW, "[{$i}]warehouse_id")->dropDownList(    
                                        ArrayHelper::map(Warehouse::find()->all(),'id','address'),
                                        ['prompt' => 'Select warehouse']
                                   )?>
                                </div>
                                <div class="col-sm-6">
                                    <?= $form->field($model_PHCW, "[{$i}]product_id")->dropDownList(    
                                        ArrayHelper::map(Product::find()->all(),'id','name'),
                                        ['prompt' => 'Select product']
                                   )?>
                                </div>
                                <div class="col-sm-6">
                                   <?= $form->field($model_PHCW, "[{$i}]condition_id")->dropDownList(    
                                        ArrayHelper::map(Condition::find()->all(),'id','type'),
                                        ['prompt' => 'Select condition']
                                   )?>
                                </div>
                                 <div class="col-sm-6">
                                    <?= $form->field($model_PHCW, "[{$i}]amount")->textInput(['maxlength' => true]) ?>
                                </div>
                            </div><!-- .row -->
                        </div>
                    </div>
                <?php endforeach; ?>
                </div>
                <?php DynamicFormWidget::end(); ?>
            </div>
        </div>
    </div>
    
    
    <div class="form-group">
        <?= Html::submitButton($model->isNewRecord ? 'Create' : 'Update', ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
