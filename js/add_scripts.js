$(window).on('load', function (){
    //set some options of the DOM
    $('#competition-form').click(function(e){e.preventDefault();});

    //Contains all functions and data objects to do with adding a new competition, events and athletes
    var competition_obj;
    var event_obj;
    var athlete_obj;

    //Create object classes
    function CompetitionObject(ds, de, tt, dp, rf, sc){
        this._start_date = ds;
        this._end_date = de;
        this._title = tt;
        this._description = dp;
        this._ref = rf;
        this._scorer = sc;
    }

    function EventObject(en, et, sd, ed){
        this._event_name = en;
        this._event_type = et;
        this._start_date = sd;
        this._end_date = ed;
    }

    function AthleteObject(fn, ln, cl, gn, bw){
        this._first_name = fn;
        this._last_name = ln;
        this._body_class = cl;
        this._gender = gn;
        this._bodyweight = bw;
    }

    function Compete_In(cid, eid, aid, vl, pt){
        this._ciid = cid;
        this._eid = eid;
        this._aid = aid;
        this._value = vl;
        this._points = pt;
    }

    function loadCompetition(){
        //competition-addexisiting-select
        var _cid = $('#competition-addexisiting-select').val();

        var url = "add_edit.php";
        window.location.href = url + "?c_id=" + _cid;
    }
    $('#comp-load-button').on('click', loadCompetition);

    //when a new competion is added
    function addCompetition(){
        //get data from form
        var title = $('#comp-titleinput').val();
        var ref = $('#comp-refereeinput').val();
        var scorer = $('#comp-scorerinput').val();
        var c_start_date = $('#comp-datetimepicker1-input').val();
        var c_end_date = $('#comp-datetimepicker2-input').val();
        var description = $('#comp-descriptioninput').val();

        //convert date to SQL time
        //from 09/20/2011 [MM/DD/YYYY] to 2011-09-20 00:00:00 [YYYY-MM-DD 00:00:00]
        var start_date_obj = moment(c_start_date, 'MM/DD/YYYY');
        var end_date_obj = moment(c_end_date, 'MM/DD/YYYY');

        //create new comp object from data
        competition_obj = new CompetitionObject(start_date_obj.format('YYYY/MM/DD HH:mm:ss'), end_date_obj.format('YYYY/MM/DD HH:mm:ss'), title, description, ref, scorer);

        var JSON_data = JSON.stringify({competition_data: competition_obj});

        $.ajax({
            type: "POST",
            url: '../php/add_competition.php',
            dataType: 'json',
            data: {data: JSON_data},
            success: function(data) {
                if(data['success']){
                    //store id and undisable other buttons
                    curr_comp_id = data['c_id'];

                    //refresh the page with the c_id
                    var url = "add_edit.php";
                    window.location.href = url + "?c_id=" + curr_comp_id;
                }
                else{
                    //display error message
                    $.notify({
                    	// options
                    	message: 'There was an error. Please refresh page and try again. Or contact the System Administrator.'
                    },{
                    	// settings
                    	type: 'danger'
                    });
                }
            }
        });
    }
    //event handler to comp form
    $('#comp-add-button').on('click', addCompetition);

    //Add an Event
    function addEvent(){
        //get data from form
        var _c_id = $('#event-add-button').val();
        var _event_name = $('#event-nameinput').val();
        var _event_type = $('#event-typeinput').val();
        var e_start_date = $('#event-datetimepicker1-input').val();
        var e_end_date = $('#event-datetimepicker2-input').val();

        var start_date_obj = moment(e_start_date, 'MM/DD/YYYY');
        var end_date_obj = moment(e_end_date, 'MM/DD/YYYY');

        event_obj = new EventObject(_event_name, _event_type, start_date_obj.format('YYYY/MM/DD HH:mm:ss'), end_date_obj.format('YYYY/MM/DD HH:mm:ss'));

        var JSON_data = JSON.stringify({competition_data: {_c_id: _c_id}, event_data: event_obj});

        $.ajax({
            type: "POST",
            url: '../php/add_event.php',
            dataType: 'json',
            data: {data: JSON_data},
            success: function(data) {
                if(data['success']){
                    location.reload(true);
                }
                else{
                    //display error message
                    $.notify({
                    	// options
                    	message: 'There was an error. Please refresh page and try again. Or contact the System Administrator.'
                    },{
                    	// settings
                    	type: 'danger'
                    });
                }
            }
        });
    }
    //event handler to comp form
    $('#event-add-button').on('click', addEvent);

    function addAthlete(form){
        //get data from form $('input[name="firstname"]', form).val();
        var _existing_a_id = $('.athlete-addexisiting-select', form).val();
        var _e_id = $('.athlete-add-button', form).val();

        //if exisiting is set then just add event to a_id
        if(_existing_a_id != "none"){
            //first check that we arent putting a duplicate into the same event
            var JSON_data_check = JSON.stringify({_list_of_athletes: _existing_a_id});

            $.ajax({
                type: "POST",
                url: '../php/get_athletes.php',
                dataType: 'json',
                data: {data: JSON_data_check},
                success: function(data) {
                    if(data['success'] == "false"){
                        //do thing
                        var JSON_data_add = JSON.stringify({_e_id: _e_id, _a_id: _existing_a_id});

                        $.ajax({
                            type: "POST",
                            url: '../php/add_connection.php',
                            dataType: 'json',
                            data: {data: JSON_data_add},
                            success: function(data) {
                                if(data['success']){
                                    location.reload(true);
                                }
                                else{
                                    //display error message
                                    $.notify({
                                        // options
                                        message: 'There was an error. Please refresh page and try again. Or contact the System Administrator.'
                                    },{
                                        // settings
                                        type: 'danger'
                                    });
                                }
                            }
                        });
                    }
                    else{
                        //display error message
                        $.notify({
                            // options
                            message: 'There was an error. Please refresh page and try again. Or contact the System Administrator.'
                        },{
                            // settings
                            type: 'danger'
                        });
                    }
                }
            });
        }
        else{
            var a_first_name = $('input[name="firstname"]', form).val();
            var a_last_name = $('input[name="lastname"]', form).val();
            var a_class = $('.athlete-classinput', form).val();
            var a_gender = $('.athlete-genderinput', form).val();
            var a_bodyweight = $('input[name="bodyweight"]', form).val();

            //create new comp object from data
            athlete_obj = new AthleteObject(a_first_name, a_last_name, a_class, a_gender, a_bodyweight);

            var JSON_data = JSON.stringify({event_data: {_e_id: _e_id}, athlete_data: athlete_obj});

            $.ajax({
                type: "POST",
                url: '../php/add_athlete.php',
                dataType: 'json',
                data: {data: JSON_data},
                success: function(data) {
                    if(data['success']){
                        var _a_id = data['a_id'];

                        //add init of competes_in
                        var JSON_data = JSON.stringify({_e_id: _e_id, _a_id: _a_id});

                        $.ajax({
                            type: "POST",
                            url: '../php/add_connection.php',
                            dataType: 'json',
                            data: {data: JSON_data},
                            success: function(data) {
                                if(data['success']){
                                    //console.log("_e_id: " + _e_id + " - fname: " + a_first_name + " - ofname: " + athlete_obj[0]);
                                    location.reload(true);
                                }
                                else{
                                    //display error message
                                    $.notify({
                                    	// options
                                    	message: 'There was an error. Please refresh page and try again. Or contact the System Administrator.'
                                    },{
                                    	// settings
                                    	type: 'danger'
                                    });
                                }
                            }
                        });
                    }
                    else{
                        //display error message
                        $.notify({
                        	// options
                        	message: 'There was an error. Please refresh page and try again. Or contact the System Administrator.'
                        },{
                        	// settings
                        	type: 'danger'
                        });
                    }
                }
            });
        }
    }
    $('form#athlete-add-form').submit(function(e){
            e.preventDefault();
            var form = this;
            addAthlete(form);
    });

    // ---- UPDATE competition
    function updateCompetition(reload_page){
        //get data from form
        var _c_id = $('#comp-update-button').val();
        var title = $('#comp-titleinput').val();
        var ref = $('#comp-refereeinput').val();
        var scorer = $('#comp-scorerinput').val();
        var c_start_date = $('#comp-datetimepicker1-input').val();
        var c_end_date = $('#comp-datetimepicker2-input').val();
        var description = $('#comp-descriptioninput').val();

        var start_date_obj = moment(c_start_date, 'MM/DD/YYYY');
        var end_date_obj = moment(c_end_date, 'MM/DD/YYYY');

        //create new comp object from data
        competition_obj = new CompetitionObject(start_date_obj.format('YYYY/MM/DD HH:mm:ss'), end_date_obj.format('YYYY/MM/DD HH:mm:ss'), title, description, ref, scorer);

        var JSON_data = JSON.stringify({_c_id: _c_id, competition_data: competition_obj});

        console.log("Updating Competition: " + c_start_date + " til " + c_end_date);

        $.ajax({
            type: "POST",
            url: '../php/update_competition.php',
            dataType: 'json',
            data: {data: JSON_data},
            success: function(data) {
                if(data['success']){
                    //store id and undisable other buttons
                    curr_comp_id = data['c_id'];

                    //refresh the page with the c_id
                    if(reload_page){
                        var url = window.location.href;
                        window.location.href = url + "?c_id=" + curr_comp_id;
                    }
                }
                else{
                    //display error message
                    $.notify({
                    	// options
                    	message: 'There was an error. Please refresh page and try again. Or contact the System Administrator.'
                    },{
                    	// settings
                    	type: 'danger'
                    });
                }
            }
        });
    }
    $('#comp-update-button').click(function(e){
            updateCompetition(true);
    });

    // ---- UPDATE Events
    function updateEvent(form, reload_page){
        //get data from form
        var _e_id = $('.event-update-button', form).val();
        var _event_name = $('.event-nameinput-curr', form).val();
        var _event_type = $('.event-typeinput-curr', form).val();
        var e_start_date = $('.start-date', form).val();
        var e_end_date = $('.end-date', form).val();

        var start_date_obj = moment(e_start_date, 'MM/DD/YYYY HH:mm:ss');
        var end_date_obj = moment(e_end_date, 'MM/DD/YYYY HH:mm:ss');

        event_obj = new EventObject(_event_name, _event_type, start_date_obj.format('YYYY/MM/DD HH:mm:ss'), end_date_obj.format('YYYY/MM/DD HH:mm:ss'));

        var JSON_data = JSON.stringify({_e_id: _e_id, event_data: event_obj});

        $.ajax({
            type: "POST",
            url: '../php/update_event.php',
            dataType: 'json',
            data: {data: JSON_data},
            success: function(data) {
                if(data['success']){
                    if(reload_page){
                        //location.reload(true);
                    }
                }
                else{
                    //display error message
                    $.notify({
                    	// options
                    	message: 'There was an error. Please refresh page and try again. Or contact the System Administrator.'
                    },{
                    	// settings
                    	type: 'danger'
                    });
                }
            }
        });
    }
    $('form#event-form').submit(function(e){
        e.preventDefault();
        var form = this;

        if(document.activeElement.getAttribute('what') == "update"){
            updateEvent(form, true);
        }
        else{
            deleteEvent(form, true);
        }
    });

    // ---- UPDATE Athlete
    function updateAthlete(form, reload_page){
        //get data from form
        var _a_id = $('.athlete-update-button', form).val();
        var a_first_name = $('.athlete-firstnameinput-curr', form).val();
        var a_last_name = $('.athlete-lastnameinput-curr', form).val();
        var a_class = $('.athlete-classinput-curr', form).val();
        var a_gender = $('.athlete-genderinput-curr', form).val();
        var a_bodyweight = $('.athlete-bodyweightinput-curr', form).val();

        //create new comp object from data
        athlete_obj = new AthleteObject(a_first_name, a_last_name, a_class, a_gender, a_bodyweight);

        var JSON_data = JSON.stringify({_a_id: _a_id, athlete_data: athlete_obj});

        $.ajax({
            type: "POST",
            url: '../php/update_athlete.php',
            dataType: 'json',
            data: {data: JSON_data},
            success: function(data) {
                if(data['success']){
                    if(reload_page){
                        location.reload(true);
                    }
                }
                else{
                    //display error message
                    $.notify({
                        // options
                        message: 'There was an error. Please refresh page and try again. Or contact the System Administrator.'
                    },{
                        // settings
                        type: 'danger'
                    });
                }
            }
        });
    }
    $('form#athlete-form').submit(function(e){
        e.preventDefault();
        var form = this;

        if(document.activeElement.getAttribute('what') == "update"){
            updateAthlete(form, true);
        }
        else{
            deleteAthlete(form, true);
        }
    });

    function updateCompetesIn(form, reload_page){
        //get data from form
        var _ci_id = $('.competes-in-update-button', form).val();
        var ci_value = $('input[name="value"]', form).val();

        //create new comp object from data
        var list_of_connects = [];
        var data_to_send = [];

        //load all ci's to do with event
        //with a ajax request
        var _e_id = $('input[name="eid"]', form).val();
        //var competes in objs

        var JSON_get_data = JSON.stringify({_e_id: _e_id});
        $.ajax({
            type: "POST",
            url: '../php/get_event_connects.php',
            dataType: 'json',
            data: {data: JSON_get_data},
            success: function(data) {
                if(data['success']){
                    for(var i = 0; i < data['list_of_connects'].length; i++){
                        //if list of connects -> ciid is equal to the updated one!
                        if(data['list_of_connects'][i][0] == _ci_id){
                            //update value

                            var id = _ci_id;
                            var e_id = data['list_of_connects'][i][1];
                            var a_id = data['list_of_connects'][i][2];
                            var val = ci_value;
                            var pts = -1;
                            console.log([id, e_id, a_id, val, pts]);
                            list_of_connects.push([id, e_id, a_id, val, pts]);
                        }
                        else{
                            list_of_connects.push(data['list_of_connects'][i]);
                        }
                    }

                    //sort all values and create list of competes_in_obj's with points
                    //ignore the new competes_in_obj
                    list_of_connects.sort(function (a, b) {
                        return a[3] - b[3];
                    });

                    console.log(list_of_connects);

                    //for each list of connects
                    //check through value by values
                    // if the same count how many
                    //if 2 =

                    // INIT points
                    var list_of_points = [];
                    for(var i = 0; i < list_of_connects.length; i++){
                        list_of_points[i] = i+1;
                    }

                    // GO THROUGH each value
                    // check how many other values are equal to this one
                    // if more than 1 find median and set all points for those values to that median
                    // skip to next value up
                    var count_of_equals = 0;
                    var curr_val = 0;
                    //go through each value
                    for(var i = 0; i < list_of_connects.length; i++){
                        curr_val = list_of_connects[i][3];
                        count_of_equals = 0;
                        if(curr_val > 0){
                            // check to see if there are more of the same value
                            for(var j = i+1; j < list_of_connects.length; j++){
                                if(list_of_connects[j][3] == curr_val){
                                    count_of_equals++;
                                }
                            }
                            //if there are more than just the oen value similar
                            if(count_of_equals > 0){
                                // then find the median
                                var median = ((i+1) + ((i+1) + count_of_equals)) / 2;
                                //go through and update all equal values to have median points
                                for(var k = i; k < (i+1) + count_of_equals; k++){
                                    list_of_points[k] = median;
                                }
                                //skip to next value up
                                i = i + count_of_equals + 1;
                            }
                        }
                        else{
                            list_of_points[i] = 0;
                        }
                    }

                    //make into objs
                    for(var i = 0; i < list_of_connects.length; i++){
                        //
                        // REMEBER TO OVERWRITE THE UPDATED values!!!
                        //
                        // REPLACE Points with given points
                        if(list_of_connects[i][0] == _ci_id){
                            data_to_send.push(new Compete_In(
                            list_of_connects[i][0],
                            list_of_connects[i][1],
                            list_of_connects[i][2],
                            ci_value,
                            list_of_points[i]));
                        }
                        else{
                            data_to_send.push(new Compete_In(
                            list_of_connects[i][0],
                            list_of_connects[i][1],
                            list_of_connects[i][2],
                            list_of_connects[i][3],
                            list_of_points[i]));
                        }
                    }

                    JSON_data = JSON.stringify({competes_in_data: data_to_send});

                    //send to server and update
                    $.ajax({
                        type: "POST",
                        url: '../php/update_event_connects.php',
                        dataType: 'json',
                        data: {data: JSON_data},
                        success: function(data) {
                            if(data['success']){
                                if(reload_page){
                                    location.reload(true);
                                }
                            }
                            else{
                                //display error message
                                $.notify({
                                    // options
                                    message: 'There was an error. Please refresh page and try again. Or contact the System Administrator.'
                                },{
                                    // settings
                                    type: 'danger'
                                });
                            }
                        }
                    });
                }
                else{
                    //display error message
                    $.notify({
                        // options
                        message: 'There was an error. Please refresh page and try again. Or contact the System Administrator.'
                    },{
                        // settings
                        type: 'danger'
                    });
                }
            }
        });




        //var JSON_data = JSON.stringify({_ci_id: _ci_id, competes_in_data: competes_in_obj});

        //console.log(_ci_id + " - " + ci_value + " - " + ci_points);

        /*$.ajax({
            type: "POST",
            url: '../php/update_competes_in.php',
            dataType: 'json',
            data: {data: JSON_data},
            success: function(data) {
                if(data['success']){

                    console.log("updated");
                    location.reload(true);
                }
                else{
                    //display error message
                    $.notify({
                        // options
                        message: 'There was an error. Please refresh page and try again. Or contact the System Administrator.'
                    },{
                        // settings
                        type: 'danger'
                    });
                }
            }
        });*/
    }
    $('form#competes-in-form').submit(function(e){
        e.preventDefault();
        var form = this;
        updateCompetesIn(form, true);
    });

    function updateAll(){
        //competition
        updateCompetition(false);

        //Events
        $('.event-class').each(function (){
            var this_form = this;
            updateEvent(this_form, false);
        });

        //athletes
        $('.athlete-class').each(function (){
            var this_form = this;
            updateAthlete(this_form, false);
        });

        $('.competesin-class').each(function (){
            var this_form = this;
            updateCompetesIn(this_form, false);
        })

        location.reload(true);
    }
    $('#update-all-button').on('click', function (){
        updateAll();
    });

//Deleting

function deleteCompetition(){
    //get data from form
    //go through and load each selected option
    var _selected_competition = $('#comp-delete-button').val();

    var JSON_data = JSON.stringify({_selected_competition: _selected_competition});

    $.ajax({
        type: "POST",
        url: '../php/delete_competition.php',
        dataType: 'json',
        data: {data: JSON_data},
        success: function(data) {
            if(data['success']){
                //go back to homepage
                var url = "add_edit.php";
                window.location.href = url;
            }
            else{
                //display error message
                $.notify({
                    // options
                    message: 'There was an error. Please refresh page and try again. Or contact the System Administrator.'
                },{
                    // settings
                    type: 'danger'
                });
            }
        }
    });
}
$('#comp-delete-button').click(function(e){
    deleteCompetition();
});

function deleteAthlete(form){
    //get data from form
    //go through and load each selected option
    var _selected_athlete = $('.athlete-update-button', form).val();

    var JSON_data = JSON.stringify({_selected_athlete: _selected_athlete});

    $.ajax({
        type: "POST",
        url: '../php/delete_athlete.php',
        dataType: 'json',
        data: {data: JSON_data},
        success: function(data) {
            if(data['success']){
                //go back to homepage
                location.reload(true);
            }
            else{
                //display error message
                $.notify({
                    // options
                    message: 'There was an error. Please refresh page and try again. Or contact the System Administrator.'
                },{
                    // settings
                    type: 'danger'
                });
            }
        }
    });
}

function deleteEvent(form){
    //get data from form
    //go through and load each selected option
    var _selected_event = $('.event-update-button', form).val();

    var JSON_data = JSON.stringify({_selected_event: _selected_event});

    $.ajax({
        type: "POST",
        url: '../php/delete_event.php',
        dataType: 'json',
        data: {data: JSON_data},
        success: function(data) {
            if(data['success']){
                //go back to homepage
                location.reload(true);
            }
            else{
                //display error message
                $.notify({
                    // options
                    message: 'There was an error. Please refresh page and try again. Or contact the System Administrator.'
                },{
                    // settings
                    type: 'danger'
                });
            }
        }
    });
}

///- ---- DATETIME FUNCTIONS -------

$(function() {
    if($("#comp-datetimepicker1-input").val().length <= 10){
        $("#comp-datetimepicker1").datetimepicker({
            date: $("#comp-datetimepicker1-input").val(),
            format: 'L'
        });
    }
    else{
        var tdate = moment($("#comp-datetimepicker1-input").val(), "YYYY-MM-DD HH:mm:ss").toDate();

        $("#comp-datetimepicker1").datetimepicker({
            date: tdate,
            format: 'L'
        });
    }
});

$(function() {
    if($("#comp-datetimepicker2-input").val().length <= 10){
        $("#comp-datetimepicker2").datetimepicker({
            date: $("#comp-datetimepicker2-input").val(),
            format: 'L'
        });
    }
    else{
        var tdate = moment($("#comp-datetimepicker2-input").val(), "YYYY-MM-DD HH:mm:ss").toDate();

        $("#comp-datetimepicker2").datetimepicker({
            date: tdate,
            format: 'L'
        });
    }
});

$(".event-datetimepicker1-dyn").each(function (index, obj){
    //set the id
    var this_id = $(this).attr("id");
    $(this).attr("id", this_id + "-" + index);

    //inpput data target
    $(this).children("input").attr("data-target", "#" + this_id + "-" + index);

    //inner div data target
    $(this).children("div .input-group-append").attr("data-target", "#" + this_id + "-" + index);

    if($(this).children("input").val().indexOf("/") >= 0){
        console.log("/ found: " + $(this).children("input").val());
        $(this).datetimepicker({
                 date: $(this).children("input").val()
        });
    }
    else{
        //get the initial datetime
        var tdate = moment($(this).children("input").val(), "YYYY-MM-DD HH:mm:ss").toDate();
        console.log("tdate1 found: " + tdate + " // " + $(this).children("input").val());
        $(this).datetimepicker({
                 date: tdate
        });
    }
});

$(".event-datetimepicker2-dyn").each(function (index, obj){
    //set the id
    var this_id = $(this).attr("id");
    $(this).attr("id", this_id + "-" + index);

    //inpput data target
    $(this).children("input").attr("data-target", "#" + this_id + "-" + index);

    //inner div data target
    $(this).children("div .input-group-append").attr("data-target", "#" + this_id + "-" + index);

    if($(this).children("input").val().indexOf("/") >= 0){
        console.log("/ found: " + $(this).children("input").val());
        $(this).datetimepicker({
                 date: $(this).children("input").val()
        });
    }
    else{
        //get the initial datetime
        var tdate = moment($(this).children("input").val(), "YYYY-MM-DD HH:mm:ss").toDate();
        console.log("tdate2 found: " + tdate);
        $(this).datetimepicker({
                 date: tdate
        });
    }
});



    //TESTING
console.log("JS loaded at time: " + moment().format());

    //scoreboard refresh timer
var $body_scoreboard = $("#refresher-board");
setInterval(function () {
    $body_scoreboard.load("fullscoreboard.php #refresher-board");
}, 10000);

});
