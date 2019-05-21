<?php
    header('Content-Type: application/json');
    require('connect.php');

    $ret_data = ['success' => 'false'];

    $data = json_decode($_POST['data']);
    $_a_id = $data->_a_id;
    $athlete = $data->athlete_data;

    $query = "UPDATE `Athlete` SET
    `a_fname` = '".$athlete->_first_name."',
    `a_lname` = '".$athlete->_last_name."',
    `a_bodyweight` = '".$athlete->_bodyweight."',
    `a_gender` = '".$athlete->_gender."',
    `a_class` = '".$athlete->_body_class."'
    WHERE `Athlete`.`a_id` = '".$_a_id."'";

    if(mysqli_query($conn, $query)){
        $last_id = mysqli_insert_id($conn);
        $ret_data = ['success' => 'true'];
    }
    echo json_encode($ret_data);
 ?>
