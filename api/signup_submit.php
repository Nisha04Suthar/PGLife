<?php
    require("../includes/database_connect.php");

    $full_name = $_POST['full_name'];
    $phone = $_POST['phone'];
    $email = $_POST['email'];
    $password = $_POST['password'];
    $password = sha1($password);
   //  $college_name = $_POST['college_name'];
    $gender = $_POST['gender'];

    $sql = "SELECT * FROM users WHERE email='$email'";
    $result = mysqli_query($conn, $sql);
    if(!$result){
       $response = array("success" => false, "message" => "Something went wrong!");
       echo json_encode($response);
       return;
    }

    $row_count = mysqli_num_rows($result);
    if($row_count !=0){
       $response = array("success" => false, "message" =>"This email is already registered with us!");
       echo json_encode($response);
       return;
    }

    $sql = "INSERT INTO users(email, password, full_name, phone, gender)VALUES('$email','$password','$full_name', '$phone', '$gender')";
    $result = mysqli_query($conn,$sql);
    if(!$result){
       $response = array("success" => false, "message" =>"Something went wrong!");
       echo json_encode($response);
       return;
    }

    $response = array("success" => false, "message" =>"Your account has been successfully created!");
       echo json_encode($response);
       mysqli_close($conn);
    ?>
   