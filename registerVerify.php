<?php
session_start();
//Import PHPMailer classes into the global namespace
//These must be at the top of your script, not inside a function
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;
$email="";
//required files
require 'phpMailer/src/Exception.php';
require 'phpMailer/src/PHPMailer.php';
require 'phpMailer/src/SMTP.php';
//Create an instance; passing `true` enables exceptions
if (isset($_POST["send"])) {
    $_SESSION['reg_data'] = [
    'name'     => $_POST['name'],
    'email'    => $_POST['email'],
    'mobile'   => $_POST['number'],
    'password' => $_POST['password']
];
    $email = $_POST['email'];
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
    
    $reg = $_SESSION['reg_data'];

    $name     = $reg['name'];
    $email    = $reg['email'];
    $mobile   = $reg['mobile'];
    $password = trim($reg['password']);

    $hash = password_hash($password,PASSWORD_DEFAULT);
    $sql = "INSERT INTO user (name, email, mobile, password) VALUES ('$name', '$email', '$mobile', '$hash')";
    if (mysqli_query($conn, query: $sql)) {
       $success = true;
       unset($_SESSION['reg_data']);
    } else {
        $error = "Database Error!";
    }
    mysqli_close($conn);
    }else{
        $error = "Invalid verification code";
    }
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Verification</title>
    <style>
        /* RESET */
* {
    margin: 0;
    padding: 0;
    box-sizing: border-box;
    font-family: "Segoe UI", sans-serif;
}

/* BACKGROUND */
body {
    min-height: 100vh;
    background: url("images/bg4.jpeg") no-repeat center center/cover;
    display: flex;
    align-items: center;
    justify-content: center;
}

/* CONTAINER */
.verify-container {
    width: 100%;
    display: flex;
    justify-content: center;
    align-items: center;
}

/* CARD */
.verify-card {
    width: 380px;
    padding: 35px 30px;
    background: rgba(0, 0, 0, 0.65);
    backdrop-filter: blur(10px);
    border-radius: 14px;
    box-shadow: 0 15px 40px rgba(0,0,0,0.6);
    text-align: center;
}

/* HEADING */
.verify-card h2 {
    color: #ff8c1a;
    margin-bottom: 8px;
    font-size: 28px;
}

/* SUBTITLE */
.subtitle {
    color: #ccc;
    font-size: 14px;
    margin-bottom: 25px;
}

/* INPUT */
.verify-card input {
    width: 100%;
    padding: 14px;
    font-size: 18px;
    text-align: center;
    letter-spacing: 6px;
    border-radius: 8px;
    border: none;
    outline: none;
    margin-bottom: 22px;
}

/* BUTTON */
.verify-card button {
    width: 100%;
    padding: 14px;
    font-size: 16px;
    font-weight: 600;
    background: #ff8c1a;
    border: none;
    border-radius: 8px;
    color: #000;
    cursor: pointer;
    transition: 0.3s ease;
}

.verify-card button:hover {
    background: #ff9f40;
    transform: translateY(-1px);
}
/* MESSAGE OVERLAY */
.msg-overlay {
    position: fixed;
    inset: 0;
    background: rgba(0,0,0,0.75);
    display: none;
    align-items: center;
    justify-content: center;
    z-index: 9999;
}

.msg-box {
    background: #000;
    padding: 30px 40px;
    border-radius: 12px;
    text-align: center;
    color: #fff;
    box-shadow: 0 0 25px rgba(255,140,26,0.6);
}

.msg-box.success {
    border: 2px solid #ff8c1a;
}

.msg-box.error {
    border: 2px solid red;
}

.msg-box p {
    font-size: 16px;
    margin-top: 10px;
}

/* MOBILE */
@media (max-width: 420px) {
    .verify-card {
        width: 90%;
    }
}

    </style>
</head>
<body>
    <div class="verify-container">
    <div class="verify-card">
    <form method="post" action="#">
       <p class="subtitle">Enter the verification code sent to your email</p>
        <input placeholder="Your code" name="vcode" type="text" autofocus>
        <button type="submit" name="verify">Verify</button>
    </form>
    </div>
    </div>
    <div class="msg-overlay" id="msgBox">
    <div class="msg-box" id="msgContent">
        <p id="msgText"></p>
    </div>
</div>
<script>
<?php if(isset($success) && $success === true): ?>
    document.getElementById("msgBox").style.display = "flex";
    document.getElementById("msgContent").classList.add("success");
    document.getElementById("msgText").innerText =
        "Successfully verified! Redirecting to login...";

    setTimeout(() => {
        window.location.href = "signin.php";
    }, 1000);
<?php endif; ?>

<?php if(isset($error)): ?>
    document.getElementById("msgBox").style.display = "flex";
    document.getElementById("msgContent").classList.add("error");
    document.getElementById("msgText").innerText =
        "<?php echo $error; ?>";
     setTimeout(() => {
        msgBox.style.display = "none";
    }, 5000);
<?php endif; ?>
document.getElementById("msgBox").addEventListener("click", () => {
    document.getElementById("msgBox").style.display = "none";
});

document.addEventListener("keydown", () => {
    document.getElementById("msgBox").style.display = "none";
});

</script>

</body>
</html>