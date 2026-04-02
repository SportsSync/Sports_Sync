<?php
require '../db.php';
session_start();

$vendor_id = $_SESSION['user_id'];

$query = "SELECT turf_id, turf_name FROM turftb WHERE owner_id = ?";
$stmt = $conn->prepare($query);
$stmt->bind_param("i", $vendor_id);
$stmt->execute();

$result = $stmt->get_result();

$data = [];

while($row = $result->fetch_assoc()){
    $data[] = $row;
}

echo json_encode($data);