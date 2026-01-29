<?php
require 'db.php';

$token = $_GET['token'] ?? '';

if ($token === '') {
    die("❌ Invalid QR");
}

/* =========================
   FETCH BOOKING + USER INFO
========================= */
$stmt = $conn->prepare("
    SELECT 
        b.booking_id,
        b.booking_date,
        b.total_amount,
        u.name AS user_name,
        u.mobile,
        t.turf_name
    FROM bookingtb b
    JOIN user u ON b.user_id = u.id
    JOIN turftb t ON b.turf_id = t.turf_id
    WHERE b.booking_qr_token = ?
    LIMIT 1
");
$stmt->bind_param("s", $token);
$stmt->execute();
$res = $stmt->get_result();

if ($res->num_rows === 0) {
    die("❌ Fake or Invalid Booking");
}

$booking = $res->fetch_assoc();

/* =========================
   DATE VALIDATION
========================= */
$today = date('Y-m-d');

$status = "VALID";
$statusMsg = "BOOKING VERIFIED ✅";
$statusColor = "#22c55e";

if ($booking['booking_date'] < $today) {
    $status = "EXPIRED";
    $statusMsg = "BOOKING EXPIRED ❌";
    $statusColor = "#ef4444";
}

/* =========================
   FETCH BOOKED SLOT TIMES
========================= */
$slots = [];

$slotQuery = "
    SELECT s.start_time, s.end_time
    FROM booking_slots_tb bs
    JOIN turf_price_slotstb s ON bs.slot_id = s.price_slot_id
    WHERE bs.booking_id = ?
    ORDER BY s.start_time
";
$slotStmt = $conn->prepare($slotQuery);
$slotStmt->bind_param("i", $booking['booking_id']);
$slotStmt->execute();
$slotRes = $slotStmt->get_result();

while ($row = $slotRes->fetch_assoc()) {
    $slots[] = date('H:i', strtotime($row['start_time'])) . 
               " - " . 
               date('H:i', strtotime($row['end_time']));
}

/* =========================
   UPDATE SCAN (ONLY IF VALID)
========================= */
if ($status === "VALID") {
    $conn->query("
        UPDATE bookingtb
        SET 
            qr_scanned_at = IF(qr_scanned_at IS NULL, NOW(), qr_scanned_at),
            qr_scan_count = qr_scan_count + 1
        WHERE booking_id = {$booking['booking_id']}
    ");
}

?>

<!DOCTYPE html>
<html>
<head>
    <title>Booking Verification</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <style>
        body {
            font-family: Arial;
            background: #020617;
            color: #e5e7eb;
            padding: 30px;
        }
        .card {
            max-width: 420px;
            margin: auto;
            background: #020617;
            border-radius: 14px;
            padding: 22px;
            border: 1px solid #1f2937;
            box-shadow: 0 0 25px rgba(0,255,0,0.15);
        }
        h2 {
            text-align: center;
            color: <?= $statusColor ?>;
        }
        .badge {
            display: inline-block;
            padding: 6px 14px;
            border-radius: 20px;
            font-weight: bold;
            background: <?= $statusColor ?>;
            color: #020617;
            margin: 10px 0;
        }
        p {
            margin: 8px 0;
            font-size: 15px;
        }
        ul {
            padding-left: 18px;
        }
        hr {
            border: none;
            border-top: 1px solid #1f2937;
            margin: 14px 0;
        }
    </style>
</head>

<body>

<div class="card">

    <h2><?= $statusMsg ?></h2>

    <center>
        <span class="badge"><?= $status ?></span>
    </center>

    <hr>

    <p><b>User:</b> <?= htmlspecialchars($booking['user_name']) ?></p>
    <p><b>Mobile:</b> <?= htmlspecialchars($booking['mobile']) ?></p>

    <hr>

    <p><b>Turf:</b> <?= htmlspecialchars($booking['turf_name']) ?></p>
    <p><b>Date:</b> <?= htmlspecialchars($booking['booking_date']) ?></p>
    <p><b>Total:</b> ₹<?= htmlspecialchars($booking['total_amount']) ?></p>

    <hr>

    <p><b>Booked Time Slots:</b></p>
    <ul>
        <?php foreach ($slots as $slot): ?>
            <li><?= htmlspecialchars($slot) ?></li>
        <?php endforeach; ?>
    </ul>

</div>

</body>
</html>
