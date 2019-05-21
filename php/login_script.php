<?php
    session_start();
    require('connect.php');

        $username = $_POST['email'];
        $password = $_POST['password'];

        $query = "SELECT * FROM Users WHERE u_email='".$username."' and u_password='".$password."'";

        $result = mysqli_query($conn, $query) or die(mysqli_error($conn));
        $count = mysqli_num_rows($result);

        if($count = 1){
            $_SESSION['username'] = $username;
            header("Location:/../index.php");
        }else{
            echo "Invalid login details";
        }
 ?>
