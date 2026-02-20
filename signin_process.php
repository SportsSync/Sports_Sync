<?php 
    // Import PHPMailer classes
    use PHPMailer\PHPMailer\PHPMailer;
    use PHPMailer\PHPMailer\Exception;

    require 'PHPMailer/src/Exception.php';
    require 'PHPMailer/src/PHPMailer.php';
    require 'PHPMailer/src/SMTP.php';

    include('db.php');
    include_once('otp_service.php'); 
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
            
            // ADMIN LOGIN LOGIC Admin@Core2026
            if($row['role'] == "admin") {
                if(password_verify($password, $row["password"])) {
                    sendOTP('core.crew07@gmail.com');
                    echo "admin_otp";
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