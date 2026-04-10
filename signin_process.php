<?php 
    // Import PHPMailer classes
    use PHPMailer\PHPMailer\PHPMailer;
    use PHPMailer\PHPMailer\Exception;

    require 'PHPMailer/src/Exception.php';
    require 'PHPMailer/src/PHPMailer.php';
    require 'PHPMailer/src/SMTP.php';

    include('db.php');
    include_once('otp_service.php');
    include_once('env.php'); 
    session_start(); 
    
    // Ensure no extra spaces are sent to AJAX
    ob_clean();

    if($_SERVER['REQUEST_METHOD']=="POST") 
    { 
        $email = mysqli_real_escape_string($conn, $_POST['email']); 
        $password = $_POST['password']; 
        
        $stmt = $conn->prepare("SELECT * FROM user WHERE email = ?");
        $stmt->bind_param("s", $email);
        $stmt->execute();
        $result = $stmt->get_result();
        
        if(mysqli_num_rows($result) == 1) { 
            $row = mysqli_fetch_array($result); 
            // 🚫 BLOCKED USER CHECK
            if(isset($row['status']) && $row['status'] == 'blocked'){
                echo "blocked";
                exit();
            }
            if($row['role'] == "admin") {
                if(password_verify($password, $row["password"])) {
                    $_SESSION['temp_admin_id'] = $row["id"];
                    sendOTP($adminEmail);
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
                $_SESSION['profile_image'] = $row["profile_image"];
                $_SESSION['user_id'] = $row["id"]; 
                $_SESSION['role'] = $row["role"]; 
                echo "success";
                exit(); 
            } else { 
                echo "not success"; 
                exit();
            } 
        } else { 
            echo "Invalid Email Or Password"; 
            exit();
        } 
    } 
?>
