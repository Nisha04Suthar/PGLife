<?php
    $db_hostname="127.0.0.1";
    $db_username="root";
    $db_password="";
    $db_name="test";

    $conn = mysqli_connect($db_hostname,$db_username,$db_password,$db_name);
    if(!$conn){
        echo "Connection Failed:".mysqli_connect_error();
        exit;
    }

    $sql = "SELECT *  FROM users";

    $result = mysqli_query($conn,$sql);
    if(!$result){
        echo "Error:". mysqli_error($conn);
        exit;
    }

    while($row=mysqli_fetch_assoc($result)){
        echo $row['name']."<br/>";
    }
    mysqli_close($conn);
?>    