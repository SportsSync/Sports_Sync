<?php
require_once '../db.php';
require_once '../libs/encryption.php';
session_start();

header('Content-Type: application/json');

if(!isset($_SESSION['user_id']) || $_SESSION['role'] != 'admin'){
    echo json_encode([]);
    exit();
}

$admin_id = $_SESSION['user_id'];

$query = "
SELECT 
    u.id,
    u.name,
    u.role,
    u.profile_image,

    -- LAST MESSAGE
    (
        SELECT message 
        FROM messages 
        WHERE 
            (sender_id = u.id AND receiver_id = $admin_id)
            OR
            (sender_id = $admin_id AND receiver_id = u.id)
        ORDER BY created_at DESC
        LIMIT 1
    ) AS last_message,

    -- LAST MESSAGE TIME
    (
        SELECT created_at 
        FROM messages 
        WHERE 
            (sender_id = u.id AND receiver_id = $admin_id)
            OR
            (sender_id = $admin_id AND receiver_id = u.id)
        ORDER BY created_at DESC
        LIMIT 1
    ) AS last_time,

    -- UNREAD COUNT
    (
        SELECT COUNT(*) 
        FROM messages 
        WHERE 
            sender_id = u.id 
            AND receiver_id = $admin_id 
            AND is_read = 0
    ) AS unread_count

FROM user u
WHERE u.id != $admin_id

ORDER BY last_time DESC
";

$result = $conn->query($query);

$data = [];

// 🔥 IMPORTANT PART (YOU WERE MISSING THIS)
$defaultImage = "/sportSyncProject/user/profile/default_avatar.jpg";

while($row = $result->fetch_assoc()){

    if(empty($row['profile_image'])){
        $row['profile_image'] = $defaultImage;
    } else {
        // ABSOLUTE PATH (BEST PRACTICE)
        $row['profile_image'] = "/sportSyncProject/" . $row['profile_image'];
    }

    if(!empty($row['last_message'])){
        $row['last_message'] = decryptMessage($row['last_message']);
    }

    $data[] = $row;

}

echo json_encode($data);