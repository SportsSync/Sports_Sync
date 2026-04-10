<?php
include('../../db.php'); // adjust path if needed
session_start();

$data = json_decode(file_get_contents("php://input"), true);

if (!isset($_SESSION['user_id'])) {
    echo json_encode(["status"=>"error","msg"=>"Login required"]);
    exit;
}

$booking_id = (int)$data['booking_id'];
$user_id = $_SESSION['user_id'];

// 🔹 Get booking + earliest slot time
$sql = "
SELECT b.booking_id, b.booking_date, MIN(s.start_time) as start_time
FROM bookingtb b
JOIN booking_slots_tb bs ON bs.booking_id = b.booking_id
JOIN turf_price_slotstb s ON s.price_slot_id = bs.slot_id
WHERE b.booking_id = $booking_id
AND b.user_id = $user_id
AND b.status = 'confirmed'
GROUP BY b.booking_id
";

$res = mysqli_query($conn, $sql);

if(mysqli_num_rows($res) == 0){
    echo json_encode(["status"=>"error","msg"=>"Invalid booking"]);
    exit;
}

$row = mysqli_fetch_assoc($res);

$booking_time = strtotime($row['booking_date']." ".$row['start_time']);
$current_time = time();

//🔴 36-hour restriction
if(($booking_time - $current_time) <= (36 * 60 * 60)){
    echo json_encode([
        "status"=>"error",
        "msg"=>"Cannot cancel within 36 hours"
    ]);
    exit;
}

// ✅ DELETE slots
mysqli_query($conn, "DELETE FROM booking_slots_tb WHERE booking_id=$booking_id");

$stmt1 = $conn->prepare("SELECT owner_id 
    FROM turftb 
    WHERE turf_id = (
        SELECT turf_id 
        FROM bookingtb 
        WHERE booking_id = ?)");

    $stmt1->bind_param("i", $booking_id);
    $stmt1->execute();
    $resultUser = $stmt1->get_result();

    if ($rowUser = $resultUser->fetch_assoc()) {

        $user_id = $rowUser['owner_id'];

        // insert notification
        $stmt2 = $conn->prepare("
            INSERT INTO notifications (user_id, type, title, message)
            VALUES (?, 'booking_cancelled', 'Booking cancel', 'User cancelled the booking.')
        ");
        $stmt2->bind_param("i", $user_id);
        $stmt2->execute();
    }

// ✅ UPDATE booking
mysqli_query($conn, "UPDATE bookingtb SET status='cancelled' WHERE booking_id=$booking_id");

echo json_encode(["status"=>"success"]);