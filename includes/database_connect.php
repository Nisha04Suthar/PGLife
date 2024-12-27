<?php
$conn = mysqli_connect("127.0.0.1","root","","pglife");

if(mysqli_connect_error()) {
    echo "Failed to connect to MySQL! Please contact the admin.";
    return;
}