<?php

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

require_once 'PHPMailer/src/Exception.php';
require_once 'PHPMailer/src/PHPMailer.php';
require_once 'PHPMailer/src/SMTP.php';

function sendOTP($email, $purpose = 'general') {
    if (session_status() === PHP_SESSION_NONE) {
        session_start();
    }

    $otp = random_int(100000, 999999);

    $_SESSION['otp'] = [
        'code' => $otp,
        'email' => $email,
        'purpose' => $purpose,
        'expires_at' => time() + 300, // 5 minutes
        'attempts' => 0
    ];

    $mail = new PHPMailer(true);
    try {
        $mail->isSMTP();
        $mail->Host       = 'smtp.gmail.com';
        $mail->SMTPAuth   = true;
        $mail->Username   = 'core.crew07@gmail.com';
        $mail->Password   = 'thtzcfwpdgrtbrez';
        $mail->SMTPSecure = 'ssl';
        $mail->Port       = 465;

        $mail->setFrom('core.crew07@gmail.com', 'SportsSync Team');
        $mail->addAddress($email);

        $mail->isHTML(true);
        $mail->Subject = 'Your Verification Code';
        $mail->Body = "
            <h2>Verification Code</h2>
            <p>Your OTP is: <b>$otp</b></p>
            <p>This code expires in 5 minutes.</p>
        ";

        $mail->send();
        return true;
    } catch (Exception $e) {
        return false;
    }
}
