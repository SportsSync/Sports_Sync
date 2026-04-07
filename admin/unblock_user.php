<?php
include('../db.php');

$id = (int)$_GET['id'];

// 1. UNBLOCK USER
mysqli_query($conn, "UPDATE user SET status='active' WHERE id='$id'");

// 2. CHECK ROLE
$res = mysqli_fetch_assoc(mysqli_query($conn, "SELECT role FROM user WHERE id='$id'"));

if($res['role'] == 'Vendor'){

    // 3. UNBLOCK ALL TURFS
    mysqli_query($conn, "
        UPDATE turftb 
        SET status='active' 
        WHERE owner_id='$id'
    ");
}

header("Location: manage_users.php");
exit;