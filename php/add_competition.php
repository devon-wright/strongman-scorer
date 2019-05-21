<?php
    header('Content-Type: application/json');
    require('connect.php');

    $ret_data = ['success' => 'false'];

    //Get the comp data
    $data = json_decode($_POST['data']);
    $comp_data = $data->competition_data;

    $date_start = $comp_data->_start_date;
    $date_end = $comp_data->_end_date;

    //first do a select to see if the competition can be made for this day

    $query = "INSERT INTO `Competition` (`c_id`, `c_datestart`, `c_dateend`, `c_title`, `c_description`, `c_referee`, `c_scorer`) VALUES (NULL, '".$date_start."', '".$date_end."', '".$comp_data->_title."', '".$comp_data->_description."', '".$comp_data->_ref."', '".$comp_data->_scorer."'); SELECT SCOPE_IDENTITY()";

    if(mysqli_query($conn, $query)){
        $last_id = mysqli_insert_id($conn);
        $ret_data = ['success' => 'true', 'c_id' => $last_id];
    }

    echo json_encode($ret_data);

    /*{"competition_data":
        {"_start_date":"",
        "_end_date":"",
        "_title":"default value",
        "_description":"default value",
        "_ref":"default value",
        "_scorer":"default value"}}*/
?>
