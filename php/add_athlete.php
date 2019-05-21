<?php
    header('Content-Type: application/json');
    require('connect.php');

    $ret_data = ['success' => 'false'];

    //Get the comp data
    $data = json_decode($_POST['data']);
    $athlete_data = $data->athlete_data;

    $query = "INSERT INTO `Athlete` (`a_id`, `a_fname`, `a_lname`, `a_bodyweight`, `a_gender`, `a_class`) VALUES (NULL, '".$athlete_data->_first_name."', '".$athlete_data->_last_name."', '".$athlete_data->_bodyweight."', '".$athlete_data->_gender."', '".$athlete_data->_body_class."'); SELECT SCOPE_IDENTITY()";

    if(mysqli_query($conn, $query)){
        $last_id = mysqli_insert_id($conn);
        $ret_data = ['success' => 'true', 'a_id' => $last_id.''];
    }

    echo json_encode($ret_data);

    /*
    {"athlete_data":
        {"_first_name":"default value",
        "_last_name":"default value",
        "_body_class":"default value",
        "_gender":"default value",
        "_bodyweight":"default value"}}*/
?>
