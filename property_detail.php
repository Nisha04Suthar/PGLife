<?php
    session_start();
    require "includes/database_connect.php";
    
    if (isset($_GET['property_id'])) {
        $property_id = $_GET['property_id'];
    } else {
        die("Property ID is missing in the request.");
    }

    $user_id = isset($_SESSION['user_id']) ? $_SESSION['user_id'] : NULL;
    $property_id = $_GET["property_id"];
    
    $sql_1 = "SELECT *, p.id AS property_id, p.name AS property_name, c.name AS city_name 
                FROM properties p
                INNER JOIN cities c ON p.city_id = c.id 
                WHERE p.id = $property_id";
    $result_1 = mysqli_query($conn, $sql_1);
    if (!$result_1) {
        echo "Something went wrong!";
        return;
    }
    $property = mysqli_fetch_assoc($result_1);
    if (!$property) {
        echo "Something went wrong!";
        return;
    }
    
    
    $sql_2 = "SELECT * FROM testimonials WHERE property_id = $property_id";
    $result_2 = mysqli_query($conn, $sql_2);
    if (!$result_2) {
        echo "Something went wrong!";
        return;
    }
    $testimonials = mysqli_fetch_all($result_2, MYSQLI_ASSOC);
    
    
    $sql_3 = "SELECT a.* 
                FROM amenities a
                INNER JOIN properties_amenities pa ON a.id = pa.amenity_id
                WHERE pa.property_id = $property_id";
    $result_3 = mysqli_query($conn, $sql_3);
    if (!$result_3) {
        echo "Something went wrong!";
        return;
    }
    $amenities = mysqli_fetch_all($result_3, MYSQLI_ASSOC);
    
    
    $sql_4 = "SELECT * FROM interested_users_properties WHERE property_id = $property_id";
    $result_4 = mysqli_query($conn, $sql_4);
    if (!$result_4) {
        echo "Something went wrong!";
        return;
    }
    $interested_users = mysqli_fetch_all($result_4, MYSQLI_ASSOC);
    $interested_users_count = mysqli_num_rows($result_4);
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>property <? = $property['property_name'];?>| PGLife</title> 

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
    
 
    <link rel="stylesheet" href="css/bootstrap.min.css" />
    <link rel="stylesheet" href="css/PGdetail.css" />
    <link href="https://fonts.googleapis.com/css2?family=Open+Sans&display=swap" rel="stylesheet">
    <script src="https://kit.fontawesome.com/2cbc822d11.js" crossorigin="anonymous"></script>

</head>

<body>

    <?php
    include "includes/header.php";
    ?>

    <nav aria-label="breadcrumb">
        <ol class="breadcrumb py-2">
            <li class="breadcrumb-item">
                <a href="Homepage.php">Home</a>
            </li>
            <li class="breadcrumb-item active" aria-current="page">
                <a href="property_list.php?city=<?= $property['city_name']; ?>"><?= $property['city_name']; ?></a>
            </li>
            <li class="breadcrumb-item active" aria-current="page">
                <?= $property['property_name']; ?>
            </li>
        </ol>
    </nav>

    <div id="property-images" class="carousel slide" data-ride="carousel">
        <ol class="carousel-indicators">
        <?php
            $property_images = glob("img/properties/" . $property['property_id'] . "/*");
            foreach ($property_images as $index => $property_image) {
            ?>
                <li data-target="#property-images" data-slide-to="<?= $index ?>" class="<?= $index == 0 ? "active" : ""; ?>"></li>
            <?php
            }
            ?>
        </ol>
        <div class="carousel-inner">
            <?php
            foreach ($property_images as $index => $property_image) {
            ?>
                <div class="carousel-item <?= $index == 0 ? "active" : ""; ?>">
                    <img class="d-block w-100" src="<?= $property_image ?>" alt="slide">
                </div>
            <?php
            }
            ?>
        </div>
        <a class="carousel-control-prev" href="#property-images" role="button" data-slide="prev">
            <span class="carousel-control-prev-icon" aria-hidden="true"></span>
            <span class="sr-only">Previous</span>
        </a>
        <a class="carousel-control-next" href="#property-images" role="button" data-slide="next">
            <span class="carousel-control-next-icon" aria-hidden="true"></span>
            <span class="sr-only">Next</span>
        </a>
    </div>

    <div class="property-summary page-container">
        <div class="row no-gutters justify-content-between">
            <?php
            $total_rating = ($property['rating_clean'] + $property['rating_food'] + $property['rating_safety']) / 3;
            $total_rating = round($total_rating, 1);
            ?>
            <div class="star-container" title="<?= $total_rating ?>">
                <?php
                $rating = $total_rating;
                for ($i = 0; $i < 5; $i++) {
                    if ($rating >= $i + 0.8) {
                ?>
                        <i class="fas fa-star"></i>
                    <?php
                    } elseif ($rating >= $i + 0.3) {
                    ?>
                        <i class="fas fa-star-half-alt"></i>
                    <?php
                    } else {
                    ?>
                        <i class="far fa-star"></i>
                <?php
                    }
                }
                ?>
            </div>
            <div class="interested-container">
                <?php
                $is_interested = false;
                foreach ($interested_users as $interested_user) {
                    if ($interested_user['user_id'] == $user_id) {
                        $is_interested = true;
                    }
                }

                if ($is_interested) {
                ?>
                    <i class="is-interested-image fas fa-heart"></i>
                <?php
                } else {
                ?>
                    <i class="is-interested-image far fa-heart"></i>
                <?php
                }
                ?>
                <div class="interested-text">
                    <span class="interested-user-count"><?= $interested_users_count ?></span> interested
                </div>
            </div>
        </div>
        <div class="detail-container">
            <div class="property-name"><?= $property['property_name'] ?></div>
            <div class="property-address"><?= $property['address'] ?></div>
            <div class="property-gender">
                <?php
                if ($property['gender'] == "male") {
                ?>
                    <img src="img/male.png">
                <?php
                } elseif ($property['gender'] == "female") {
                ?>
                    <img src="img/female.png">
                <?php
                } else {
                ?>
                    <img src="img/unisex.png">
                <?php
                }
                ?>
            </div>
        </div>
        <div class="row no-gutters">
            <div class="rent-container col-6">
                <div class="rent">₹ <?= number_format($property['rent']) ?>/-</div>
                <div class="rent-unit">per month</div>
            </div>
            <div class="button-container col-6">
                <a href="#" class="btn">Book Now</a>
            </div>
        </div>
    </div>

    <div class="property-amenities">
        <div class="page-container">
            <h1>Amenities</h1>
            <div class="row justify-content-between">
                <div class="col-md-auto">
                    <h5>Building</h5>
                    <?php
                    foreach ($amenities as $amenity) {
                        if ($amenity['type'] == "Building") {
                    ?>
                            <div class="amenity-container">
                                <img src="img/amenities/<?= $amenity['icon'] ?>.svg">
                                <span><?= $amenity['name'] ?></span>
                            </div>
                    <?php
                        }
                    }
                    ?>
                </div>

                <div class="col-md-auto">
                    <h5>Common Area</h5>
                    <?php
                    foreach ($amenities as $amenity) {
                        if ($amenity['type'] == "Common Area") {
                    ?>
                            <div class="amenity-container">
                                <img src="img/amenities/<?= $amenity['icon'] ?>.svg">
                                <span><?= $amenity['name'] ?></span>
                            </div>
                    <?php
                        }
                    }
                    ?>
                </div>

                <div class="col-md-auto">
                    <h5>Bedroom</h5>
                    <?php
                    foreach ($amenities as $amenity) {
                        if ($amenity['type'] == "Bedroom") {
                    ?>
                            <div class="amenity-container">
                                <img src="img/amenities/<?= $amenity['icon'] ?>.svg">
                                <span><?= $amenity['name'] ?></span>
                            </div>
                    <?php
                        }
                    }
                    ?>
                </div>

                <div class="col-md-auto">
                    <h5>Washroom</h5>
                    <?php
                    foreach ($amenities as $amenity) {
                        if ($amenity['type'] == "Washroom") {
                    ?>
                            <div class="amenity-container">
                                <img src="img/amenities/<?= $amenity['icon'] ?>.svg">
                                <span><?= $amenity['name'] ?></span>
                            </div>
                    <?php
                        }
                    }
                    ?>
                </div>
            </div>
        </div>
    </div>

    <div class="property-about page-container">
        <h1>About the Property</h1>
        <p><?= $property['description'] ?></p>
    </div>

    <div class="property-rating">
        <div class="page-container">
            <h1>Property Rating</h1>
            <div class="row align-items-center justify-content-between">
                <div class="col-md-6">
                    <div class="rating-criteria row">
                        <div class="col-6">
                            <i class="rating-criteria-icon fas fa-broom"></i>
                            <span class="rating-criteria-text">Cleanliness</span>
                        </div>
                        <div class="rating-criteria-star-container col-6" title="<?= $property['rating_clean'] ?>">
                            <?php
                            $rating = $property['rating_clean'];
                            for ($i = 0; $i < 5; $i++) {
                                if ($rating >= $i + 0.8) {
                            ?>
                                    <i class="fas fa-star"></i>
                                <?php
                                } elseif ($rating >= $i + 0.3) {
                                ?>
                                    <i class="fas fa-star-half-alt"></i>
                                <?php
                                } else {
                                ?>
                                    <i class="far fa-star"></i>
                            <?php
                                }
                            }
                            ?>
                        </div>
                    </div>

                    <div class="rating-criteria row">
                        <div class="col-6">
                            <i class="rating-criteria-icon fas fa-utensils"></i>
                            <span class="rating-criteria-text">Food Quality</span>
                        </div>
                        <div class="rating-criteria-star-container col-6" title="<?= $property['rating_food'] ?>">
                            <?php
                            $rating = $property['rating_food'];
                            for ($i = 0; $i < 5; $i++) {
                                if ($rating >= $i + 0.8) {
                            ?>
                                    <i class="fas fa-star"></i>
                                <?php
                                } elseif ($rating >= $i + 0.3) {
                                ?>
                                    <i class="fas fa-star-half-alt"></i>
                                <?php
                                } else {
                                ?>
                                    <i class="far fa-star"></i>
                            <?php
                                }
                            }
                            ?>
                        </div>
                    </div>

                    <div class="rating-criteria row">
                        <div class="col-6">
                            <i class="rating-criteria-icon fa fa-lock"></i>
                            <span class="rating-criteria-text">Safety</span>
                        </div>
                        <div class="rating-criteria-star-container col-6" title="<?= $property['rating_safety'] ?>">
                            <?php
                            $rating = $property['rating_safety'];
                            for ($i = 0; $i < 5; $i++) {
                                if ($rating >= $i + 0.8) {
                            ?>
                                    <i class="fas fa-star"></i>
                                <?php
                                } elseif ($rating >= $i + 0.3) {
                                ?>
                                    <i class="fas fa-star-half-alt"></i>
                                <?php
                                } else {
                                ?>
                                    <i class="far fa-star"></i>
                            <?php
                                }
                            }
                            ?>
                        </div>
                    </div>
                </div>

                <div class="col-md-4">
                    <div class="rating-circle">
                        <?php
                        $total_rating = ($property['rating_clean'] + $property['rating_food'] + $property['rating_safety']) / 3;
                        $total_rating = round($total_rating, 1);
                        ?>
                        <div class="total-rating"><?= $total_rating ?></div>
                        <div class="rating-circle-star-container">
                            <?php
                            $rating = $total_rating;
                            for ($i = 0; $i < 5; $i++) {
                                if ($rating >= $i + 0.8) {
                            ?>
                                    <i class="fas fa-star"></i>
                                <?php
                                } elseif ($rating >= $i + 0.3) {
                                ?>
                                    <i class="fas fa-star-half-alt"></i>
                                <?php
                                } else {
                                ?>
                                    <i class="far fa-star"></i>
                            <?php
                                }
                            }
                            ?>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- <div id="carouselExampleControls" class="carousel slide" data-ride="carousel">
        <div class="carousel-inner">
            <div class="carousel-item active">
                <img src="img/properties/1/property 1.jpg" class="d-block w-100" alt="slide">
            </div>
            <div class="carousel-item">
                <img src="img/properties/1/property 2.jpg" class="d-block w-100" alt="slide">
            </div>
            <div class="carousel-item">
                <img src="img/properties/1/property 3.jpg" class="d-block w-100" alt="slide">
            </div>
        </div>
        <a class="carousel-control-prev" href="#property-images" role="button" data-slide="prev">
            <span class="carousel-control-prev-icon" aria-hidden="true"></span>
            <span class="sr-only">Previous</span>
        </a>
        <a class="carousel-control-next" href="#property-images" role="button" data-slide="next">
            <span class="carousel-control-next-icon" aria-hidden="true"></span>
            <span class="sr-only">Next</span>
        </a>
    </div> -->

    <!-- <div class="info">
        <div class="property-container col-9">
            <div class="container">
                <div class="star-container">
                    <i style="color:red;" class="fas fa-star"></i>
                    <i style="color:red;"class="fas fa-star"></i>
                    <i style="color:red;"class="fas fa-star"></i>
                    <i style="color:red;"class="fas fa-star"></i>
                    <i style="color:red;"class="fas fa-star"></i>
                </div>
                <div class="interested-container">
                    <i style="color:red;"class="is-interested-image far fa-heart"></i>
                    <div class="interested-text">
                        <span class="interested-star-count">6</span>interested
                    </div>
                </div>        
            </div>
            <div class="detail-container">
                <div class="property-name"><h1>Ganpati Paying guest<h1></div>
                <div class="property-address">Police Beat,Sainath Complex,Besides,SV rd,Daulat nagar,Borivali east,Mumbai-400066</div>
                <div class="property-gender">
                    <img class="gender" src="img/unisex.png"/>
                </div>
            </div>
            <div class="rent">
                <div class="rent-container">
                    <div class="rent-amount">Rs 8,500/-</div>
                    <div class="rent-unit">per month</div>
                </div>
                <div class="button">
                    <button>Book Now</button>
                </div>
            </div>
        </div>
    </div>   

    <div class="amenities-section">    
        <div class="amenities col-9" style="margin:0 auto;">
        <div class="col-9"><h1>Ameneties</h1></div>
        <div class="amenities-list">

            <div class="amn1">
                <div class="building">
                <ul>
                    <li class="abc">building</li><br>
                    <li><img class="amn-img" src="img/amenities/powerbackup.svg">power backup</li>
                    <li><img class="amn-img" src="img/amenities/lift.svg">lift</li>
                </ul>
            </div>
            </div>

            <div class="amn2">
                <div class="common-area">
                <ul>
                    <li class="abc">common area</li><br>
                    <li><img class="amn-img" src="img/amenities/wifi.svg">Wifi</li>
                    <li><img class="amn-img" src="img/amenities/tv.svg">TV</li>
                    <li><img class="amn-img" src="img/amenities/rowater.svg">Water Purifier</li>
                    </li><img class="amn-img" src="img/amenities/dining.svg">Dining</li>
                    <li><img class="amn-img" src="img/amenities/washingmachine.svg">Washing Mahine</li>
                </ul>
                </div>
            </div>

            <div class="amn3">
                <div class="bedroom">
                <ul>
                    <li class="abc">bedroom</li><br>
                    <li><img class="amn-img" src="img/amenities/bed.svg">Bed with Matress</li>
                    <li><img class="amn-img" src="img/amenities/ac.svg">Air Conditioner</li>
                </ul>
                </div>
            </div>

            <div class="amn4">
                <div class="washroom">
                <ul>
                    <li class="abc">Washroom</li><br>
                    <li><img class="amn-img" src="img/amenities/geyser.svg">Geyser</li>
                </ul>
                </div>
            </div>
        </div>
        </div>
    </div>

    <div class="about-property">
        <div class="abt-property col-9" style="margin:0 auto;">
        <h1>About the property</h1>
        <p> Furnished studio apartment - share it with close friends! Located in posh area of Bijwasan in Delhi, this
            house is available for both boys and girls.
            Go for a private room or opt for a shared one and make it your own abode. Go out with your new friends -
            catch a movie at the nearest cinema hall or
            just chill in a cafe which is not even 2 kms away. Unwind with your flatmates after a long day at
            work/college. With a common living area and a shared
            kitchen, make your own FRIENDS moments. After all, there's always a Joey with unlimited supply of food.
            Remember, all it needs is one crazy story to
            convert a roomie into a BFF. What's nearby/Your New Neighborhood 4.0 Kms from Dwarka Sector- 21 Metro
            Station.</p>
        </div>    
    </div>

    <div class="property-rating">
        <div class="prop-rating col-9" style="margin:0 auto;">
        <h1>Property Rating</h1>
        <div class="rating">
            <div class="rating-list">
                <div><i style="margin-right:10px;" class="fas fa-broom"></i>cleanliness
                    <i style="color:cyan;" class="fas fa-star"></i>
                    <i style="color:cyan;" class="fas fa-star"></i>
                    <i style="color:cyan;" class="fas fa-star"></i>
                    <i style="color:cyan;" class="fas fa-star"></i>
                    <i style="color:cyan;" class="fas fa-star"></i>
                </div>
                <div><i style="margin-right:10px;" class="fas fa-utensils"></i>Food Quality
                    <i style="color:cyan;" class="fas fa-star"></i>
                    <i style="color:cyan;" class="fas fa-star"></i>
                    <i style="color:cyan;" class="fas fa-star"></i>
                    <i style="color:cyan;" class="fas fa-star"></i>
                    <i style="color:cyan;" class="fas fa-star"></i>
                </div>
                <div><i style="margin-right:10px;" class="fas fa-lock"></i>Safety
                    <i style="color:cyan;" class="fas fa-star"></i>
                    <i style="color:cyan;" class="fas fa-star"></i>
                    <i style="color:cyan;" class="fas fa-star"></i>
                    <i style="color:cyan;" class="fas fa-star"></i>
                    <i style="color:cyan;" class="fas fa-star"></i>
                </div>
            </div>

            <div class="rating-circle">
                <div class="circle">
                    <div>
                    <h4 style="color:white;">5</h4>
                    </div>
                    <div>
                    <i style="color:white;" class="fas fa-star"></i>
                    <i style="color:white;" class="fas fa-star"></i>
                    <i style="color:white;" class="fas fa-star"></i>
                    <i style="color:white;" class="fas fa-star"></i>
                    <i style="color:white;" class="fas fa-star"></i>
                    </div>
                </div>
            </div>
        </div>
        </div>
    </div>

    <div class="people-say">
        <div class="sayings col-9" style="margin:0 auto;">
        <div>
            <h1>What People Say</h1>
        </div>

        <div class="people">
            <div class="say">
                <i class="fa fa-quote-left"></i>
                <p>You just have to arrive at the place, it's fully furnished and stocked with all basic amenities and
                    services and even your friends are welcome.
                    <br><span>- Ashutosh Gowariker</span>
                </p>
            </div>

            <div class="say">
                <i class="fa fa-quote-left"></i>
                <p> You just have to arrive at the place, it's fully furnished and stocked with all basic amenities and
                    services and even your friends are welcome.
                    <br><span>- Karan Johar</span>
                </p>
            </div>
        </div>
        </div>
    </div> -->

    <div class="property-testimonials page-container">
        <h1>What people say</h1>
        <?php
        foreach ($testimonials as $testimonial) {
        ?>
            <div class="testimonial-block">
                <div class="testimonial-image-container">
                    <img class="testimonial-img" src="img/man.png">
                </div>
                <div class="testimonial-text">
                    <i class="fa fa-quote-left" aria-hidden="true"></i>
                    <p><?= $testimonial['content'] ?></p>
                </div>
                <div class="testimonial-name">- <?= $testimonial['user_name'] ?></div>
            </div>
        <?php
        }
        ?>
    </div>

    <?php
    include "includes/footer.php";
    ?>

</body>

</html>