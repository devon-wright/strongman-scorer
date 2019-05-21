<?php
    session_start();
    include("php/connects/header.php");
    include("php/connects/nav.php");
?>

<body>
    <div id="body-scoreboard">
        <!-- Scoreboard -->
        <div id="refresher-board">
            <?php include("php/scoreboard.php"); ?>
        </div>
    </div>
</body>

<?php include("php/connects/footer.php"); ?>
