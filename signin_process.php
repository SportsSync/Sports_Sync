<?php
include('db.php');
session_start();

if($_SERVER['REQUEST_METHOD']=="POST")
{
    $email = $_POST['email'];
    $password = $_POST['password'];

    $sql = "SELECT * FROM user WHERE email='$email'";
    $result = mysqli_query($conn, $sql);

    if(mysqli_num_rows($result) == 1)
    {
        $row = mysqli_fetch_assoc($result);

        if(password_verify($password, $row['password']))
        {
            // COMMON SESSION (UNCHANGED)
            $_SESSION['email']   = $row['email'];
            $_SESSION['mobile']  = $row['mobile'];
            $_SESSION['name']    = $row['name'];
            $_SESSION['user_id'] = $row['id'];
            $_SESSION['role']    = $row['role'];

            // 🔐 ADMIN OTP LOGIC
            if($row['role'] === 'admin')
            {
                $otp = rand(100000,999999);
                $_SESSION['admin_otp'] = $otp;
                $_SESSION['otp_time']  = time();

                mail(
                  "core.crew07@gmail.com",
                  "Admin Login OTP",
                  "Your OTP is: $otp (valid 5 minutes)"
                );

                echo "admin_otp";
                exit;
            }

            // NORMAL USER / VENDOR
            echo "success";
            exit;
        }
    }

    echo "error";
}
?>
