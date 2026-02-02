<?php
session_start();
if(!isset($_SESSION['admin_otp'])) { header("Location: signin.php"); exit(); }

if($_POST['otp'] == $_SESSION['admin_otp']) {
    $_SESSION['email'] = $_SESSION['temp_admin_email'];
    $_SESSION['role'] = 'admin';
    $_SESSION['admin'] = true; // Add this line to satisfy your admin files
    unset($_SESSION['admin_otp'], $_SESSION['temp_admin_email']);
    header("Location: admin/dashboard.php");
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
        .btn-custom { background-color: #eb7e25; color: #000; font-weight: 600; }
        .form-control { text-align: center; font-size: 1.5rem; letter-spacing: 5px; }
    </style>
</head>
<body>
    <div class="signin-box">
        <h1>Verify OTP</h1>
        <p>A code has been sent to the registered admin email.</p>
        <form method="post">
            <input type="text" name="otp" class="form-control mb-3" placeholder="000000" required maxlength="6">
            <?php if(isset($error)) echo "<p class='text-danger'>$error</p>"; ?>
            <button type="submit" name="verify" class="btn btn-custom w-100">Verify & Enter Dashboard</button>
        </form>
    </div>
</body>
</html>