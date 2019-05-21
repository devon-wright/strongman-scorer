<?php
    header('Content-Type: application/json');
    require('connect.php');

    $ret_data = ['success' => 'false'];

    //Get the comp data
    $data = json_decode($_POST['data']);
    $_c_id = $data->_c_id;
    $comp = $data->competition_data;

    $date_start = $comp->_start_date;
    $date_end = $comp->_end_date;

    $query = "UPDATE `Competition` SET
    `c_datestart` = '".$date_start."',
    `c_dateend` = '".$date_end."',
    `c_title` = '".$comp->_title."',
    `c_description` = '".$comp->_description."',
    `c_referee` = '".$comp->_ref."',
    `c_scorer` = '".$comp->_scorer."'
    WHERE `Competition`.`c_id` = '".$_c_id."'";

    if(mysqli_query($conn, $query)){
        $last_id = mysqli_insert_id($conn);
        $ret_data = ['success' => 'true'];
    }
    echo json_encode($ret_data);
 ?>
