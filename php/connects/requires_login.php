<?php
    if(!isset($_SESSION['username']) OR empty($_SESSION['username'])){
        header("Location:/../index.php");
    }
?>
