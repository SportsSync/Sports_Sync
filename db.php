<?php

$host = "localhost";
$user = "root";
$password = "";
$dbname = "sports_sync"; 

    $conn=mysqli_connect("localhost","root","","turf_booking");

    if($conn)
    {
         die("Connection failed: " . mysqli_connect_error());
    }
?>