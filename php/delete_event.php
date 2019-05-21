<?php
    header('Content-Type: application/json');
    require('connect.php');

    $ret_data = ['success' => 'false'];

    //Get the comp data
    $data = json_decode($_POST['data']);
    $selected_event = $data->_selected_event;

    $query = "DELETE FROM Event WHERE e_id = ".$selected_event;

    if(mysqli_query($conn, $query)){
        $ret_data = ['success' => 'true'];
    }

    echo json_encode($ret_data);
 ?>
