<?php
    session_start();
    include("php/connects/header.php");
    include("php/connects/nav.php");
?>

<body>
    <div id="body-login">
    <p class="display-4 text-center"> Login </p>
    <form action="/php/login_script.php" method="POST">
        <div class="form-group">
            <label for="emailinput">Email address</label>
            <input type="email" class="form-control" id="emailinput" aria-describedby="emailHelp" placeholder="Enter email" name="email">
        </div>
        <div class="form-group">
            <label for="passwordinput">Password</label>
            <input type="password" class="form-control" id="passwordinput" placeholder="Password" name="password">
        </div>
        <button type="submit" class="btn btn-primary">Submit</button>
      </form>
    </div>
</body>

<?php include("php/connects/footer.php"); ?>
