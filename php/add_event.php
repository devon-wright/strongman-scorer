<?php
    header('Content-Type: application/json');
    require('connect.php');

    $ret_data = ['success' => 'false'];

    //Get the comp data
    $data = json_decode($_POST['data']);
    $event_data = $data->event_data;
    $comp_data = $data->competition_data;

    $date_start = $event_data->_start_date;
    $date_end = $event_data->_end_date;

    $query = "INSERT INTO `Event` (`e_id`, `comp_id`, `e_name`, `e_type`, `e_datestart`, `e_dateend`) VALUES (NULL, '".$comp_data->_c_id."', '".$event_data->_event_name."', '".$event_data->_event_type."', '".$date_start."', '".$date_end."'); SELECT SCOPE_IDENTITY()";

    if(mysqli_query($conn, $query)){
        $last_id = mysqli_insert_id($conn);
        $ret_data = ['success' => 'true', 'e_id' => $last_id];
    }

    echo json_encode($ret_data);

    /*{"competition_data":
        {"_c_id":""},
    "event_data":
        {"_event_type":"default value",
        "_start_date":"",
        "_end_date":""}}*/
?>
