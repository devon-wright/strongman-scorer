<?php
    header('Content-Type: application/json');
    require('connect.php');

    $ret_data = ['success' => 'false'];

    //Get the comp data
    $data = json_decode($_POST['data']);
    $selected_athlete = $data->_selected_athlete;

    $query = "DELETE FROM Athlete WHERE a_id = ".$selected_athlete;

    if(mysqli_query($conn, $query)){
        $ret_data = ['success' => 'true', 'a_id' => $selected_athlete];
    }

    echo json_encode($ret_data);
 ?>
