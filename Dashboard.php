<?/*php
session_start();
require "includes/database_connect.php";

if (!isset($_SESSION["user_id"])) {
    header("location: index.php");
    die();
}
$user_id = $_SESSION['user_id'];

$sql_1 = "SELECT * FROM users WHERE id = $user_id";
$result_1 = mysqli_query($conn, $sql_1);
if (!$result_1) {
    echo "Something went wrong!";
    return;
}
$user = mysqli_fetch_assoc($result_1);
if (!$user) {
    echo "Something went wrong!";
    return;
}

$sql_2 = "SELECT * 
            FROM interested_users_properties iup
            INNER JOIN properties p ON iup.property_id = p.id
            WHERE iup.user_id = $user_id";
$result_2 = mysqli_query($conn, $sql_2);
if (!$result_2) {
    echo "Something went wrong!";
    return;
}
$interested_properties = mysqli_fetch_all($result_2, MYSQLI_ASSOC);
*/
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard</title>

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
        <link rel="stylesheet" href="css/Dashboard.css">
</head>
<body>

    <?php
    include "includes/header.php";
    ?>
    
    <nav aria-label="breadcrumb">
        <ol class="breadcrumb py-2">
            <li class="breadcrumb-item">
                <a href="index.php">Home</a>
            </li>
            <li class="breadcrumb-item active" aria-current="page">
                Dashboard
            </li>
        </ol>
    </nav>

    <div style=" margin-top:80px;">
        <div class="my-profile" style=" width:600px; margin:0 auto;">
        <h2><b>My Profile</b></h2>
        </div>

        <div class="row col-8" style=" margin: 0 auto; height:200px; padding:20px;">
            <div class="profile-img" style=" width:40%;">
                <i style="height:100px; width:100px;" class="fas fa-user profile-img"></i>
            </div>
            <div class="abc" style="width:60%; ">
                    <div class="profile">
                        <div class="name"><?//= $user['full_name'] ?>name</div>
                        <div class="email"><?//= $user['email'] ?>email</div>
                        <div class="phone"><?//= $user['phone'] ?>phone</div>
                        <div class="college"><?//= $user['college_name'] ?>college</div>
                    </div> 
                    <div class="edit">
                        <div class="edit-profile">Edit Profile</div>
                    </div>
            </div>
        </div>
    </div>
    <?php
    //if (count($interested_properties) > 0) {
    ?>
        <div class="my-interested-properties" style="height:400px;">
            <div class="my-interests" style="text-align:center; margin-top:40px;">
                <h2><b>My Interested Properties</b></h2>
            </div>
                <?php
                //foreach ($interested_properties as $property) {
                  //  $property_images = glob("img/properties/" . $property['id'] . "/*");
                ?>
                    <div class="property-card property-id-<?//= $property['id'] ?> row">
                        <div class="property-container col-8">
                            <div class="image-container">
                                <img src="<?//= $property_images[0] ?>" />
                            </div>
                            <div class="content-container col-md-8">
                                <div class="rating">
                                    <?php
                                    // $total_rating = ($property['rating_clean'] + $property['rating_food'] + $property['rating_safety']) / 3;
                                    // $total_rating = round($total_rating, 1);
                                    ?>
                                    <div class="star-container" title="<?//= $total_rating ?>">
                                        <?php
                                        // $rating = $total_rating;
                                        //for ($i = 0; $i < 5; $i++) {
                                        //   if ($rating >= $i + 0.8) {
                                        ?>
                                            <i style="color:red;" class="fas fa-star"></i>
                                        <?php
                                        //    } elseif ($rating >= $i + 0.3) {
                                        ?>
                                            <i style="color:red;" class="fas fa-star-half-alt"></i>
                                        <?php
                                         //   } else {
                                        ?>
                                            <i style="color:red;" class="far fa-star"></i>
                                        <?php
                                        //     }
                                        // }
                                        ?>
                                    </div>
                              
                                    <div class="interested-container">
                                        <i style="color:red;" class="is-interested-image fas fa-heart" property_id="  <?//= $property['id'] ?>"> </i>
                                    </div>
                                 
                                </div>
                                <div class="detail-container">
                                    <div class="property-name"><?//= $property['name'] ?><h4>Ganpati PG</h4></div>
                                    <div class="property-address"><?//= $property['address'] ?>
                                    mg colony, ward no. 15, lajpat nagar, Benglur</div>
                                    <div class="property-gender">
                                        <?php
                                        //if ($property['gender'] == "male") {
                                        ?>
                                        <img id="male" src="img/male.png">
                                        <?php
                                        // } elseif ($property['gender'] == "female") {
                                        ?>
                                        <img id="female" src="img/female.png">
                                        <?php
                                        //  } else {
                                        ?>
                                        <img id="unisex" src="img/unisex.png">
                                        <?php
                                        //  }
                                        ?>
                                    </div>
                                    
                                    <div class="rent">
                                        <div class="rent-container">
                                             <div class="rent">₹ <?//= number_format($property['rent']) ?>/-</div>
                                            <div class="rent-unit">per month</div>
                                        </div>

                                        <div class="button-container">
                                        <a href="property_detail.php?property_id=<?//= $property['id'] ?>" class="btn btn-primary">View</a>
                                        </div>
                                    </div>    
                                </div>
                            </div>
                        </div>
                    </div>
                <?php
            //    }
                ?>
            
        </div>
    <?php
 //   }
    ?>

    <?php
    include "includes/footer.php";
    ?>
</body>
</html>