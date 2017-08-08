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
    <?php  $flats = Flat::find()
                ->one();
        $roomsCount = backend\models\Room::find()
                ->where(['flat_id' => $flats->id])
                ->count();
        $rooms = backend\models\Room::find()
                ->where(['flat_id' => $flats->id])
                ->all();
        echo '<div class="btn-group" data-toggle="buttons">';
        if($roomsCount > 0){
            foreach ($rooms as $room){
              
                $tenant= backend\models\Tenant::find()->joinWith('tenantHasRooms')->where(['room_id'=>$room->id]);
                $tenantCount=$tenant->count();
                $tenant=$tenant->all();
//                echo '<pre>';
//                print_r($tenant[0]->person_id);
//                echo '</pre>';
//                die();
                //echo "<option value='".$flat->id."'>".$flat->number."</option>";
                echo '<label class="btn btn-info">'.
                      "<input type='radio' name='options' id='option.'$room->id'.' autocomplete='off' > $room->number";
                for($i=0;$i<$room->type;$i++){
                    if($tenantCount>$i){
                      $person= backend\models\Person::find()->where(['id'=>$tenant[$i]->person_id])->one();
                      $student= backend\models\Student::find()->where(['person_id'=>$person->id])->one();
                      echo "<br><h1>". $person->name." ".$person->surname."(".$person->sex.")".
                           "<br>".$person->country."<br>".
                              
                           (($student!=null)?$student->course." ,".$student->home_university:" ").
                           "</h1><br>";     
                    }
                    else
                    {
                        echo '<br><h1>Free Slot</h1><br>';  
                    }
                }
                echo '</label>';
            }
        }else{
            echo "<option> - </option>";
        }
        echo '</div>';
        ?>
    
    
    <div class="form-group">
        <?= Html::submitButton($model->isNewRecord ? 'Create' : 'Update', ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
