<?php
session_start();
require '../../db.php';

header('Content-Type: application/json');

$data = json_decode(file_get_contents("php://input"), true);

$vendor_id = $_SESSION['user_id'];
$plan_id = (int)$data['plan_id'];
$turf_ids = $data['turf_ids'];

$plan = $conn->query("SELECT * FROM ad_plans WHERE id=$plan_id")->fetch_assoc();

$start = date('Y-m-d H:i:s');
$end = date('Y-m-d H:i:s', strtotime("+{$plan['duration_days']} days"));

foreach ($turf_ids as $turf_id) {

    $turf_id = (int)$turf_id;

    $conn->query("
        INSERT INTO turf_ads 
        (turf_id, vendor_id, plan_id, start_date, end_date, is_active, payment_status)
        VALUES ($turf_id, $vendor_id, $plan_id, '$start', '$end', 1, 'paid')"
    );
}

echo json_encode(["status" => "success"]);