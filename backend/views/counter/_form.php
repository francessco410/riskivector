<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use yii\helpers\ArrayHelper;
use backend\models\Flat;
use kartik\select2\Select2;
use amilna\elevatezoom\ElevateZoom;
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
<?php
//    $images = ['http://www.elevateweb.co.uk/wp-content/themes/radial/zoom/images/large/image1.jpg'];

    $images = ['/RiskiVector/backend/web/upload/large.jpeg'];
//    echo '<pre>';
//    print_r(Yii::$app->urlManager->baseUrl);
//    echo '</pre>';
//    die();
	echo ElevateZoom::widget([
 		'images'=>$images,
		'baseUrl'=>'@web/upload',
		'smallPrefix'=>'/small',
		'mediumPrefix'=>'/small',
	]);
//    $images= [
//		[	
//			'image'=>'backend/web/upload/large.jpeg',
//			'small'=>'backend/web/upload/small.jpeg',
//			'medium'=>'backend/web/upload/medium.jpeg'
//		],
//	
//	];
//
//	echo ElevateZoom::widget([
// 		'images'=>$images,		
//	]);
    
    ?>

    <?= $form->field($model, 'cheia_value')->textInput() ?>
   
    <?= $form->field($model, 'gas_total')->textInput() ?>

    <?= $form->field($model, 'comment')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'counter_photo_id')->textInput() ?>

    <div class="form-group">
        <?= Html::submitButton($model->isNewRecord ? 'Create' : 'Update', ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']) ?>
    </div>
     
    <?php ActiveForm::end(); ?>

</div>
