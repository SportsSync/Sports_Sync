<?php
include('db.php');
session_start();

if($_SERVER['REQUEST_METHOD']=="POST")
{
    $email=$_POST['email'];
    $password=$_POST['password'];

    $sql="select * from user where email='$email'";
    $result=mysqli_query($conn,$sql);

    if(mysqli_num_rows($result)==1)
    {
        $row = mysqli_fetch_array($result);
        if(password_verify($password,$row["password"])){
            $_SESSION['email']=$email;
            $_SESSION['user_id'] = $row["id"]; 
            echo "success";
        }else{
            echo "not success";
        }
    }
    else{
        echo "Invalid Email Or Password";
    }
}
?>   