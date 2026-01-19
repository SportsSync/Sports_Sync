<?php
include('../../db.php');

$turf_id  = (int)$_GET['turf_id'];
$sport_id = (int)$_GET['sport_id'];
$date     = $_GET['date'];

// determine weekend
$isWeekend = (date('N', strtotime($date)) >= 6) ? 1 : 0;

// 1️⃣ Try primary query (weekend or weekday)
$sql = "
    SELECT start_time, end_time, price_per_hour
    FROM turf_price_slotstb
    WHERE turf_id = $turf_id
      AND sport_id = $sport_id
      AND is_weekend = $isWeekend
    ORDER BY start_time
";

$res = mysqli_query($conn, $sql);

// 2️⃣ If weekend AND no rows → fallback to weekday pricing
if ($isWeekend === 1 && mysqli_num_rows($res) === 0) {
    $sql = "
        SELECT start_time, end_time, price_per_hour
        FROM turf_price_slotstb
        WHERE turf_id = $turf_id
          AND sport_id = $sport_id
          AND is_weekend = 0
        ORDER BY start_time
    ";
    $res = mysqli_query($conn, $sql);
}

// 3️⃣ Build response
$data = [];
while ($row = mysqli_fetch_assoc($res)) {
    $data[] = $row;
}

echo json_encode($data);
