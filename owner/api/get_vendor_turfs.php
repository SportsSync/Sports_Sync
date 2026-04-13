<?php
require '../../db.php';
session_start();

$vendor_id = $_SESSION['user_id'];

$query = "
SELECT 
    t.turf_id,
    t.turf_name,
    ti.image_path
FROM turftb t
LEFT JOIN turf_imagestb ti ON t.turf_id = ti.turf_id
WHERE t.owner_id = ?
GROUP BY t.turf_id
";

$stmt = $conn->prepare($query);
$stmt->bind_param("i", $vendor_id);
$stmt->execute();

$result = $stmt->get_result();

$data = [];

while($row = $result->fetch_assoc()){
    $data[] = $row;
}

echo json_encode($data);