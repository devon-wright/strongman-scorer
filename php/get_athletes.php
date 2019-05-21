<?php
    header('Content-Type: application/json');
    require('connect.php');

    $ret_data = ['success' => 'false'];

    //Get the comp data
    $data = json_decode($_POST['data']);
    $list_of_athletes = $data->_list_of_athletes;
    $athlete_ret_list = array(); // set as id:fname array

    $query = "SELECT a_id, a_fname, a_lname FROM Athlete WHERE a_id = '".$list_of_athletes[0]."'";
    //select all fnames matching the list of ids i have

    for($i = 1; $i < count($list_of_athletes); $i++){
        $query .= " OR a_id = '".$list_of_athletes[$i]."'";
    }

    $result = mysqli_query($conn, $query) or die(mysqli_error($conn));
    $count = mysqli_num_rows($result);

    if($count >= 1){
        while($row = mysqli_fetch_row($result)){
            $athlete_ret_list[] = array($row[1].", ".$row[2]);
        }
        $ret_data = ['success' => 'true', 'list_of_athletes' => $athlete_ret_list];
    }else{
        $ret_data = ['success' => 'false'];
    }
    echo json_encode($ret_data);
 ?>
