    <div class="header" style="position:sticky; top:0; z-index:10;">
        <!--sticky-top-->
        <nav class="navbar navbar-expand-lg navbar-light bg-light">
            <a class="navbar-brand" href="../Homepage.php"><img id="logo" src="img/logo.png"></a>

            <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#nav-bar">
                <span class="navbar-toggler-icon"></span>
            </button>

            <div class="collapse navbar-collapse justify-content-end" id="nav-bar">
                <ul class="navbar-nav">
                    <?php
                    //check if user is login or not
                    if(!isset($_SESSION["user_id"])) {
                    ?>
                        <li class="nav-item">
                            <a class="nav-link" href="#" data-toggle="modal" data-target="#signup-modal">
                                <i class="fas fa-user"></i>Signup
                            </a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="#" data-toggle="modal" data-target="#login-modal">
                                <i class="fas fa-sign-in-alt"></i>Login
                            </a>
                        </li>
                    <?php
                    }else{
                    ?>
                        <div class="nav-name">
                            Hi, <?php echo $_SESSION["full_name"] ?>
                        </div>    
                        <li class="nav-item">
                            <a href="Dashboard.php" class="nav-link">
                                <i class="fas fa-user"></i>Dashboard
                            </a>
                        </li>
                        <div class="nav-v1"> </div>
                        <li>
                            <a href="logout.php" class="nav-link">
                                <i class="fas fa-sign-out-alt"></i>Logout
                            </a>
                        </li>
                    <?php    
                    }
                    ?>     
                </ul>
            </div>
        </nav>
    </div>