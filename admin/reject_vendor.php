<?php
session_start();
include("../db.php");

if (!isset($_SESSION['admin'])) {
    header("Location: login.php");
    exit;
}

$id = (int)$_GET['id'];

/* Fetch user */
$res = mysqli_query($conn, "SELECT user_id FROM vendorrequesttb WHERE id=$id");
$data = mysqli_fetch_assoc($res);

if ($data) {
    /* Delete user */
    mysqli_query($conn, "DELETE FROM user WHERE id=".$data['user_id']);

    /* Update request */
    mysqli_query($conn, "UPDATE vendorrequesttb SET status='R' WHERE id=$id");
}

header("Location: vendor_requests.php");
exit;
