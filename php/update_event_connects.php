<?php
    header('Content-Type: application/json');
    require('connect.php');

    $ret_data = ['success' => 'false'];

    //Get the comp data
    $data = json_decode($_POST['data']);
    $ci_data = $data->competes_in_data;

    $values_string = "";

    for($i = 0; $i < count($ci_data); $i++){
        $values_string .= "(".$ci_data[$i]->_ciid.", ".$ci_data[$i]->_eid.", ".$ci_data[$i]->_aid.", ".$ci_data[$i]->_value.", ".$ci_data[$i]->_points."),";
    }

    $values_string = substr($values_string, 0, -1);

    $query = "  INSERT INTO competes_in(compete_id, event_id, athlete_id, value, points)
                VALUES ".$values_string."
                ON DUPLICATE KEY
                UPDATE value=VALUES(value), points=VALUES(points)";

    if(mysqli_query($conn, $query)){
        $ret_data = ['success' => 'true'];
    }
    echo json_encode($ret_data);
 ?>
