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
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Forgot Password</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.5/font/bootstrap-icons.css">
    <link rel="shortcut icon" href="favicon.png" type="image/png">
    <style>
        body {
            margin: 0;
            min-height: 100vh;
            background: #f7f5fb;
            color: #1f1f1f;
            font-family: 'Segoe UI', sans-serif;
        }

        .auth-shell {
            min-height: 100vh;
            display: flex;
        }

        .auth-panel {
            width: 68%;
            background: #ffffff;
            padding: 38px 42px;
            display: flex;
            flex-direction: column;
        }

        .brand {
            font-size: 2rem;
            font-style: italic;
            font-weight: 700;
            color: #111111;
            margin-bottom: 30px;
            font-family: Georgia, serif;
        }

        .auth-content {
            flex: 1;
            display: flex;
            align-items: center;
            justify-content: center;
        }

        .forgot-box {
            width: 100%;
            max-width: 430px;
        }

        .forgot-icon {
            width: 72px;
            height: 72px;
            border-radius: 50%;
            border: 3px solid #d85ae0;
            margin: 0 auto 22px;
            display: flex;
            align-items: center;
            justify-content: center;
            color: #d85ae0;
            font-size: 2rem;
        }

        h1 {
            text-align: center;
            color: #0e1330;
            margin-bottom: 14px;
            font-weight: 700;
            font-size: 2.3rem;
        }

        .intro-text {
            font-size: 1.02rem;
            line-height: 1.7;
            color: #5f6280;
            text-align: center;
            margin: 0 0 26px;
        }

        .helper-copy {
            width: 100%;
            background: #eef5fb;
            border: 2px solid #1f71bc;
            border-radius: 999px;
            padding: 14px 18px;
            display: flex;
            align-items: center;
            justify-content: center;
            gap: 12px;
            color: #39445f;
            font-weight: 600;
            margin-bottom: 22px;
            text-align: center;
        }

        .helper-copy i {
            font-size: 1.2rem;
        }

        .divider {
            text-align: center;
            color: #8a87a6;
            margin: 6px 0 22px;
        }

        .form-control {
            border-radius: 14px;
            padding: 14px 16px;
            border: 1px solid #d9deeb;
            box-shadow: none;
        }

        .form-control:focus {
            border-color: #a25ddc;
            box-shadow: 0 0 0 0.15rem rgba(162, 93, 220, 0.14);
        }

        .form-label {
            color: #1c2140;
            font-weight: 600;
            margin-bottom: 8px;
        }

        .btn-custom {
            background: #12112c;
            color: #fff;
            font-weight: 600;
            transition: all 0.3s;
            border-radius: 999px;
            padding: 14px 18px;
            border: none;
        }

        .btn-custom:hover {
            background: #23214a;
            color: #fff;
        }

        .secondary-actions {
            display: flex;
            gap: 12px;
            margin-top: 14px;
        }

        .btn-outline-action {
            border-radius: 999px;
            padding: 14px 18px;
            font-weight: 600;
            border: 1px solid #d9deeb;
            background: #ffffff;
            color: #1c2140;
            text-decoration: none;
            text-align: center;
        }

        .btn-outline-action:hover {
            background: #f4f2fb;
            color: #1c2140;
            border-color: #a25ddc;
        }

        .error-msg {
            color: #d7263d;
            font-size: 13px;
            margin-bottom: 12px;
            text-align: center;
        }

        .password-note {
            font-size: 12px;
            color: #7f8298;
            margin-top: 8px;
        }

        .forgot-footer {
            text-align: center;
            color: #8a87a6;
            font-size: 0.93rem;
            margin-top: 24px;
        }

        .forgot-footer a {
            color: #7265aa;
        }

        .auth-visual {
            width: 32%;
            min-height: 100vh;
            background: url('images/signinbg2.jpg') center/cover no-repeat;
            position: relative;
            overflow: hidden;
        }

        .auth-visual::after {
            content: "";
            position: absolute;
            inset: 0;
        }

        .visual-credit {
            position: absolute;
            right: 24px;
            bottom: 20px;
            color: rgba(255, 255, 255, 0.9);
            font-size: 0.95rem;
            z-index: 1;
        }

        @media (max-width: 991px) {
            .auth-shell {
                flex-direction: column;
            }

            .auth-panel,
            .auth-visual {
                width: 100%;
            }

            .auth-visual {
                min-height: 280px;
            }

            .auth-panel {
                padding: 28px 20px 36px;
            }

            .brand {
                margin-bottom: 20px;
            }

            .secondary-actions {
                flex-direction: column;
            }
        }
    </style>
</head>

<body>
    <div class="auth-shell">
        <div class="auth-panel">
            <div class="brand">Sportsync</div>
            <div class="auth-content">
                <div class="forgot-box">
                    <div class="forgot-icon">
                        <i class="bi bi-key-fill"></i>
                    </div>
                    <h1>Reset Password</h1>
                    <p class="intro-text">
                        Recover your account securely and get back into Sportsync in just a few steps.
                    </p>
                    <div class="helper-copy">
                        <i class="bi bi-shield-lock"></i>
                        <?php if ($step == 1): ?>
                            Enter your registered email to receive an OTP
                        <?php elseif ($step == 2): ?>
                            Check your email and enter the verification code
                        <?php else: ?>
                            Set a new password for your account
                        <?php endif; ?>
                    </div>
                    <div class="divider">secure recovery</div>

                    <?php if ($error != ""): ?>
                        <div class="error-msg"><?= htmlspecialchars($error) ?></div>
                    <?php endif; ?>

                    <?php if ($step == 1): ?>
                        <form method="POST">
                            <div class="mb-3">
                                <label for="email" class="form-label">E-Mail :</label>
                                <input type="email" class="form-control" id="email" name="email" placeholder="Enter Your Registered Email" required>
                            </div>
                            <button type="submit" name="send_otp" class="btn btn-custom w-100">Send OTP</button>
                            <div class="secondary-actions">
                                <a href="signin.php" class="btn btn-outline-action w-100">Back To Sign In</a>
                                <a href="index.php" class="btn btn-outline-action w-100">Back</a>
                            </div>
                        </form>
                    <?php endif; ?>

                    <?php if ($step == 2): ?>
                        <form method="POST">
                            <div class="mb-3">
                                <label for="otp" class="form-label">OTP :</label>
                                <input type="text" class="form-control" id="otp" name="otp" placeholder="Enter OTP" required>
                            </div>
                            <button type="submit" name="verify_otp" class="btn btn-custom w-100">Verify OTP</button>
                            <div class="secondary-actions">
                                <a href="forgot_password.php" class="btn btn-outline-action w-100">Start Again</a>
                                <a href="signin.php" class="btn btn-outline-action w-100">Back To Sign In</a>
                            </div>
                        </form>
                    <?php endif; ?>

                    <?php if ($step == 3): ?>
                        <form method="POST" onsubmit="return validatePassword()">
                            <div class="mb-3">
                                <label for="pass" class="form-label">New Password :</label>
                                <input type="password" class="form-control" id="pass" name="password" placeholder="Enter New Password" required>
                            </div>
                            <div class="mb-3">
                                <label for="confirm" class="form-label">Confirm Password :</label>
                                <input type="password" class="form-control" id="confirm" name="confirm_password" placeholder="Confirm New Password" required>
                                <div class="password-note">Use a strong password with uppercase, lowercase, number, and special character.</div>
                            </div>
                            <button type="submit" name="reset_password" class="btn btn-custom w-100">Reset Password</button>
                            <div class="secondary-actions">
                                <a href="signin.php" class="btn btn-outline-action w-100">Back To Sign In</a>
                                <a href="index.php" class="btn btn-outline-action w-100">Back</a>
                            </div>
                        </form>
                    <?php endif; ?>

                    <div class="forgot-footer">
                        Remembered your password? <a href="signin.php">Sign in</a>
                    </div>
                </div>
            </div>
        </div>
        <div class="auth-visual">
            <div class="visual-credit">@lebich</div>
        </div>
    </div>

    <script>
        function validatePassword() {
            let p = document.getElementById("pass").value;
            let c = document.getElementById("confirm").value;

            if (p !== c) {
                alert("Passwords do not match");
                return false;
            }
            return true;
        }
    </script>
</body>

</html>
