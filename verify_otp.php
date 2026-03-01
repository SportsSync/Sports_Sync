<?php
session_start();
require_once 'otp_service.php'; // required for resend

if (!isset($_SESSION['otp'])) {
    header("Location: signin.php");
    exit();
}

$error = "";

if ($_SERVER['REQUEST_METHOD'] === 'POST') {

    // Handle Resend
    if (isset($_POST['resend'])) {
        sendOTP($_SESSION['otp']['email'], $_SESSION['otp']['purpose']);
        $error = "New OTP sent successfully.";
    }

    // Handle Verify
    if (isset($_POST['verify'])) {

        // Check expiry
        if (time() > $_SESSION['otp']['expires_at']) {
            $error = "OTP expired. Please resend.";
        }
        else {

            // Limit attempts
            $_SESSION['otp']['attempts']++;

            if ($_SESSION['otp']['attempts'] > 5) {
                unset($_SESSION['otp']);
                $error = "Too many attempts. Login again.";
            }
            else if ($_POST['otp'] == $_SESSION['otp']['code']) {

                $_SESSION['email'] = $_SESSION['otp']['email'];
                $_SESSION['role'] = 'admin';
                $_SESSION['admin'] = true;

                unset($_SESSION['otp']);

                header("Location: admin/dashboard.php");
                exit();
            }
            else {
                $error = "Invalid OTP.";
            }
        }
    }
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Verify OTP - Sport Sync</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        /* Reusing your existing theme */
        body { background-image: url('images/bg4.jpeg'); background-size: cover; color: #F1F1F1; font-family: 'Segoe UI', sans-serif; }
        .signin-box { background-color: rgba(0, 0, 0, 0.85); padding: 40px; border-radius: 16px; max-width: 450px; margin: 100px auto; box-shadow: 0 8px 16px rgba(0,0,0,0.6); text-align: center; }
        h1 { color: #eb7e25; margin-bottom: 20px; }
        .btn-custom { background-color: #eb7e25; color: #000; font-weight: 400; }
        .form-control { text-align: center; font-size: 1.5rem; letter-spacing: 5px; }
    </style>
</head>
<body>
    <div class="signin-box">
        <h1>Verify OTP</h1>
        <p>A code has been sent to the registered admin email.</p>
        <form method="post">
            <input type="text" name="otp" class="form-control mb-3" placeholder="Enter OTP here" maxlength="6">
            <div id="timer" class="mb-3 text-warning fw-bold"></div>
            <?php if(isset($error)) echo "<p class='text-danger'>$error</p>"; ?>
            <button type="submit" name="verify" class="btn btn-custom w-100">Verify & Enter Dashboard</button><br><br>
            <button type="submit" name="resend" class="btn btn-outline-light w-100">
                Resend OTP
            </button>
        </form>
    </div>
    <script>
    let expiryTime = <?php echo $_SESSION['otp']['expires_at']; ?> * 1000;

    function updateTimer() {
        let now = new Date().getTime();
        let distance = expiryTime - now;

        if (distance <= 0) {
            document.getElementById("timer").innerHTML = "OTP Expired";
            return;
        }

        let minutes = Math.floor((distance % (1000 * 60 * 60)) / (1000 * 60));
        let seconds = Math.floor((distance % (1000 * 60)) / 1000);

        document.getElementById("timer").innerHTML =
            "Expires in: " + minutes + "m " + seconds + "s";

        setTimeout(updateTimer, 1000);
    }

    updateTimer();
</script>
</body>
</html>