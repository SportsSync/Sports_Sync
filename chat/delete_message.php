<?php
require_once '../db.php';
session_start();

if(!isset($_SESSION['user_id'])){
    exit();
}

$user_id = $_SESSION['user_id'];
$message_id = $_POST['message_id'];

// only delete if sender
$conn->query("
    DELETE FROM messages 
    WHERE message_id = $message_id 
    AND sender_id = $user_id
");

echo "success";