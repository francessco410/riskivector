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
              
                $tenant= backend\models\Tenant::find()->joinWith('tenantHasRooms')->where(['room_id'=>$room->id])->count();
                //echo "<option value='".$flat->id."'>".$flat->number."</option>";
                echo '<label class="btn btn-primary">'.
                      "<input type='radio' name='options' id='option.'$room->id'.' autocomplete='off'  > $room->number";
                for($i=0;$i<$room->type;$i++){
                    if($tenant>=$i){
                      echo '<br><span class="glyphicon glyphicon-user "></span><br>';     
                    }
                    else
                    {
                        echo '<br><span class="glyphicon glyphicon-ok "></span><br>';  
                    }
                }
                echo '</label>';
            }
        }else{
            echo "<option> - </option>";
        }
        echo '</div>';
        ?>