<?php
include('db.php');
session_start();

if($_SERVER['REQUEST_METHOD']=="POST")
{
    $email=$_POST['email'];
    $password=$_POST['password'];

    $sql="select * from user where email='$email' and password='$password'";
    $result=mysqli_query($conn,$sql);

    if(mysqli_num_rows($result)==1)
    {
        $_SESSION['email']=$email;
        echo "success";
    }
    else{
        echo "Invalid Email Or Password";
    }
}
?>   