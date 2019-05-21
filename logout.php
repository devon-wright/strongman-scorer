<?php
    session_start();
    session_unset();
    session_destroy();
    include("php/connects/header.php");
?>

<body>
    <h4 class="text-center"> Logging out - Redirecting to homepage</h4>
    <script>
        setTimeout(function(){
            window.location.replace("/index.php");
        }, 1000);
    </script>
</body>

<?php include("php/connects/footer.php"); ?>
