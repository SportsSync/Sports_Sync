<?php
require_once '../db.php';
require_once '../libs/encryption.php';
session_start();

function getAdminId($conn){
    $res = $conn->query("SELECT id FROM user WHERE role='admin' LIMIT 1");
    return $res->fetch_assoc()['id'];
}

$sender_id = $_SESSION['user_id'];
$role = $_SESSION['role'];
$message = htmlspecialchars($_POST['message']);
$encrypted_message = encryptMessage($message);

if(empty($message)){
    echo "empty";
    exit();
}

if($role == 'admin'){
    $receiver_id = $_POST['receiver_id'];
}else{
    $receiver_id = getAdminId($conn);
}

$stmt = $conn->prepare("INSERT INTO messages (sender_id, receiver_id, message) VALUES (?, ?, ?)");
$stmt->bind_param("iis", $sender_id, $receiver_id, $encrypted_message);

echo $stmt->execute() ? "success" : "error";