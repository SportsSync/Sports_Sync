<?php
session_start();
header('Content-Type: application/json');
require '../../db.php';
require_once '../../libs/phpqrcode/qrlib.php';
require_once '../../libs/fpdf/fpdf.php';

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

  // Generate secure QR token
  $secretKey = "SPORTSYNC_SECRETTOKEN_2026";
  $raw = $booking_id . "|" . $user_id . "|" . $turf_id . "|" . $bookingDate;

  $qr_token = hash("sha256", $raw . "|" . $secretKey);

  // STEP 4: Generate QR code image (TEST ONLY)

// change this to YOUR local IP
$serverIp = "192.168.31.187";

$verifyUrl = "http://$serverIp/Sports_Sync/verify.php?token=$qr_token";

// QR output path
$qrPath = __DIR__ . "/../../qrcodes/booking_" . $booking_id . ".png";

// Generate QR
QRcode::png($verifyUrl, $qrPath, QR_ECLEVEL_H, 5);

  // Save token
  mysqli_query($conn, "
    UPDATE bookingtb 
    SET booking_qr_token = '$qr_token', qr_generated_at = NOW()
    WHERE booking_id = $booking_id
  ");

  // 2️⃣ Insert booking slots
  foreach ($slots as $slot_id) {
    $slot_id = (int)$slot_id;
    $sql = "
      INSERT INTO booking_slots_tb (booking_id, slot_id, booking_date)
      VALUES ($booking_id, $slot_id, '$bookingDate')
    ";
    mysqli_query($conn, $sql);
  }
  $slots = [];

$slotSql = "
    SELECT s.start_time, s.end_time
    FROM booking_slots_tb bs
    JOIN turf_price_slotstb s ON bs.slot_id = s.price_slot_id
    WHERE bs.booking_id = $booking_id
    ORDER BY s.start_time
";
$slotRes = mysqli_query($conn, $slotSql);

while ($row = mysqli_fetch_assoc($slotRes)) {
    $slots[] = date('H:i', strtotime($row['start_time'])) .
               ' - ' .
               date('H:i', strtotime($row['end_time']));
}

$pdf = new FPDF();
$pdf->AddPage();

// Title
$pdf->SetFont('Arial','B',16);
$pdf->Cell(0,10,'Turf Booking Confirmation',0,1,'C');
$pdf->Ln(4);

// Booking Info
$pdf->SetFont('Arial','',12);
$pdf->Cell(0,8,"Booking ID: $booking_id",0,1);
$pdf->Cell(0,8,"Name: {$_SESSION['name']}",0,1);
$pdf->Cell(0,8,"Mobile: {$_SESSION['mobile']}",0,1);
$pdf->Cell(0,8,"Booking Date: $bookingDate",0,1);
$pdf->Cell(0,8,"Total Amount: Rs. $total",0,1);

$pdf->Ln(5);

// Slots
$pdf->SetFont('Arial','B',12);
$pdf->Cell(0,8,"Booked Time Slots:",0,1);

$pdf->SetFont('Arial','',11);
foreach ($slots as $slot) {
    $pdf->Cell(0,7,"-> $slot",0,1);
}

$pdf->Ln(6);

// QR Code
$pdf->SetFont('Arial','B',12);
$pdf->Cell(0,8,"Scan QR at Turf for Verification",0,1);
$pdf->Ln(3);

$qrPath = __DIR__ . "/../../qrcodes/booking_$booking_id.png";
$pdf->Image($qrPath, 80, null, 50, 50);

// Rules
$pdf->Ln(10);
$pdf->SetFont('Arial','B',12);
$pdf->Cell(0,8,"Rules & Instructions:",0,1);

$pdf->SetFont('Arial','',10);
$pdf->MultiCell(0,6,
"* Booking is non-transferable
* Reach 10 minutes early
* QR must be scanned at entry
* Late arrival may reduce play time
");

// Save PDF
$pdfDir = __DIR__ . "/../../pdfs/";
if (!is_dir($pdfDir)) {
    mkdir($pdfDir, 0777, true);
}

$pdfPath = $pdfDir . "booking_$booking_id.pdf";
$pdf->Output('F', $pdfPath);


mysqli_commit($conn);

echo json_encode([
    "status" => "success",
    "booking_id" => $booking_id,
    "pdf_url" => "../pdfs/booking_$booking_id.pdf"
]);
exit;


} catch (Exception $e) {
  mysqli_rollback($conn);
  echo json_encode(["status" => "error", "msg" => "Booking failed"]);
  exit;
}
