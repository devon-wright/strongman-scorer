<?php
    //include("php/connects/requires_login.php");

    include("php/connects/header.php");
    include("php/connects/nav.php");
    require('php/connect.php');
?>

<?php
    //objects to store comp/events/Athletes
    class Competition{
        public $_cid = -1; //if -1 then we wil add this to database, else update it
        private $_title = "";
        private $_description = "";
        private $_startdate = "";
        private $_enddate = "";
        private $_referee = "";
        private $_scorer = "";

        public function Competition($title, $description, $startdate, $enddate, $referee, $scorer){
            $this->_title = $title;
            $this->_description = $description;
            $this->_startdate = $startdate;
            $this->_enddate = $enddate;
            $this->_referee = $referee;
            $this->_scorer = $scorer;
        }

        public function setCID($c_id){
            $this->_cid = $c_id;
        }

        public function competitionToOption(){
            echo '<option value="'.$this->_cid.'">'.$this->_title.'</option>';
        }

        public function printCompetition(){
            echo '
                <form id="competition-form" class="border border-secondary" method="POST">
                    <div class="form-row">
                        <div class="col-md-12">
                            <p class="h2 text-center">Competition</p>
                        </div>
                    </div>

                    <div class="form-row">
                        <div class="form-group col-md-4">
                            <label for="comp-titleinput">Title: </label>
                            <input type="text" class="form-control" id="comp-titleinput" placeholder="Enter Title" name="title" value="'.$this->_title.'">
                        </div>

                        <div class="form-group col-md-4">
                            <label for="comp-refereeinput">Referee: </label>
                            <input type="text" class="form-control" id="comp-refereeinput" placeholder="Enter Referee" name="referee" value="'.$this->_referee.'">
                        </div>

                        <div class="form-group col-md-4">
                            <label for="comp-scorerinput">Scorer: </label>
                            <input type="text" class="form-control" id="comp-scorerinput" placeholder="Enter Scorer" name="scorer" value="'.$this->_scorer.'">
                        </div>
                    </div>

                    <div class="form-row">
                        <div class="form-group col-md-6">
                            <label for="comp-datetimepicker1">Start date: </label>
                            <div class="input-group date" id="comp-datetimepicker1" data-target-input="nearest">
                                <input type="text" class="form-control comp-datetimepicker1-input" data-target="#comp-datetimepicker1" id="comp-datetimepicker1-input" placeholder="Enter start date -->" value="'.$this->_startdate.'"/>
                                <div class="input-group-append" data-target="#comp-datetimepicker1" data-toggle="datetimepicker">
                                    <div class="input-group-text"><i class="fa fa-calendar"></i></div>
                                </div>
                            </div>
                        </div>

                        <div class="form-group col-md-6">
                            <label for="comp-datetimepicker2">End date: </label>
                            <div class="input-group date" id="comp-datetimepicker2" data-target-input="nearest">
                                <input type="text" class="form-control datetimepicker-input" data-target="#comp-datetimepicker2" id="comp-datetimepicker2-input" placeholder="Enter end date -->" value="'.$this->_enddate.'"/>
                                <div class="input-group-append" data-target="#comp-datetimepicker2" data-toggle="datetimepicker">
                                    <div class="input-group-text"><i class="fa fa-calendar"></i></div>
                                </div>
                            </div>
                        </div>

                    </div>

                    <div class="form-row">
                        <div class="form-group col-md-12">
                            <label for="comp-descriptioninput">Description: </label>
                            <input type="text" class="form-control" id="comp-descriptioninput" placeholder="Enter Decription" name="description" value="'.$this->_description.'">
                        </div>
                    </div>

                    <div class="btn-group" role="group">
                        <button type="submit" id="comp-update-button" value="'.$this->_cid.'" class="btn btn-secondary btn-warning"><i class="fas fa-redo"></i> Update</button>
                        <button type="submit" id="comp-delete-button" value="'.$this->_cid.'" class="btn btn-secondary btn-danger"><i class="fas fa-times"></i> Delete</button>
                    </div>
                </form>';
                echo '<br />';
        }

        public function createDataArray(){
            return array(_cid => $_cid,
                        _title => $_title,
                        _description => $_description,
                        _startdate => $_startdate,
                        _enddate => $_enddate,
                        _referee => $_referee,
                        _scorer => $_scorer);
        }
    }

    class Event{
        public $_eid = -1; //if -1 then we wil add this to database, else update it
        private $_name = "";
        private $_type = "";
        private $_startdate = "";
        private $_enddate = "";
        public $_athletes = array();

        public function Event($name, $type, $startdate, $enddate){
            $this->_name = $name;
            $this->_type = $type;
            $this->_startdate = $startdate;
            $this->_enddate = $enddate;
        }

        public function setEID($e_id){
            $this->_eid = $e_id;
        }

        public function addAthlete($athlete){
            $this->_athletes[] = $athlete;
        }

        function printEvent(){
            echo '  <form class="event-class" id="event-form" method="POST">
                        <div class="form-row">
                            <div class="form-group col-md-2">
                              <label for="event-typeinput-curr">Event Name: </label>
                              <input type="text" class="form-control event-nameinput-curr" placeholder="Enter Name" name="name" value="'.$this->_name.'">
                            </div>

                            <div class="form-group col-md-2">
                              <label for="event-typeinput-curr">Event Type: </label>
                              <select class="form-control event-typeinput-curr">';

                              if($this->_type == "Fastest Time"){
                                  echo '<option value="Fastest Time" selected>Fastest Time</option>';
                              }
                              else{
                                  echo '<option value="Fastest Time">Fastest Time</option>';
                              }

                              if($this->_type == "Longest Time"){
                                  echo '<option value="Longest Time" selected>Longest Time</option>';
                              }
                              else{
                                  echo '<option value="Longest Time">Longest Time</option>';
                              }

                              if($this->_type == "Most Reps"){
                                  echo '<option value="Most Reps" selected>Most Reps</option>';
                              }
                              else{
                                  echo '<option value="Most Reps">Most Reps</option>';
                              }

                              if($this->_type == "Most Weight"){
                                  echo '<option value="Most Weight" selected>Most Weight</option>';
                              }
                              else{
                                  echo '<option value="Most Weight">Most Weight</option>';
                              }

                              if($this->_type == "Most Distance"){
                                  echo '<option value="Most Distance" selected>Most Distance</option>';
                              }
                              else{
                                  echo '<option value="Most Distance">Most Distance</option>';
                              }
                               echo '</select>
                            </div>

                            <!-- start Date start -->
                            <div class="form-group col-md-3">
                                <label for="event-datetimepicker1-dyn-id">Start date: </label>
                                <div class="input-group date event-datetimepicker1-dyn" data-target-input="nearest" id="event-datetimepicker1-dyn-id">
                                    <input type="text" class="form-control datetimepicker-input start-date" data-target="" value="'.$this->_startdate.'"/>
                                    <div class="input-group-append" data-target="" data-toggle="datetimepicker">
                                        <div class="input-group-text"><i class="fa fa-calendar"></i></div>
                                    </div>
                                </div>
                            </div>

                            <!-- end Date start -->
                            <div class="form-group col-md-3">
                                <label for="event-datetimepicker2-dyn-id">End date: </label>
                                <div class="input-group date event-datetimepicker2-dyn" data-target-input="nearest" id="event-datetimepicker2-dyn-id">
                                    <input type="text" class="form-control datetimepicker-input end-date" data-target="" value="'.$this->_enddate.'"/>
                                    <div class="input-group-append" data-target="" data-toggle="datetimepicker">
                                        <div class="input-group-text"><i class="fa fa-calendar"></i></div>
                                    </div>
                                </div>
                            </div>


                            <div class="col-md btn-group-vertical">
                                <button what="update" type="submit" value="'.$this->_eid.'" class="btn btn-secondary btn-warning event-update-button btn-sm"><i class="fas fa-redo"></i></button>

                                <button what="delete" type="submit" value="'.$this->_eid.'" class="btn btn-secondary btn-danger event-delete-button btn-sm"><i class="fas fa-times"></i></button>
                            </div>
                        </div>
                    </form>';
        }

        public function createDataArray(){
            $athlete_array = array();

            foreach ($_athletes as $athlete) {
                $athlete_array[] = $athlete->createDataArray();
            }

            return array(_eid => $_eid,
                        _name => $_name,
                        _type => $_type,
                        _startdate => $_startdate,
                        _enddate => $_enddate,
                        _athletes => $athlete_array);
        }
    }

    class Athlete{
        public $_aid = -1; //if -1 then we wil add this to database, else update it
        public $_fname = "";
        public $_lname = "";
        private $_class = "";
        private $_gender = "";
        private $_bodyweight = "";
        private $_competes_in_score = null;

        public function Athlete($fname, $lname, $class, $gender, $bodyweight){
            $this->_fname = $fname;
            $this->_lname = $lname;
            $this->_class = $class;
            $this->_gender = $gender;
            $this->_bodyweight = $bodyweight;
            $this->_competes_in_score = new Compete_In(-1, 0, 0);
        }

        public function setAID($a_id){
            $this->_aid = $a_id;
        }

        public function setPointsConnection($ci_id, $e_id, $value, $points){
            $this->_competes_in_score->_ciid = $ci_id;
            $this->_competes_in_score->_eid = $e_id;
            $this->_competes_in_score->_value = $value;
            $this->_competes_in_score->_points = $points;
        }

        public function updatePoints($value, $points){
            $this->_competes_in_score->_value = $value;
            $this->_competes_in_score->_points = $points;
        }

        public function printAthlete(){
            echo '<div class="row">';

            echo '  <form id="athlete-form" class="col-sm-9 athlete-class" method="POST">
                        <div class="form-row">
                            <div class="form-group col-md-2">
                                <label for="athlete-firstnameinput-curr">Firstname: </label>
                                <input type="text" class="form-control athlete-firstnameinput-curr" placeholder="Enter Firstname" name="firstname" value="'.$this->_fname.'">
                            </div>

                            <div class="form-group col-md-2">
                                <label for="athlete-lastnameinput-curr">lastname: </label>
                                <input type="text" class="form-control athlete-lastnameinput-curr" placeholder="Enter Lastname" name="lastname"  value="'.$this->_lname.'">
                            </div>

                            <div class="form-group col-md-2">
                                <label for="athlete-classinput-curr">class: </label>
                                <select class="form-control athlete-classinput-curr">';

                                if($this->_class == "U65 Women"){
                                    echo '<option value="U65 Women" selected>U65 Women</option>';
                                }
                                else{
                                    echo '<option value="U65 Women">U65 Women</option>';
                                }
                                if($this->_class == "U82 Women"){
                                    echo '<option value="U82 Women" selected>U82 Women</option>';
                                }
                                else{
                                    echo '<option value="U82 Women">U82 Women</option>';
                                }
                                if($this->_class == "Open Women"){
                                    echo '<option value="Open Women" selected>Open Women</option>';
                                }
                                else{
                                    echo '<option value="Open Women">Open Women</option>';
                                }
                                if($this->_class == "U80 Men"){
                                    echo '<option value="U80 Men" selected>U80 Men</option>';
                                }
                                else{
                                    echo '<option value="U80 Men">U80 Men</option>';
                                }
                                if($this->_class == "U90 Men"){
                                    echo '<option value="U90 Men" selected>U90 Men</option>';
                                }
                                else{
                                    echo '<option value="U90 Men">U90 Men</option>';
                                }
                                if($this->_class == "U105 Men"){
                                    echo '<option value="U105 Men" selected>U105 Men</option>';
                                }
                                else{
                                    echo '<option value="U105 Men">U105 Men</option>';
                                }
                                if($this->_class == "Open Men"){
                                    echo '<option value="Open Men" selected>Open Men</option>';
                                }
                                else{
                                    echo '<option value="Open Men">Open Men</option>';
                                }
                                 echo '</select>
                            </div>

                            <div class="form-group col-md-2">
                                <label for="athlete-genderinput-curr">gender: </label>
                                <select class="form-control athlete-genderinput-curr">';

                                if($this->_gender == "Female"){
                                    echo '<option value="Female" selected>Female</option>';
                                }
                                else{
                                    echo '<option value="Female">Female</option>';
                                }

                                if($this->_gender == "Male"){
                                    echo '<option value="Male" selected>Male</option>';
                                }
                                else{
                                    echo '<option value="Male">Male</option>';
                                }

                                if($this->_gender == "Other"){
                                    echo '<option value="Other" selected>Other</option>';
                                }
                                else{
                                    echo '<option value="Other">Other</option>';
                                }
                                 echo '</select>
                            </div>

                            <div class="form-group col-md-2">
                                <label for="athlete-bodyweightinput-curr">bodyweight: </label>
                                <input type="text" class="form-control athlete-bodyweightinput-curr" placeholder="Enter Body Weight" name="bodyweight"  value="'.$this->_bodyweight.'">
                            </div>

                            <div class="btn-group-vertical col-md" role="group">
                                <button what="update" type="submit" value="'.$this->_aid.'" class="btn btn-secondary btn-warning athlete-update-button btn-sm"><i class="fas fa-redo"></i></button>

                                <button what="delete" type="submit" value="'.$this->_aid.'" class="btn btn-secondary btn-danger athlete-delete-button btn-sm"><i class="fas fa-times"></i></button>
                            </div>
                        </div>
                    </form>';

            $this->_competes_in_score->printCompetesIn();

            echo '</div>';
        }

        public function createDataArray(){
            return array(_aid => $_aid,
                        _fname => $_title,
                        _lname => $_description,
                        _class => $_startdate,
                        _gender => $_enddate,
                        _bodyweight => $_referee);
        }
    }

    class Compete_In{
        public $_ciid;
        public $_value;
        public $_points;
        public $_eid;

        public function Compete_In($e_id, $value, $points){
            $this->_eid = $e_id;
            $this->_value = $value;
            $this->_points = $points;
        }

        public function setCIID($ci_id){
            $this->_ciid = $ci_id;
        }

        public function printCompetesIn(){
            echo '<form id="competes-in-form" class="col-sm-2 competesin-class" method="POST">
                        <div class="form-row">
                            <div class="form-group col-md-8">
                                <label for="competes-in-valueinput">Value: </label>
                                <input type="text" class="form-control competes-in-valueinput" placeholder="Enter Value" name="value" value="'.$this->_value.'">
                            </div>

                            <input type="hidden" class="competes-in-eid" name="eid" value="'.$this->_eid.'">

                            <div class="btn-group-vertical col-md" role="group">
                                <button type="submit" value="'.$this->_ciid.'" class="btn btn-secondary btn-warning competes-in-update-button btn-sm"><i class="fas fa-redo"></i></button>
                            </div>
                        </div>
                    </form>';
        }

        public function createDataArray(){
            return array(_ciid => $_ciid,
                        _value => $_value,
                        _points => $_points);
        }
    }

    //variables
    $list_of_comps = array();
    $competition = NULL;
    $events = array();
    $exisiting_athletes = array();
    $print_default = true;
    $competition_set = false;

    //query and load in current comp/events/athletes (if given a c_id via post)
    if(isset($_GET['c_id'])){
        if($_GET['c_id']){
            //load in the comps/events/athletes to the objects
            $query = "SELECT * FROM Competition;";
            $query .= "SELECT * FROM Competition WHERE c_id = '".$_GET['c_id']."';";
            $query .= "SELECT * FROM Event WHERE comp_id = '".$_GET['c_id']."';";
            $query .= "SELECT DISTINCT a.*, e.e_id FROM Athlete a, Event e, Competition c, competes_in ci WHERE c.c_id = e.comp_id AND e.e_id = ci.event_id AND ci.athlete_id = a.a_id AND c.c_id = '".$_GET['c_id']."';";
            $query .= "SELECT ci.* FROM competes_in ci, Event e, Competition c WHERE c.c_id = e.comp_id AND e.e_id = ci.event_id AND c.c_id = '".$_GET['c_id']."'";

            if(mysqli_multi_query($conn, $query)){
                //load in all competitions
                if($result = mysqli_store_result($conn)){
                    while($row = mysqli_fetch_row($result)){
                        $tmp_comp = new Competition($row[3], $row[4], $row[1], $row[2], $row[5], $row[6]);
                        $tmp_comp->setCID($row[0]);
                        $list_of_comps[] = $tmp_comp;
                    }
                    //Move to next space
                    mysqli_free_result($result);
                    mysqli_next_result($conn);
                }

                //Load in Competition (always just one)
                //use c_id
                if($result = mysqli_store_result($conn)){
                    //Get results of query
                    while($row = mysqli_fetch_row($result)){
                        //$title, $description, $startdate, $enddate, $referee, $scorer
                        $competition = new Competition($row[3], $row[4], $row[1], $row[2], $row[5], $row[6]);
                        //set c_id
                        $competition->setCID($row[0]);
                        $competition_set = true;
                        $print_default = false;
                    }

                    //Move to next space
                    mysqli_free_result($result);
                    mysqli_next_result($conn);
                }

                //Load in Events
                //using c_id
                if($result = mysqli_store_result($conn)){
                    //Get results of query
                    while($row = mysqli_fetch_row($result)){
                        //$name, $type, $startdate, $enddate
                        $tmp_event = new Event($row[2], $row[3], $row[4], $row[5]);
                        //set e_id
                        $tmp_event->setEID($row[0]);

                        $events[] = $tmp_event;
                    }

                    //Move to next space
                    mysqli_free_result($result);
                    mysqli_next_result($conn);
                }

                //Load in Athletes
                //connect athlete to event to c_id
                //then create athlete from the data (remember
                //to get unique a_id)
                if($result = mysqli_store_result($conn)){
                    //Get results of query
                    while($row = mysqli_fetch_row($result)){
                        //$fname, $lname, $class, $gender, $bodyweight
                        $tmp_athlete = new Athlete($row[1], $row[2], $row[5], $row[4], $row[3]);

                        $tmp_e_id = $row[6];

                        $tmp_athlete->setAID($row[0]);

                        //stop duplicate people from being added
                        $is_found = false;

                        foreach ($exisiting_athletes as $athlete) {
                            if($athlete->_aid == $row[0]){
                                $is_found = true;
                                break;
                            }
                        }

                        if($is_found == false){
                            $exisiting_athletes[] = $tmp_athlete;
                        }
                        //go through each event and add athlete to the right event
                        foreach ($events as $event) {
                            if($event->_eid == $tmp_e_id){
                                $event->addAthlete($tmp_athlete);
                            }
                        }
                    }

                    //Move to next space
                    mysqli_free_result($result);
                    mysqli_next_result($conn);
                }

                //get the values and points for each athlete
                //Each entry has e_id, a_id
                //for the event -> for the athlete -> update the ciid, value and points
                if($result = mysqli_store_result($conn)){
                    //Get results of query
                    while($row = mysqli_fetch_row($result)){
                        foreach ($events as $event) {
                            if($event->_eid == $row[1]){
                                foreach ($event->_athletes as $athlete) {
                                    if($athlete->_aid == $row[2]){
                                        $athlete->setPointsConnection($row[0], $event->_eid, $row[3], $row[4]);
                                    }
                                }
                            }
                        }
                    }

                    mysqli_free_result($result);
                }
            }
        }
        else{
            $competition_set = false;
            $print_default = true;
        }
    }
    else{
        $query = "SELECT * FROM Competition;";

        if(mysqli_multi_query($conn, $query)){
            if($result = mysqli_store_result($conn)){
                while($row = mysqli_fetch_row($result)){
                    $tmp_comp = new Competition($row[3], $row[4], $row[1], $row[2], $row[5], $row[6]);
                    $tmp_comp->setCID($row[0]);
                    $list_of_comps[] = $tmp_comp;
                }
                //Move to next space
                mysqli_free_result($result);
            }
        }

        //Just print the default adding forms
        $competition_set = false;
        $print_default = true;
    }

echo '<body><div id="body-add">';
    //display
    //directional text Here
    echo '<div class="alert alert-warning alert-dismissible fade show" role="alert">
      <h4 class="alert-heading"> How to use this page: </h4>
      <p> <strong> Remember to only update one value at a time! OR Update all values by clicking the "Update All" Button at the bottom of the page</strong></p>
      <button type="button" class="close" data-dismiss="alert" aria-label="Close">
        <span aria-hidden="true">&times;</span>
      </button>
    </div>';


    if(!$print_default){
        //use the comp objects data here
        $competition->printCompetition();//
    }
    else{
        echo '
            <form id="ex-competition-form" class="border border-secondary" method="POST">
                <div class="form-row">
                    <div class="col-md-12">
                        <p class="h2 text-center">Load Exisiting Competition</p>
                    </div>
                </div>

                <select class="form-control form-control-sm" id="competition-addexisiting-select">
                    <option value="none"> Select Exisiting Competition... </option> ';
                foreach ($list_of_comps as $comp) {
                    $comp->competitionToOption();
                }
                echo '</select>

                <button type="button" id="comp-load-button" class="btn btn-primary">load Competition</button>
            </form>

            <form id="competition-form" class="border border-secondary" method="POST">
                <div class="form-row">
                    <div class="col-md-12">
                        <p class="h2 text-center">New Competition</p>
                    </div>
                </div>

                <div class="form-row">
                    <div class="form-group col-md-4">
                        <label for="comp-titleinput">Title: </label>
                        <input type="text" class="form-control form-control-sm" id="comp-titleinput" placeholder="Enter Title" name="title">
                    </div>

                    <div class="form-group col-md-4">
                        <label for="comp-refereeinput">Referee: </label>
                        <input type="text" class="form-control form-control-sm" id="comp-refereeinput" placeholder="Enter Referee" name="referee">
                    </div>

                    <div class="form-group col-md-4">
                        <label for="comp-scorerinput">Scorer: </label>
                        <input type="text" class="form-control form-control-sm" id="comp-scorerinput" placeholder="Enter Scorer" name="scorer">
                    </div>
                </div>

                <div class="form-row">
                    <div class="form-group col-md-6">
                        <label for="comp-datetimepicker1">Start date: </label>
                        <div class="input-group date" id="comp-datetimepicker1" data-target-input="nearest">
                            <input type="text" class="form-control datetimepicker-input" data-target="#comp-datetimepicker1" id="comp-datetimepicker1-input" placeholder="Enter start date -->"/>
                            <div class="input-group-append" data-target="#comp-datetimepicker1" data-toggle="datetimepicker">
                                <div class="input-group-text"><i class="fa fa-calendar">Click Here</i></div>
                            </div>
                        </div>
                    </div>


                    <div class="form-group col-md-6">
                        <label for="comp-datetimepicker2">End date: </label>
                        <div class="input-group date" id="comp-datetimepicker2" data-target-input="nearest">
                            <input type="text" class="form-control datetimepicker-input" data-target="#comp-datetimepicker2" id="comp-datetimepicker2-input" placeholder="Enter end date -->"/>
                            <div class="input-group-append" data-target="#comp-datetimepicker2" data-toggle="datetimepicker">
                                <div class="input-group-text"><i class="fa fa-calendar">Click Here</i></div>
                            </div>
                        </div>
                    </div>

                </div>

                <div class="form-row">
                    <div class="form-group col-md-12">
                        <label for="comp-descriptioninput">Description: </label>
                        <input type="text" class="form-control form-control-sm" id="comp-descriptioninput" placeholder="Enter Decription" name="description">
                    </div>
                </div>

                <button type="button" id="comp-add-button" class="btn btn-primary">Add Competition</button>
            </form>';
            echo '<br />';
    }

    //now print events with their athletes
    foreach ($events as $event) {
        //print the event
        $event->printEvent();
        foreach ($event->_athletes as $athlete) {
            //print the athlete
            $athlete->printAthlete();
        }
        //print the new athlete form
        echo '  <form id="athlete-add-form" class="border border-secondary" method="POST">
                    <div class="form-row">
                        <div class="col-md-12">
                            <p class="h4 text-center">Add Existing Athlete</p>
                        </div>
                    </div>';

        //show a list of exisiting athletes
        echo '<div class="form-row">
                <div class="form-group col-md-12">
                    <label for="athlete-addexisiting-select">Add Exisiting: </label>
                    <select class="form-control form-control-sm athlete-addexisiting-select">
                        <option value="none"> Select Exisiting Athlete... </option> ';
        foreach ($exisiting_athletes as $athlete) {
            //use $event->_eid and check that the athletes e_id is NOT THE SAME as the current event id
            if($athlete->_eid != $event->_eid){
                echo '<option value="'.$athlete->_aid.'"> '.$athlete->_fname.' '.$athlete->_lname.' </option>';
            }
        }
        echo '      </select>
                </div>
            </div>';

        echo '
                    <div class="form-row">
                        <div class="col-md-12">
                            <p class="h4 text-center">Add New Athlete</p>
                        </div>
                    </div>

                    <div class="form-row">
                        <div class="form-group col-md-6">
                            <label for="athlete-firstnameinput">Firstname: </label>
                            <input type="text" class="form-control form-control-sm athlete-firstnameinput" placeholder="Enter Firstname" name="firstname">
                        </div>

                        <div class="form-group col-md-6">
                            <label for="athlete-lastnameinput">lastname: </label>
                            <input type="text" class="form-control form-control-sm " id="" placeholder="Enter Lastname" name="lastname">
                        </div>
                    </div>

                    <div class="form-row">
                        <div class="form-group col-md-4">
                            <label for="athlete-classinput">class: </label>
                            <select class="form-control form-control-sm athlete-classinput">
                                <option value="U65 Women">U65 Women</option>
                                <option value="U82 Women">U82 Women</option>
                                <option value="Open Women">Open Women</option>
                                <option value="U80 Men">U80 Men</option>
                                <option value="U90 Men">U90 Men</option>
                                <option value="U105 Men">U105 Men</option>
                                <option value="Open Men">Open Men</option>
                             </select>
                        </div>

                        <div class="form-group col-md-4">
                            <label for="athlete-genderinput">gender: </label>
                            <select class="form-control form-control-sm athlete-genderinput">
                                <option value="Female">Female</option>
                                <option value="Male">Male</option>
                                <option value="Other">Other</option>
                             </select>
                        </div>

                        <div class="form-group col-md-4">
                            <label for="athlete-bodyweightinput">bodyweight: </label>
                            <input type="text" class="form-control form-control-sm athlete-bodyweightinput" placeholder="Enter Body Weight" name="bodyweight">
                        </div>
                    </div>

                    <button type="submit" class="btn btn-primary athlete-add-button" value="'.$event->_eid.'">Add Athlete</button>
                </form>';
                echo '<br />';
    }
    if($competition_set){
        //print the new event form
        echo '  <form id="event-form" class="border border-secondary" method="POST">
                    <div class="form-row">
                        <div class="col-md-12">
                            <p class="h2 text-center">New Event</p>
                        </div>
                    </div>

                    <div class="form-row">
                        <div class="form-group col-md-6">
                          <label for="event-typeinput">Event Name: </label>
                          <input type="text" class="form-control" id="event-nameinput" placeholder="Enter Name" name="name">
                        </div>

                        <div class="form-group col-md-6">
                          <label for="event-typeinput">Event Type: </label>
                          <select class="form-control" id="event-typeinput">
                              <option value="Fastest Time">Fastest Time</option>
                              <option value="Longest Time">Longest Time</option>
                              <option value="Most Reps">Most Reps</option>
                              <option value="Most Weight">Most Weight</option>
                              <option value="Most Distance">Most Distance</option>
                           </select>
                        </div>
                    </div>

                    <div class="form-row">
                        <div class="form-group col-md-6">
                            <label for="event-datetimepicker1">Start date: </label>
                            <div class="input-group date" id="event-datetimepicker1" data-target-input="nearest">
                                <input type="text" class="form-control datetimepicker-input" data-target="#event-datetimepicker1" id="event-datetimepicker1-input" placeholder="Enter start time and date -->"/>
                                <div class="input-group-append" data-target="#event-datetimepicker1" data-toggle="datetimepicker">
                                    <div class="input-group-text"><i class="fa fa-calendar"></i></div>
                                </div>
                            </div>
                        </div>
                        <script type="text/javascript">
                            $(function () {
                                $("#event-datetimepicker1").datetimepicker();
                            });
                        </script>

                        <div class="form-group col-md-6">
                            <label for="event-datetimepicker2">End date: </label>
                            <div class="input-group date" id="event-datetimepicker2" data-target-input="nearest">
                                <input type="text" class="form-control datetimepicker-input" data-target="#event-datetimepicker2" id="event-datetimepicker2-input" placeholder="Enter end time and date -->"/>
                                <div class="input-group-append" data-target="#event-datetimepicker2" data-toggle="datetimepicker">
                                    <div class="input-group-text"><i class="fa fa-calendar"></i></div>
                                </div>
                            </div>
                        </div>
                        <script type="text/javascript">
                            $(function () {
                                $("#event-datetimepicker2").datetimepicker();
                            });
                        </script>
                    </div>

                    <button type="button" class="btn btn-primary" id="event-add-button" value="'.$competition->_cid.'">Add Event</button>
                </form>';
        echo '<br />';
    }

    echo '<button type="button" id="update-all-button" class="btn  btn-secondary btn-warning"> Update All </button>

    <a href="index.php"><button type="button" class="btn btn-primary"> To Homepage </button></a>';

echo '</div></body>';
?>

<?php include("php/connects/footer.php"); ?>
