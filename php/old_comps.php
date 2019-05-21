<?php
    require('connect.php');

    $timezone = new DateTimeZone('Australia/Brisbane');
    $str_date = date('Y-m-d H:i:s a', time());
    $date = DateTime::createFromFormat('Y-m-d H:i:s a', $str_date, $timezone);
    $date->setTime(0,0,0);
    $time_stop = $date->format('Y-m-d H:i:s');

    //make querying
    $query = "SELECT * FROM Competition WHERE c_dateend > '.$time_stop.'";

    //run it
    $result = mysqli_query($conn, $query);

    //display data
    echo '<div class="row">';
    if (mysqli_num_rows($result) > 0) {
        while($row = mysqli_fetch_assoc($result)) {
            echo '<div class="col-sm-6">
              <div class="card">
                <div class="card-body">
                  <h5 class="card-title">'.$row["c_title"].'</h5>
                  <p class="card-text">['.$row["c_datestart"].' - '.$row["c_dateend"].'] '.$row["c_description"].'</p>
                  <a href="display_old_comp.php?id='.$row["c_id"].'" class="btn btn-primary disabled">See Competition</a>
                </div>
              </div>
            </div>';
        }
    }
    else{
        echo '<p class="text-center"> No old competitions to display. </p>';
    }
    echo '</div>';
?>
