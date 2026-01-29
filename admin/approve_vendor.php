<?php
session_start();
include("../db.php");

/*if (!isset($_SESSION['admin'])) {
    header("Location: login.php");
    exit;
}*/

$id = (int) $_GET['id'];

$sql = "UPDATE vendorrequesttb SET status='approved' WHERE id=?";
$stmt = mysqli_prepare($conn, $sql);
mysqli_stmt_bind_param($stmt, "i", $id);
mysqli_stmt_execute($stmt);

header("Location: vendor_requests.php");
exit;
