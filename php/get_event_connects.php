<?php
    header('Content-Type: application/json');
    require('connect.php');

    $ret_data = ['success' => 'false'];

    //Get the comp data
    $data = json_decode($_POST['data']);
    $e_id = $data->_e_id;

    $query = "SELECT * FROM competes_in WHERE event_id = '".$e_id."'";

    $result = mysqli_query($conn, $query) or die(mysqli_error($conn));
    $count = mysqli_num_rows($result);

    if($count >= 1){
        while($row = mysqli_fetch_row($result)){
            $connect_ret_list[] = array($row[0], $row[1], $row[2], $row[3], $row[4]);
        }
        $ret_data = ['success' => 'true', 'list_of_connects' => $connect_ret_list];
    }else{
        $ret_data = ['success' => 'false'];
    }
    echo json_encode($ret_data);
 ?>
