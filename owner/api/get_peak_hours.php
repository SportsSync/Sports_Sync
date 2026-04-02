<?php
require '../db.php';
session_start();

$vendor_id = $_SESSION['user_id'];

$query = "
SELECT 
    ps.start_time,
    ps.end_time,
    COUNT(*) AS total_bookings
FROM booking_slots_tb bs
JOIN bookingtb b ON bs.booking_id = b.booking_id
JOIN turftb t ON b.turf_id = t.turf_id
JOIN turf_price_slotstb ps ON bs.slot_id = ps.price_slot_id
WHERE t.owner_id = ?
GROUP BY ps.start_time, ps.end_time
ORDER BY total_bookings DESC
";

$stmt = $conn->prepare($query);
$stmt->bind_param("i", $vendor_id);
$stmt->execute();

$result = $stmt->get_result();

$data = [];

while($row = $result->fetch_assoc()){
    $data[] = $row;
}

$peak = !empty($data) ? $data[0] : null;
$low  = !empty($data) ? $data[count($data)-1] : null;

echo json_encode([
    "data" => $data,
    "insights" => [
        "peak_hour" => $peak,
        "low_hour" => $low
    ]
]);