<?php
session_start();
header('Content-Type: application/json');
date_default_timezone_set('Asia/Kolkata');
require __DIR__ . '/../../db.php';

/* =========================
   AUTH CHECK (VENDOR ONLY)
========================= */
if (!isset($_SESSION['user_id']) || strtolower($_SESSION['role']) !== 'vendor') {
    http_response_code(403);
    echo json_encode([
        "status" => "error",
        "msg" => "❌ Unauthorized"
    ]);
    exit;
}

/* =========================
   INPUT
========================= */
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
   FETCH BOOKING + USER
========================= */
$stmt = $conn->prepare("
    SELECT 
        b.booking_id,
        b.booking_date,
        b.qr_scan_count,
        b.turf_id,
        b.status,
        t.owner_id,
        u.name AS user_name
    FROM bookingtb b
    JOIN turftb t ON b.turf_id = t.turf_id
    JOIN user u ON b.user_id = u.id
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
   OWNER CHECK
========================= */
if ($booking['owner_id'] != $_SESSION['user_id']) {
    echo json_encode([
        "status" => "error",
        "msg" => "❌ This booking does not belong to your turf"
    ]);
    exit;
}

/* =========================
   STATUS CHECK
========================= */
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
        "msg" => "❌ Booking is for " . $booking['booking_date'],
        "today" => $today
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
$timeMessage = "";
$slotInfo = "";

while ($slot = $slotRes->fetch_assoc()) {

    $start = $slot['start_time'];
    $end = $slot['end_time'];

    $earlyAllowed = date('H:i:s', strtotime($start . ' -15 minutes'));
    $lateAllowed  = date('H:i:s', strtotime($end . ' +10 minutes'));

    $slotInfo .= date('H:i', strtotime($start)) . " - " . date('H:i', strtotime($end)) . "\n";

    if ($currentTime >= $earlyAllowed && $currentTime <= $lateAllowed) {
        $isValidTime = true;
        break;
    }

    if ($currentTime < $earlyAllowed) {
        $timeMessage = "⏳ Too early. Entry after " . date('H:i', strtotime($earlyAllowed));
    } elseif ($currentTime > $lateAllowed) {
        $timeMessage = "⌛ Slot expired at " . date('H:i', strtotime($lateAllowed));
    }
}

/* =========================
   TIME VALIDATION
========================= */
if (!$isValidTime) {
    echo json_encode([
        "status" => "error",
        "msg" => "❌ " . $timeMessage,
        "slots" => $slotInfo,
        "current_time" => date('H:i')
    ]);
    exit;
}

/* =========================
   MARK CHECK-IN
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
    "msg" => "✅ Entry Allowed for " . $booking['user_name'],
    "user" => $booking['user_name'],
    "current_time" => date('H:i'),
    "slots" => $slotInfo
]);
exit;