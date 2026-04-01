<?php
require_once '../db.php';
session_start();

if (!isset($_SESSION['user_id'])) {
    echo json_encode(["count" => 0]);
    exit();
}

$user_id = $_SESSION['user_id'];

// count unread messages for THIS user
$stmt = $conn->prepare("
    SELECT COUNT(*) as unread 
    FROM messages 
    WHERE receiver_id = ? AND is_read = 0
");
$stmt->bind_param("i", $user_id);
$stmt->execute();

$result = $stmt->get_result()->fetch_assoc();

echo json_encode([
    "count" => (int)$result['unread']
]);