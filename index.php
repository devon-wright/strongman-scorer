<?php
    session_start();
    include("php/connects/header.php");
    include("php/connects/nav.php");
?>

<body>
    <div class="alert alert-warning alert-dismissible fade show" role="alert">
      <h4 class="alert-heading"> Still to complete: </h4>
      <hr>
      <p> Display Old Competitions </p>
      <p> Stop Duplicates of exisiting athletes being added (Stop same name being used) </p>
      <button type="button" class="close" data-dismiss="alert" aria-label="Close">
        <span aria-hidden="true">&times;</span>
      </button>
    </div>

    <div id="body-scoreboard">
        <div class="container-fluid">
                <!-- Title -->
                <p class="display-4 text-center"> - Live Scoreboard - </p>
        </div>

        <!-- Scoreboard -->
        <div id="refresher-board">
            <?php include("php/scoreboard.php"); ?>
        </div>
    </div>

    <div id="body-oldcomp">
        <div class="container-fluid">
            <!-- Title -->
            <p class="display-4 text-center"> - Old Competition Results - </p>

            <?php include("php/old_comps.php"); ?>
        </div>
    </div>

</body>

<?php include("php/connects/footer.php"); ?>
