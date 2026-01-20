<?php
session_start();
require '../../db.php';

if (!isset($_SESSION['user_id'])) {
  http_response_code(401);
  echo json_encode(["status" => "error", "msg" => "Login required"]);
  exit;
}

$data = json_decode(file_get_contents("php://input"), true);

$user_id     = $_SESSION['user_id'];
$turf_id     = (int)$data['turf_id'];
$court_id    = (int)$data['court_id'];
$sport_id    = (int)$data['sport_id']; // ✅ NEW
$bookingDate = $data['booking_date'];
$total       = (int)$data['total'];
$slots       = $data['slots'];

mysqli_begin_transaction($conn);

try {

  // 1️⃣ Insert booking (SPORT ID INCLUDED)
  $sql = "
    INSERT INTO bookingtb 
    (turf_id, court_id, sport_id, user_id, booking_date, total_amount, status)
    VALUES ($turf_id, $court_id, $sport_id, $user_id, '$bookingDate', $total, 'confirmed')
  ";
  mysqli_query($conn, $sql);

  $booking_id = mysqli_insert_id($conn);

  // 2️⃣ Insert booking slots
  foreach ($slots as $slot_id) {
    $slot_id = (int)$slot_id;
    $sql = "
      INSERT INTO booking_slots_tb (booking_id, slot_id, booking_date)
      VALUES ($booking_id, $slot_id, '$bookingDate')
    ";
    mysqli_query($conn, $sql);
  }

  mysqli_commit($conn);

  echo json_encode(["status" => "success"]);

} catch (Exception $e) {
  mysqli_rollback($conn);
  echo json_encode(["status" => "error", "msg" => "Booking failed"]);
}
