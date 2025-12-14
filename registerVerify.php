<?php
session_start();
//Import PHPMailer classes into the global namespace
//These must be at the top of your script, not inside a function
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;
$name=$email=$mobile=$password="";
//required files
require 'phpMailer/src/Exception.php';
require 'phpMailer/src/PHPMailer.php';
require 'phpMailer/src/SMTP.php';
//Create an instance; passing `true` enables exceptions
if (isset($_POST["send"])) {
    $name = $_POST['name'];
    $email = $_POST['email'];
    $mobile = $_POST['number'];
    $password = $_POST['password'];
    $code  = rand(100000,999999);
    $_SESSION["code"] = $code;
    $mail = new PHPMailer(true);
    //Server settings
    $mail->isSMTP();                              //Send using SMTP
    $mail->Host       = 'smtp.gmail.com';       //Set the SMTP server to send through
    $mail->SMTPAuth   = true;             //Enable SMTP authentication
    $mail->Username   = 'core.crew07@gmail.com';   //SMTP write your email
    $mail->Password   = 'thtzcfwpdgrtbrez';      //SMTP password
    $mail->SMTPSecure = 'ssl';            //Enable implicit SSL encryption
    $mail->Port       = 465;                                    
    //Recipients
    $mail->setFrom( "core.crew07@gmail.com", 'SportsSync Team'); // Sender Email and name
    $mail->addAddress($email);     //Add a recipient email  
    $mail->addReplyTo('core.crew07@gmail.com', 'SportsSync Team'); // reply to sender email
    //Content
    $mail->isHTML(true);               //Set email format to HTML
    $mail->Subject = "Your Registration Code";   // email subject headings
    $mail->Body = "Your Registration Code is $code"; //email message
    // Success sent message alert
    if(!$mail->send()){
        echo "<script>alert('You entered Invalid Email!');
        document.location.href = 'signup.php';</script>";
    }else{
        echo
        "<script> 
        alert('Message was sent successfully!');
        </script>";
    }
}
if(isset($_POST["verify"])){
    $vcode = $_POST["vcode"];

    if($vcode == $_SESSION["code"]){
        include_once("db.php");
    $name = $_POST['reg_name'];
    $email = $_POST['reg_email'];
    $mobile = $_POST['reg_number'];
    $password = $_POST['reg_password'];
    $sql = "INSERT INTO user (name, email, mobile, password) VALUES ('$name', '$email', '$mobile', '$password')";
    if (mysqli_query($conn, query: $sql)) {
        echo "<script>alert('Successfully Registered')</script>";
        header("Location: signin.php");
        exit;
    } else {
        echo "<script>alert('Error: " . mysqli_error($conn) . "');</script>";
    }
    mysqli_close($conn);
    }else{
        echo "<script>alert('You Entered Invalid code')</script>";
    }
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
</head>
<body>
    <form method="post" action="#">
        <input type="hidden" name="reg_name" value="<?php echo $name?>">
        <input type="hidden" name="reg_email" value="<?php echo $email?>">
        <input type="hidden" name="reg_number" value="<?php echo $mobile?>">
        <input type="hidden" name="reg_password" value="<?php echo $password?>">
        Enter Your Registration Code : 
        <input placeholder="Your code" name="vcode" type="text" autofocus>
        <input type="submit" name="verify" value="Verify">
    </form>
</body>
</html>