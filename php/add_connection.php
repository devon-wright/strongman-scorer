<?php
    header('Content-Type: application/json');
    require('connect.php');

    $ret_data = ['success' => 'false'];

    //Get the comp data
    $data = json_decode($_POST['data']);
    $e_id = $data->_e_id;
    $a_id = $data->_a_id;

    //Editing 'competes_in'
    //each athlete competes in mulitple events
    //-> LOOP athlete
    //  -> LOOP event
    //INSERT into competes_in (compete_id, event_id, athlete_id, value, points) VALUES (NULL, $array_of_events[$j], $array_of_athletes[$i], 0, 0)

    $query = "INSERT into competes_in (`compete_id`, `event_id`, `athlete_id`, `value`, `points`) VALUES (NULL, '".$e_id."', '".$a_id."', '0', '0')";

    if(mysqli_query($conn, $query)){
        $ret_data = ['success' => 'true'];
    }

    echo json_encode($ret_data);
?>
