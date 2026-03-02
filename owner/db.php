<?php
//$conn = mysqli_connect("localhost", "root", "root", "turf_booking_system",3307);

  //  if (!$conn) {
    //    die("Connection failed: " . mysqli_connect_error());
    //}
    // if($conn){
    //     echo "connected";
    // }
  

$host = "hopper.proxy.rlwy.net";
$port = 21377;
$user = "root";
$password = "vmnBiktDcQljzcKjbPTKEmyqGcPPxeIr";
$dbname = "turf_booking_system";
    $conn=mysqli_connect($host,$username,$password,$dbname,$port);
    if(!$conn)
    {
        die("Connection failed: " . mysqli_connect_error());
    }
?>