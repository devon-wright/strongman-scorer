<nav class="navbar navbar-expand-md navbar-dark bg-primary fixed-top">
      <a class="navbar-brand" href="/index.php">Auckland Strongman</a>
      <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarCollapse" aria-controls="navbarCollapse" aria-expanded="false" aria-label="Toggle navigation">
        <span class="navbar-toggler-icon"></span>
      </button>
      <div class="collapse navbar-collapse" id="navbarCollapse">
        <ul class="navbar-nav mr-auto">
          <li class="nav-item active">
              <?php
                  if(isset($_SESSION['username']) AND !empty($_SESSION['username'])){
                      echo '<a class="nav-link" href="logout.php"> Logout <span class="sr-only">(current)</span></a>';
                  }else{
                      echo '<a class="nav-link" href="login.php"> Login <span class="sr-only">(current)</span></a>';
                  }
              ?>
          </li>
        </ul>
      </div>
    </nav>
