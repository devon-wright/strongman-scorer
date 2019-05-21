<?php
    require('connect.php');

    /* ------- Init of data -------- */
    class Athlete{
        public $_name = "";
        private $_class = "";
        private $_values = array();
        private $_points = array();
        public $_total_points = -1;
        private $_position = -1;

        public function Athlete($name, $bodyweight, $value, $points){
            $this->_name = $name;
            $this->_bodyweight = $bodyweight;
            $this->_values[] = $value;
            $this->_points[] = $points;
            $this->_total_points = $points;
        }

        function addEventAndPoints($value, $points){
            $this->_values[] = $value;
            $this->_points[] = $points;
            $this->_total_points += $points;
        }

        function updatePosition($pos){
            $this->_position = $pos;
        }

        function printRow(){
            if($this->_position == 1){
                echo '<tr class="bg-success">';
            }
            else{
                echo '<tr>';
            }
            echo '<th>'.$this->_name.'</th><td>'.$this->_bodyweight.'</td>';
            for($i = 0; $i < count($this->_values); $i++){
                echo '<td>'.$this->_values[$i].'</td><td>'.$this->_points[$i].'</td>';
            }
            echo '<td>'.$this->_total_points.'</td><td>'.$this->_position.'</td>';
            echo '</tr>';
        }
    }

    $list_of_events = array();
    $count = 0;
    $list_of_athletes = array();

    $title_of_comp = "";
    $caption_of_comp = "";
    $display_date_start = '';
    $display_date_end = '';

    $display = true;

    /* ------- Start of querying -------- */

    //2018-10-25 16:13:00
    //10/25/2018 4:27 PM <- format of timepicker

    $now_datetime_obj = new DateTime(null, new DateTimeZone('Pacific/Auckland'));
    $current_datetime = $now_datetime_obj->format('Y-m-d H:i:s');

    $now_datetime_obj->setTime(0, 0);
    $start_datetime = $now_datetime_obj->format('Y-m-d H:i:s');

    $now_datetime_obj->setTime(23, 59);
    $end_datetime = $now_datetime_obj->format('Y-m-d H:i:s');

    $query = "SELECT e.e_type, e.e_name FROM Event e WHERE e.e_datestart >= '".$start_datetime."' AND e.e_datestart < '".$end_datetime."';";

    $query .= "SELECT a.a_fname, a.a_bodyweight, e.e_type, ci.value, ci.points FROM Event e, Athlete a, competes_in ci WHERE e.e_id = ci.event_id AND a.a_id = ci.athlete_id AND e.e_datestart >= '".$start_datetime."' AND e.e_datestart < '".$end_datetime."' ORDER BY ci.compete_id ASC;";

    $query .= "SELECT * FROM Competition WHERE c_datestart <= '".$current_datetime."' AND c_dateend >= '".$current_datetime."'";

    if(mysqli_multi_query($conn, $query)){
        //Load in list of events
        if($result = mysqli_store_result($conn)){
            while($row = mysqli_fetch_row($result)){
                $list_of_events[] = $row[0]."<br /><small>".$row[1]."</small>";
                $count++;
            }

            if($count == 0){
                $display = false;
            }
            mysqli_free_result($result);
            mysqli_next_result($conn);
        }

        //Load in the list of athletes
        if($result = mysqli_store_result($conn)){
            $curr_name = "";
            $curr_pos = 0;
            while($row = mysqli_fetch_row($result)){
                //If new name
                if($curr_name != $row[0]){

                    //GO through all ahtletes->name
                    //if no matches then create a new athletes
                    //else add to that athletes
                    $matched = false;
                    foreach ($list_of_athletes as $athlete) {
                        if($athlete->_name == $row[0]){
                            $athlete->addEventAndPoints($row[3], $row[4]);
                            $matched = true;
                        }
                    }

                    if($matched == false){
                        //set the name
                        $curr_name = $row[0];
                        //create new athlete object
                        $curr_pos++;
                        //add on the first event data for that athlete object
                        $temp_athlete = new Athlete($row[0], $row[1], $row[3], $row[4]);
                        $list_of_athletes[] = $temp_athlete;
                    }
                }
                else{
                    //add on the extra event data to the latest object
                    $list_of_athletes[count($list_of_athletes) -1]->addEventAndPoints($row[3], $row[4]);
                }
            }

            //order the athletes
            //and set their positions
            //arsort($list_of_athletes);
            usort($list_of_athletes, function($a, $b){
                return $a->_total_points <= $b->_total_points;
            });
            for($i = 0; $i < count($list_of_athletes); $i++){
                $list_of_athletes[$i]->updatePosition($i + 1);
            }

            mysqli_free_result($result);
            mysqli_next_result($conn);
        }

        //Load in the competiton details
        if($result = mysqli_store_result($conn)){
            while($row = mysqli_fetch_row($result)){
                $title_of_comp = $row[3];
                $caption_of_comp = $row[4];
                $display_date_start = $row[1];
                $display_date_end = $row[2];
            }
            mysqli_free_result($result);
        }

        if($title_of_comp == null){
            $display = false;
        }

        if($display == true){
            /* ------ printing Competion Details ------- */
            echo '<h3><strong>'.$title_of_comp.'</strong></h3>';
            echo '<h5>'.$caption_of_comp.'</h5>';
            echo '<h6><i>'.date("jS \of F Y", strtotime($display_date_start)).' - '.date("jS \of F Y", strtotime($display_date_end)).'</i></h6>';

            echo '<div id class="container-fluid">';
            echo '  <div class="row">';

            /* ------ Printing table ------ */
            echo '<table class="table table-sm table-bordered table-hover">';
            echo '  <thead class="thead-dark">';
            echo '      <tr>';
            echo '          <th colspan="2" scope="col">Athlete</th>'; // athelte
            foreach($list_of_events as $event){
                echo '      <th colspan="2" scope="col">'.$event.'</th>'; // events
            }
            echo '          <th colspan="2" scope="col"></th>'; //final points + pos
            echo '      </tr>';
            echo '  </thead>';
            echo '  <thead class="thead-dark">';
            echo '      <tr>';
            echo '          <th scope="col">Name</th>';
            echo '          <th scope="col">Weight</th>';
            for($i = 0; $i < $count; $i++){
                echo '      <th scope="col">Value</th>'; // Needs to have a DB value with name
                echo '      <th scope="col">Points</th>';
            }
            echo '          <th scope="col">Total Points</th>';
            echo '          <th scope="col">Position</th>';
            echo '      </tr>';
            echo '  </thead>';

            echo '<tbody>';
            foreach($list_of_athletes as $athlete){
                $athlete->printRow();
            }
            echo '</tbody>';
            echo '</table>';
        }
        else{
            echo '<p class="text-center"> No events on at this time. Check back later </p>';
        }
    }

    if($display){
        echo '<a href="../fullscoreboard.php"><button type="button" class="btn btn-primary rounded-0" > Goto Fullscreen </button></a>';
    }
    echo '</div>
    </div>';

?>
