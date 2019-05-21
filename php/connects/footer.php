<?php
    if(isset($_SESSION['username']) AND !empty($_SESSION['username'])){
        echo '<a id="add-button" type="button" class="btn btn-primary" href="add_edit.php"> Add/Edit </a>';
    }
?>

<!-- Main links -->
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.12.9/umd/popper.min.js" integrity="sha384-ApNbgh9B+Y1QKtv3Rn7W3mgPxhU9K/ScQsAP7hUibX39j7fakFPskvXusvfa0b4Q" crossorigin="anonymous"></script>

<!-- Notifications -->
<script type="text/javascript" src="../../js/moment.js"></script>
<script type="text/javascript" src="../../js/bootstrap-notify.min.js"></script>


<script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/tempusdominus-bootstrap-4/5.0.1/js/tempusdominus-bootstrap-4.min.js"></script>

<!-- Personal JS -->
<script type="text/javascript" src="../../js/add_scripts.js"></script>
</html>
