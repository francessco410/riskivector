<?php

namespace backend\components;
use Yii;
use yii\base\Component;
use backend\models\Flat;
use backend\models\Room;
use backend\models\Tenant;
use backend\models\Person;
use backend\models\Student;

class RoomPicker extends Component{
    
    public function init_picker($id){
        $flats = Flat::find()
                ->where(['id' => $id])->one();
        $roomsCount = Room::find()
                ->where(['flat_id' => $flats->id])
                ->count();
        $rooms = Room::find()
                ->where(['flat_id' => $flats->id])
                ->all();
        echo '<div class="btn-group" data-toggle="buttons">';
        if($roomsCount > 0){
            foreach ($rooms as $room){
              
                $tenant= Tenant::find()->joinWith('tenantHasRooms')->where(['room_id'=>$room->id, 'check_out_date' => null])->orWhere("check_out_date<now()");
                $tenantCount=$tenant->count();
                $tenant=$tenant->all();

                if($tenantCount < $room->type){
                     echo '<label class="btn btn-success" id="avaible">'.
                          "<input type='radio' name='options' id='$room->id' autocomplete='off'>".$room->number;
                }else{
                    echo '<label class="btn btn-info" id="unavaible">'.
                          "<input type='radio' name='options' autocomplete='off'>".$room->number;
                }
                for($i=0;$i<$room->type;$i++){
                    if($tenantCount>$i){
                      $person= Person::find()->where(['id'=>$tenant[$i]->person_id])->one();
                      $student= Student::find()->where(['person_id'=>$person->id])->one();
                      echo "<h3>". $person->name." ".$person->surname."(".$person->sex.")</h3>".
                           "<span>".$person->country."</span>".
                              
                           (($student!=null)?"<span>".$student->course."</span>" : "");  
                    }
                    else
                    {
                        echo '<br><h3>Free Slot</h3><br>';  
                    }
                }
               echo '</label>';
            }
        }else{
            echo "<option> - </option>";
        }
        echo '</div>';
$script = <<<JS
$('#avaible').click(function(){
    var room_id = $('#avaible').find('input').attr('id');
    
    $("#room-id").val(room_id);
});
JS;
        echo '<script type="text/javascript">';
        echo $script;
        echo '</script>';

    }
}
