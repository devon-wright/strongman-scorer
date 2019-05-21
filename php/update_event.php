<?php
    header('Content-Type: application/json');
    require('connect.php');

    $ret_data = ['success' => 'false'];

    //Get the comp data
    $data = json_decode($_POST['data']);
    $_e_id = $data->_e_id;
    $event = $data->event_data;

    $date_start = $event->_start_date;
    $date_end = $event->_end_date;

    $query = "UPDATE `Event` SET
    `e_datestart` = '".$date_start."',
    `e_dateend` = '".$date_end."',
    `e_name` = '".$event->_event_name."',
    `e_type` = '".$event->_event_type."'
    WHERE `Event`.`e_id` = '".$_e_id."'";

    if(mysqli_query($conn, $query)){
        $last_id = mysqli_insert_id($conn);
        $ret_data = ['success' => 'true'];
    }
    echo json_encode($ret_data);
 ?>
