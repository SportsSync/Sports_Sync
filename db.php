<?php
//$conn = mysqli_connect("localhost", "root", "root", "turf_booking_system",3307);

  //  if (!$conn) {
    //    die("Connection failed: " . mysqli_connect_error());
    //}
    // if($conn){
    //     echo "connected";
    // }
    $host="127.0.0.1";
    $port = "3307";
    $username="root";
    $password="";
    $dbname="turf_booking_system";

    $conn=mysqli_connect($host,$username,$password,$dbname,$port);
    if(!$conn)
    {
        die("Connection failed: " . mysqli_connect_error());
    }
?>