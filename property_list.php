
<?php
session_start();
require "includes/database_connect.php";

$user_id = isset($_SESSION['user_id']) ? $_SESSION['user_id'] : NULL;
$city_name = $_GET["city"];

$sql_1 = "SELECT * FROM cities WHERE name = '$city_name'";
$result_1 = mysqli_query($conn, $sql_1);
if (!$result_1) {
    echo "Something went wrong!";
    return;
}
$city = mysqli_fetch_assoc($result_1);
if (!$city) {
    echo "Sorry! We do not have any PG listed in this city.";
    return;
}
$city_id = $city['id'];


$sql_2 = "SELECT * FROM properties WHERE city_id = $city_id";
$result_2 = mysqli_query($conn, $sql_2);
if (!$result_2) {
    echo "Something went wrong!";
    return;
}
$properties = mysqli_fetch_all($result_2, MYSQLI_ASSOC);


$sql_3 = "SELECT * 
            FROM interested_users_properties iup
            INNER JOIN properties p ON iup.property_id = p.id
            WHERE p.city_id = $city_id";
$result_3 = mysqli_query($conn, $sql_3);
if (!$result_3) {
    echo "Something went wrong!";
    return;
}
$interested_users_properties = mysqli_fetch_all($result_3, MYSQLI_ASSOC);
?>  

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Best PG's in <?php echo $city_name?> | PG Life</title> 

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
    <link rel="stylesheet" href="css/PGList.css" />
</head>

<body>
 
    <?php
    include "includes/header.php";
    ?>

    <nav aria-label="breadcrumb">
        <ol class="breadcrumb py-2">
            <li class="breadcrumb-item"><a href="Homepage.php">Home</a></li>
            <li class="breadcrumb-item active" aria-current="page">
                <?php echo $city_name; ?>
            </li>
        </ol>
    </nav>
 
    <div class="page-container">
        <div class="filter-bar row justify-content-around" style="margin-top:40px;">
            <div class="col-auto" data-toggle="modal" data-target="#filter-modal">
                <img class="filter" src="img/filter.png" />
                    <span>filter</span>
            </div>
            <div class="col-auto">
                <img class="filter" src="img/asc.png" />
                    <span>highest rent first</span>
            </div>
            <div class="col-auto sort-active">
                <img class="filter" src="img/desc.png">
                    <span>smallest rent first</span>
            </div>
        </div>
        
        <?php
           foreach($properties as $property){
           $property_images = glob("img/properties/".$property['id']. "/*");
        ?>    
        
        <div class="property-card property-id-<?= $property['id'] ?> row">
            <div class="property-container">
                <div class="image-container">   
                    <img src="<?= $property_images[0] ?>" />   
                </div>
                <div class="content-container">
                    <div class="rating">
                        <?php
                         $total_rating = ($property['rating_clean']+ $property['rating_food']+ $property['rating_safety']) / 3;
                         $total_rating = round($total_rating, 1);
                        ?>
                        <div class="star_container" title="<? = $total_rating ?>">
                            <?php
                            $rating = $total_rating;
                            for ($i = 0 ; $i<5 ; $i++ ){
                            if ($rating >= $i + 0.8) {
                            ?>        
                                <i style="color:red;" class="fas fa-star"></i>
                            <?php
                           } elseif ($rating >= $i + 0.8){
                            ?>  
                                <i style="color:red;" class="fas fa-star"></i>
                            <?php
                           } else {
                            ?>   
                                <i style="color:red;" class="fas fa-star-half-alt"></i>
                            <?php   
                                 }
                             }
                            ?>
                        </div>
                        <div class="interested-container">
                            <?php
                            $interested_users_count = 0;
                            $is_interested = false;
                            foreach($interested_users_properties as $interested_user_property) {
                            if($interested_user_property['property_id']==$property['id']){
                               $interested_users_count++;

                               if($interested_user_property['user_id'] == $user_id){
                                   $is_interested = true;
                                   }
                                }
                             }

                           if($is_interested){
                            ?>        
                                <i style="color:red;" class="is-interested-image fas fa-heart" property_id="<?= $property['id'] ?>"></i>
                            <?php 
                           }else{
                            ?>
                                <i style="color:red;" class="is-interested-image far fa-heart" property_id="<?= $property['id'] ?>"></i>
                            <?php
                           }
                            ?>    
                            <div class="interested-text"><?= $interested_users_count ?> interested </div>
                        </div>
                    </div> 
                     
                    <div class="detail-container">
                        <div class="property-name"><?=$property['name']?><h4></h4></div>
                        <div class="property-address"><?=$property['address']?></div>
                            <div class="property-gender">
                            <?php
                           if($property['gender']=="male"){
                            ?>
                                <img id="male" src="img/male.png"/>
                            <?php
                           }elseif($property['gender']=="female"){
                            ?>     
                                <img id="female" src="img/female.png"/> 
                            <?php       
                           }else{
                            ?>
                                <img id="unisex" src="img/unisex.png"/>
                            <?php    
                           }
                            ?>
                            </div>
                       
                        <div class="rent">
                            <div class="rent-container">
                                <div class="rent-amount">Rs<?= number_format($property['rent'])?></div>
                                <div class="rent-unit">per month</div>
                            </div>

                            <div class="button-container">
                            <a href="property_detail.php?property_id=<?= $property['id']?>">view</a>
                            </div> 
                        </div>      
                    </div>
                </div> 
            </div>    
        </div>
    </div>
        
        <?php 
         }   

           if(count($properties)==0){
        ?>
        <div class="no-property-container">
            <p>No PG to List</p>
        </div>
        <?php    
          }
        ?>  

<div class="modal fade" id="filter-modal" tabindex="-1" role="dialog" aria-labelledby="filter-heading" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h3 class="modal-title" id="filter-heading">Filters</h3>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>

                <div class="modal-body">
                    <h5>Gender</h5>
                    <hr />
                    <div>
                        <button class="btn btn-outline-dark btn-active">
                            No Filter
                        </button>
                        <button class="btn btn-outline-dark">
                            <i class="fas fa-venus-mars"></i>Unisex
                        </button>
                        <button class="btn btn-outline-dark">
                            <i class="fas fa-mars"></i>Male
                        </button>
                        <button class="btn btn-outline-dark">
                            <i class="fas fa-venus"></i>Female
                        </button>
                    </div>
                </div>

                <div class="modal-footer">
                    <button data-dismiss="modal" class="btn btn-success">Okay</button>
                </div>
            </div>
        </div>
    </div>

    <?php
    include "includes/signup_modal.php";
    include "includes/login_modal.php";
    include "includes/footer.php";
    ?>

    <script type="text/javascript" src="js/property_list.js"></script>
</body>

</html>