<?php
include('../../db.php');

$turf_id = (int)$_GET['turf_id'];

$res = mysqli_query($conn, "
    SELECT s.sport_id, s.sport_name
    FROM turf_sportstb ts
    JOIN sportstb s ON s.sport_id = ts.sport_id
    WHERE ts.turf_id = $turf_id
");

$data = [];
while ($row = mysqli_fetch_assoc($res)) {
    $data[] = $row;
}

echo json_encode($data);
?>