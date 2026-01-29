<?php
include('../../db.php');

$turf_id  = (int)$_GET['turf_id'];
$sport_id = (int)$_GET['sport_id'];
$court_id = (int)$_GET['court_id'];
$date     = $_GET['date'];

// determine weekend
$isWeekend = (date('N', strtotime($date)) >= 6) ? 1 : 0;

// 1️⃣ Try primary query (weekend or weekday)
$sql = "
SELECT 
  s.price_slot_id AS slot_id,
  s.start_time,
  s.end_time,
  s.price_per_hour,
  CASE 
    WHEN b.booking_id IS NULL THEN 0
    ELSE 1
  END AS is_booked
FROM turf_price_slotstb s
LEFT JOIN booking_slots_tb bs 
  ON bs.slot_id = s.price_slot_id
  AND bs.booking_date = '$date'
LEFT JOIN bookingtb b
  ON b.booking_id = bs.booking_id
  AND b.court_id = $court_id
WHERE s.turf_id = $turf_id
  AND s.sport_id = $sport_id
  AND s.is_weekend = $isWeekend
ORDER BY s.start_time
";


$res = mysqli_query($conn, $sql);

// 2️⃣ If weekend AND no rows → fallback to weekday pricing
if ($isWeekend === 1 && mysqli_num_rows($res) === 0) {
$sql = "
SELECT 
  s.price_slot_id AS slot_id,
  s.start_time,
  s.end_time,
  s.price_per_hour,
  CASE 
    WHEN b.booking_id IS NULL THEN 0
    ELSE 1
  END AS is_booked
FROM turf_price_slotstb s
LEFT JOIN booking_slots_tb bs 
  ON bs.slot_id = s.price_slot_id
  AND bs.booking_date = '$date'
LEFT JOIN bookingtb b
  ON b.booking_id = bs.booking_id
  AND b.court_id = $court_id
WHERE s.turf_id = $turf_id
  AND s.sport_id = $sport_id
  AND s.is_weekend = $isWeekend
ORDER BY s.start_time
";

    $res = mysqli_query($conn, $sql);
}

// 3️⃣ Build response
$data = [];
while ($row = mysqli_fetch_assoc($res)) {
    $data[] = $row;
}

echo json_encode($data);
