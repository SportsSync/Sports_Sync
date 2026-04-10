<?php
include('../../db.php');

$turf_id  = (int)$_GET['turf_id'];
$sport_id = (int)$_GET['sport_id'];
$court_id = (int)$_GET['court_id'];
$date     = $_GET['date'];

date_default_timezone_set('Asia/Kolkata'); // IMPORTANT

$currentDate = date('Y-m-d');
$currentTime = date('H:i:s');
// determine weekend
$isWeekend = (date('N', strtotime($date)) >= 6) ? 1 : 0;
$timeCondition = "";

if ($date === $currentDate) {
    $timeCondition = "AND s.start_time > '$currentTime'";
}
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
  $timeCondition
  AND NOT EXISTS (
  SELECT 1 
  FROM maintenance_tb m
  WHERE 
    m.turf_id = s.turf_id
    AND m.court_id = $court_id
    AND '$date' BETWEEN m.from_date AND m.to_date
    AND (
      s.start_time < m.to_time 
      AND s.end_time > m.from_time
    )
)
ORDER BY s.start_time
";


$res = mysqli_query($conn, $sql);

// 2️⃣ If weekend AND no rows → fallback to weekday pricing
if (mysqli_num_rows($res) === 0) {
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
  AND s.is_weekend = 0
  $timeCondition
  AND NOT EXISTS (
  SELECT 1 
  FROM maintenance_tb m
  WHERE 
    m.turf_id = s.turf_id
    AND m.court_id = $court_id
    AND '$date' BETWEEN m.from_date AND m.to_date
    AND (
      s.start_time < m.to_time 
      AND s.end_time > m.from_time
    )
)
ORDER BY s.start_time
";

    $res = mysqli_query($conn, $sql);
}

// 3️⃣ Build response
$data = [];
while ($row = mysqli_fetch_assoc($res)) {
    $data[] = $row;
}
if (count($data) === 0) {
    echo json_encode([
        "status" => "maintenance",
        "message" => "Court is under maintenance for selected date"
    ]);
    exit;
}
echo json_encode($data);
