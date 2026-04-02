<?php
require_once '../db.php';
require_once '../libs/encryption.php';
session_start();

header('Content-Type: application/json');

if(!isset($_SESSION['user_id'])){
    echo json_encode([]);
    exit();
}

function getAdminId($conn){
    $res = $conn->query("SELECT id FROM user WHERE role='admin' ORDER BY id ASC LIMIT 1");
    return $res->fetch_assoc()['id'];
}

$user_id = $_SESSION['user_id'];
$role = $_SESSION['role'] ?? '';

if($role === 'admin'){
    if(!isset($_GET['receiver_id'])){
        echo json_encode([]);
        exit();
    }
    $other_id = intval($_GET['receiver_id']);
}else{
    $other_id = getAdminId($conn);
}

$conn->query("
    UPDATE messages 
    SET is_read = 1 
    WHERE receiver_id = $user_id 
    AND sender_id = $other_id
");

$stmt = $conn->prepare("
    SELECT 
        message_id,
        sender_id,
        receiver_id,
        message,
        is_read,
        created_at
    FROM messages 
    WHERE (sender_id=? AND receiver_id=?) 
       OR (sender_id=? AND receiver_id=?)
    ORDER BY created_at ASC
");

$stmt->bind_param("iiii", $user_id, $other_id, $other_id, $user_id);
$stmt->execute();

$result = $stmt->get_result();

$data = [];

while($row = $result->fetch_assoc()){

    // 🔥 DECRYPT MESSAGE (THIS WAS MISSING)
    $row['message'] = decryptMessage($row['message']);

    $data[] = $row;
}

echo json_encode($data);