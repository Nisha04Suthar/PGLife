 <!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  
  <title>Welcome | PGLife</title>

  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.0.0/dist/css/bootstrap.min.css"
    integrity="sha384-Gn5384xqQ1aoWXA+058RXPxPg6fy4IWvTNh0E263XmFcJlSAwiGgFAW/dAiS6JXm" crossorigin="anonymous">
  <script src="https://code.jquery.com/jquery-3.2.1.slim.min.js"
    integrity="sha384-KJ3o2DKtIkvYIK3UENzmM7KCkRr/rE9/Qpg6aAZGJwFDMVNA/GpGFF93hXpG5KkN"
    crossorigin="anonymous"></script>
  <script src="https://cdn.jsdelivr.net/npm/popper.js@1.12.9/dist/umd/popper.min.js"
    integrity="sha384-ApNbgh9B+Y1QKtv3Rn7W3mgPxhU9K/ScQsAP7hUibX39j7fakFPskvXusvfa0b4Q"
    crossorigin="anonymous"></script>
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.0.0/dist/js/bootstrap.min.js"
    integrity="sha384-JZR6Spejh4U02d8jOt6vLEHfe/JQGiRRSQQxSfFWpi1MquVdAyjUar5+76PVCmYl"
    crossorigin="anonymous"></script>

  <link href="css/bootstrap.min.css" rel="stylesheet" />
  <link href="https://fonts.googleapis.com/css2?family=Open+Sans&display=swap" rel="stylesheet">
  <script src="https://kit.fontawesome.com/2cbc822d11.js" crossorigin="anonymous"></script>
  <link rel="stylesheet" href="css/Homepage.css"/>
  <script type="text/javascript" src="js/bootstrap.min.js"></script>
  <script type="text/javascript" src="js/jquery.js"></script>
  
</head>

<body>

  <?php 
  include "includes/header.php";
  ?>

  <div class="search">
    <div id="search">
      <h1>Your Perfect PG Awaits – Search by City!</h1>
      <form id="search-form" style="display:flex;" action="property_list.php" method="GET">
        <input class="form-control input-city" id="city" name="city" type="text"
          placeholder="Enter your city to search" />
        <div class="input-group-append">
          <button class="btn btn-secondary" type="submit">
            <i class="fa fa-search"></i>
          </button>
        </div>
      </form>
    </div>
  </div>

  <div class="mc">
    <div id="heading">
      <h1>Major Cities</h1>
    </div>

    <div class="major-cities">
      <div>
        <a href="property_list.php?city=Delhi">
          <img class="city" src="img/delhi.png"> 
        </a>
      </div>
      <div>
        <a href="property_list.php?city=Mumbai">  
          <img class="city" src="img/mumbai.png">
        </a>
      </div>  
      <div>
        <a href="property_list.php?city=Bangalore"> 
          <img class="city" src="img/bangalore.png">
        </a>
      </div> 
      <div> 
        <a href="property_list.php?city=Hyderabad"> 
          <img class="city" src="img/hyderabad.png">
        </a>
      </div>
    </div>
  </div>

    <?php
    include "includes/signup_modal.php";
    include "includes/login_modal.php";
    include "includes/footer.php";
    ?>
</body>
</html>