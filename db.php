<?php
$conn = mysqli_connect("localhost", "root", "", "turf_booking_system");

    if (!$conn) {
        die("Connection failed: " . mysqli_connect_error());
    }
    // if($conn){
    //     echo "connected";
    // }

?>