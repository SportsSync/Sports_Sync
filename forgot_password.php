<?php
session_start();
include("db.php");
include("otp_service.php");

$step = 1;
$error = "";

// STEP 1: EMAIL SUBMIT
if (isset($_POST['send_otp'])) {
    $email = mysqli_real_escape_string($conn, $_POST['email']);

    $check = mysqli_query($conn, "SELECT * FROM user WHERE email='$email'");

    if (mysqli_num_rows($check) == 0) {
        $error = "Email not registered. Please Sign Up.";
    } else {
        sendOTP($email, "forgot_password");
        $_SESSION['reset_email'] = $email;
        $step = 2;
    }
}

// STEP 2: OTP VERIFY
if (isset($_POST['verify_otp'])) {
    $otp = $_POST['otp'];

    if (
        isset($_SESSION['otp']) &&
        $_SESSION['otp']['code'] == $otp &&
        $_SESSION['otp']['purpose'] == "forgot_password" &&
        $_SESSION['otp']['expires_at'] > time()
    ) {
        $step = 3;
    } else {
        $error = "Invalid or expired OTP";
        $step = 2;
    }
}

// STEP 3: PASSWORD RESET
if (isset($_POST['reset_password'])) {
    $pass = $_POST['password'];
    $confirm = $_POST['confirm_password'];

    if ($pass !== $confirm) {
        $error = "Passwords do not match";
        $step = 3;
    } else {
        $hash = password_hash($pass, PASSWORD_DEFAULT);
        $email = $_SESSION['reset_email'];

        mysqli_query($conn, "UPDATE user SET password='$hash' WHERE email='$email'");

        unset($_SESSION['otp']);
        unset($_SESSION['reset_email']);

        header("Location: signin.php?reset=success");
        exit();
    }
}
?>
<?php if($error != ""): ?>
<div style="color:red; text-align:center; margin-bottom:10px;">
    <?= $error ?>
</div>
<?php endif; ?>

<!-- STEP 1 -->
<?php if($step == 1): ?>
<form method="POST">
    <input type="email" name="email" placeholder="Enter Email" required>
    <button name="send_otp">Send OTP</button>
</form>
<?php endif; ?>

<!-- STEP 2 -->
<?php if($step == 2): ?>
<form method="POST">
    <input type="text" name="otp" placeholder="Enter OTP" required>
    <button name="verify_otp">Verify OTP</button>
</form>
<?php endif; ?>

<!-- STEP 3 -->
<?php if($step == 3): ?>
<form method="POST" onsubmit="return validatePassword()">
    <input type="password" id="pass" name="password" placeholder="New Password" required>
    <input type="password" id="confirm" name="confirm_password" placeholder="Confirm Password" required>
    <button name="reset_password">Reset Password</button>
</form>

<script>
function validatePassword(){
    let p = document.getElementById("pass").value;
    let c = document.getElementById("confirm").value;

    if(p !== c){
        alert("Passwords do not match");
        return false;
    }
    return true;
}
</script>
<?php endif; ?>