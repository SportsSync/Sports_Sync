<?php
session_start();
header('Content-Type: application/json');
date_default_timezone_set('Asia/Kolkata');
require 'db.php';

/* =========================
   AUTH CHECK (VENDOR ONLY)
========================= */
if (!isset($_SESSION['user_id']) || $_SESSION['role'] !== 'vendor') {
    http_response_code(403);
    echo json_encode([
        "status" => "error",
        "msg" => "❌ Unauthorized"
    ]);
    exit;
}

$input = json_decode(file_get_contents("php://input"), true);
$token = $input['token'] ?? '';

if (empty($token)) {
    echo json_encode([
        "status" => "error",
        "msg" => "❌ Invalid QR"
    ]);
    exit;
}

/* =========================
   FETCH BOOKING + TURF OWNER
========================= */
$stmt = $conn->prepare("
    SELECT 
        b.booking_id,
        b.booking_date,
        b.qr_scan_count,
        b.turf_id,
        t.owner_id,
        b.status
    FROM bookingtb b
    JOIN turftb t ON b.turf_id = t.turf_id
    WHERE b.booking_qr_token = ?
    LIMIT 1
");

$stmt->bind_param("s", $token);
$stmt->execute();
$res = $stmt->get_result();

if ($res->num_rows === 0) {
    echo json_encode([
        "status" => "error",
        "msg" => "❌ Invalid Booking"
    ]);
    exit;
}

$booking = $res->fetch_assoc();

/* =========================
   TURF OWNERSHIP CHECK
========================= */
if ($booking['owner_id'] != $_SESSION['user_id']) {
    echo json_encode([
        "status" => "error",
        "msg" => "❌ This booking does not belong to your turf"
    ]);
    exit;
}

if ($booking['status'] !== 'confirmed') {
    echo json_encode([
        "status" => "error",
        "msg" => "❌ Booking is not active"
    ]);
    exit;
}
/* =========================
   DATE VALIDATION
========================= */
$today = date('Y-m-d');

if ($booking['booking_date'] != $today) {
    echo json_encode([
        "status" => "error",
        "msg" => "❌ Booking is not for today"
    ]);
    exit;
}

/* =========================
   PREVENT REUSE
========================= */
if ($booking['qr_scan_count'] >= 1) {
    echo json_encode([
        "status" => "error",
        "msg" => "❌ Already Checked-In"
    ]);
    exit;
}

/* =========================
   FETCH SLOT TIMES
========================= */
$slotStmt = $conn->prepare("
    SELECT s.start_time, s.end_time
    FROM booking_slots_tb bs
    JOIN turf_price_slotstb s ON bs.slot_id = s.price_slot_id
    WHERE bs.booking_id = ?
    ORDER BY s.start_time
");

$slotStmt->bind_param("i", $booking['booking_id']);
$slotStmt->execute();
$slotRes = $slotStmt->get_result();

$currentTime = date('H:i:s');
$isValidTime = false;

while ($slot = $slotRes->fetch_assoc()) {
    $endBuffer = date('H:i:s', strtotime($slot['end_time'] . ' +10 minutes'));

    if ($currentTime >= $slot['start_time'] && $currentTime <= $endBuffer) {
        $isValidTime = true;
        break;
    }
}

/* =========================
   TIME VALIDATION
========================= */
if (!$isValidTime) {
    echo json_encode([
        "status" => "error",
        "msg" => "❌ Not valid for current time slot"
    ]);
    exit;
}

/* =========================
   MARK AS CHECKED-IN
========================= */
$update = $conn->prepare("
    UPDATE bookingtb
SET qr_scanned_at = NOW(),
    qr_scan_count = qr_scan_count + 1
WHERE booking_id = ? AND qr_scan_count = 0
");

$update->bind_param("i", $booking['booking_id']);
$update->execute();

if ($update->affected_rows === 0) {
    echo json_encode([
        "status" => "error",
        "msg" => "❌ Already Checked-In"
    ]);
    exit;
}
/* =========================
   SUCCESS RESPONSE
========================= */
echo json_encode([
    "status" => "success",
    "msg" => "✅ Entry Allowed",
    "booking_id" => $booking['booking_id'],
    "turf_id" => $booking['turf_id']
]);
exit;