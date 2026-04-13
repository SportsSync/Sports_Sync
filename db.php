<?php
  
// $host = "hopper.proxy.rlwy.net";
// $port = 21377;
// $user = "root";
// $password = "vmnBiktDcQljzcKjbPTKEmyqGcPPxeIr";
// $dbname = "turf_booking_system";
//     $conn=mysqli_connect($host,$user,$password,$dbname,$port);
//     if(!$conn)
//     {
//         die("Connection failed: " . mysqli_connect_error());
//     }
include_once('env.php');
    $conn=mysqli_connect($host,$username,$password,$dbname,$port);
    if(!$conn)
    {
        die("Connection failed: " . mysqli_connect_error());
    }
?>