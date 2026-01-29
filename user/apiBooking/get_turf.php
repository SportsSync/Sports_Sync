<?php
require '../../db.php'; // adjust path if needed

header('Content-Type: application/json');

if (!isset($_GET['turf_id']) || !is_numeric($_GET['turf_id'])) {
    echo json_encode([
        "status" => "error",
        "message" => "Invalid turf id"
    ]);
    exit;
}

$turf_id = (int) $_GET['turf_id'];

$sql = "
SELECT 
    turf_name,
    location
FROM turftb
WHERE turf_id = $turf_id
LIMIT 1
";

$result = mysqli_query($conn, $sql);

if (!$result || mysqli_num_rows($result) === 0) {
    echo json_encode([
        "status" => "error",
        "message" => "Turf not found"
    ]);
    exit;
}

$row = mysqli_fetch_assoc($result);

echo json_encode([
    "status"    => "success",
    "turf_name" => $row['turf_name'],
    "location"  => $row['location']
]);
