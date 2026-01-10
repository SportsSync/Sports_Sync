<?php
//$conn = mysqli_connect("localhost", "root", "root", "turf_booking_system",3307);

  //  if (!$conn) {
    //    die("Connection failed: " . mysqli_connect_error());
    //}
    // if($conn){
    //     echo "connected";
    // }
    $host="localhost";
    $username="root";
    $password="";
    $dbname="turf_booking_system";
    $port=3307;

    $conn=mysqli_connect($host,$username,$password,$dbname,$port);
    if(!$conn)
    {
        die("Connection failed: " . mysqli_connect_error());
    }
   
?>