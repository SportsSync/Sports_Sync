<?php 
    // Import PHPMailer classes
    use PHPMailer\PHPMailer\PHPMailer;
    use PHPMailer\PHPMailer\Exception;

    require 'PHPMailer/src/Exception.php';
    require 'PHPMailer/src/PHPMailer.php';
    require 'PHPMailer/src/SMTP.php';

    include('db.php'); 
    session_start(); 
    
    // Ensure no extra spaces are sent to AJAX
    ob_clean();

    if($_SERVER['REQUEST_METHOD']=="POST") 
    { 
        $email = mysqli_real_escape_string($conn, $_POST['email']); 
        $password = $_POST['password']; 
        
        $sql = "SELECT * FROM user WHERE email='$email'"; 
        $result = mysqli_query($conn, $sql); 
        
        if(mysqli_num_rows($result) == 1) { 
            $row = mysqli_fetch_array($result); 
            
            // ADMIN LOGIN LOGIC
            if($email == "admin@company.com" && $row['role'] == "admin") {
                if($password === "Admin@Core2026") {
                    $otp = rand(100000, 999999);
                    $_SESSION['temp_admin_email'] = $email;
                    $_SESSION['admin_otp'] = $otp;
                    
                    // START PHPMAILER
                    $mail = new PHPMailer(true);
                    try {
                        $mail->isSMTP();
                        $mail->Host       = 'smtp.gmail.com';
                        $mail->SMTPAuth   = true;
                        $mail->Username   = 'core.crew07@gmail.com'; // Your Gmail address
                        $mail->Password   = 'witnctqhffowaxyn'; // The code from Step 2
                        $mail->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS;
                        $mail->Port       = 587;

                        $mail->setFrom('YOUR_GMAIL@gmail.com', 'Sport Sync Admin');
                        $mail->addAddress('core.crew07@gmail.com');

                        $mail->isHTML(true);
                        $mail->Subject = 'Admin Login OTP - Sport Sync';
                        $mail->Body    = "<h3>Verification Required</h3><p>Your Admin verification code is: <b>$otp</b></p>";

                        $mail->send();
                        echo "admin_otp";
                    } catch (Exception $e) {
                        // If mail fails, show the error so you can debug
                        echo "Mail Error: {$mail->ErrorInfo}";
                    }
                    exit();
                } else {
                    echo "not success";
                    exit();
                }
            }

            // USER / VENDOR LOGIN LOGIC
            if(password_verify($password, $row["password"])){ 
                $_SESSION['email'] = $email; 
                $_SESSION['mobile'] = $row["mobile"]; 
                $_SESSION['name'] = $row["name"];
                $_SESSION['user_id'] = $row["id"]; 
                $_SESSION['role'] = $row["role"]; 
                echo "success"; 
            } else { 
                echo "not success"; 
            } 
        } else { 
            echo "Invalid Email Or Password"; 
        } 
    } 
?>