<?php
session_start();

require_once 'db.php';
require_once 'otp_service.php';

if (isset($_POST['send'])) {
    $profileImagePath = NULL;

if(isset($_FILES['profile_photo']) && $_FILES['profile_photo']['error'] == 0){

    $allowedTypes = ['image/jpeg','image/png','image/jpg','image/webp'];

    if(in_array($_FILES['profile_photo']['type'], $allowedTypes)){

        if($_FILES['profile_photo']['size'] <= 5*1024*1024){

            $ext = pathinfo($_FILES['profile_photo']['name'], PATHINFO_EXTENSION);
            $newFileName = uniqid("USER_", true) . "." . $ext;

            $uploadDir = "user/profile/";

            if(!is_dir($uploadDir)){
                mkdir($uploadDir, 0777, true);
            }

            $uploadPath = $uploadDir . $newFileName;

            if(move_uploaded_file($_FILES['profile_photo']['tmp_name'], $uploadPath)){
                $profileImagePath = $uploadPath;
            }
        }
    }
}
    $_SESSION['reg_data'] = [
        'name'     => trim($_POST['name']),
        'email'    => trim($_POST['email']),
        'mobile'   => trim($_POST['number']),
        'password' => password_hash($_POST['password'], PASSWORD_DEFAULT),
        'profile'  => $profileImagePath
    ];

    $sent = sendOTP($_POST['email'], 'registration');

    if (!$sent) {
        $error = "Failed to send OTP. Please try again.";
    }
}

if (isset($_POST['verify'])) {

    $vcode = trim($_POST['vcode']);

    // OTP validation
    if (
        !isset($_SESSION['otp']) ||
        $_SESSION['otp']['purpose'] !== 'registration' ||
        time() > $_SESSION['otp']['expires_at']
    ) {
        $error = "OTP expired. Please register again.";
    }
    elseif ($vcode != $_SESSION['otp']['code']) {
        $error = "Invalid verification code";
        $_SESSION['otp']['attempts']++;
    }
    else {

        $reg = $_SESSION['reg_data'];

        // INSERT USING PREPARED STATEMENT
        $stmt = $conn->prepare(
            "INSERT INTO user (name, email, mobile, password, role,profile_image)
             VALUES (?, ?, ?, ?, 'User',?)"
        );

        $stmt->bind_param(
            "sssss",
            $reg['name'],
            $reg['email'],
            $reg['mobile'],
            $reg['password'],
            $reg['profile']
        );

        if ($stmt->execute()) {
            $success = true;
            unset($_SESSION['reg_data'], $_SESSION['otp']);
        } else {
            $error = "Database error. Try again.";
        }
    }
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="shortcut icon" href="favicon.png" type="image/png">
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