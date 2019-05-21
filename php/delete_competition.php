<?php
    header('Content-Type: application/json');
    require('connect.php');

    $ret_data = ['success' => 'false'];

    //Get the comp data
    $data = json_decode($_POST['data']);
    $selected_competition = $data->_selected_competition;

    $query = "DELETE c FROM Competition c WHERE c.c_id = '".$selected_competition."'";

    if(mysqli_query($conn, $query)){
        $ret_data = ['success' => 'true'];
    }

    echo json_encode($ret_data);
 ?>
