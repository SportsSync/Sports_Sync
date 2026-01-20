<?php
session_start();
require '../db.php';

if (!isset($_SESSION['user_id'])) {
    header("Location: ../signin.php");
    exit;
}

$user_id = $_SESSION['user_id'];

/* ---------------- STATUS BADGE HELPER ---------------- */
function bookingStatusBadge($status) {
    switch ($status) {
        case 'confirmed':
            return '<span class="status-bdg confirmed">Confirmed</span>';
        case 'rejected':
            return '<span class="status-bdg rejected">Rejected</span>';
        default:
            return '<span class="status-bdg pending">Pending</span>';
    }
}

/* ---------------- FETCH USER BOOKINGS ---------------- */
$sql = "
SELECT 
    b.booking_id,
    b.booking_date,
    b.status,
    s.sport_name,
    t.turf_name,
    MIN(ps.start_time) AS start_time,
    MAX(ps.end_time) AS end_time
FROM bookingtb b

LEFT JOIN booking_slots_tb bs 
    ON bs.booking_id = b.booking_id

LEFT JOIN turf_price_slotstb ps 
    ON ps.price_slot_id = bs.slot_id

JOIN sportstb s 
    ON s.sport_id = b.sport_id

JOIN turftb t 
    ON t.turf_id = b.turf_id

WHERE b.user_id = $user_id
GROUP BY b.booking_id
ORDER BY b.created_at DESC
";


$res = mysqli_query($conn, $sql);
?>
<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1">

<title>Your Bookings</title>

<script src="https://cdn.jsdelivr.net/npm/@tailwindcss/browser@4"></script>
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css">
<link rel="stylesheet" href="../whole.css">

<style>
body {
    background-color: var(--bg-dark);
    color: var(--highlight);
    padding: 25px;
}

h2 {
    text-align: center;
    padding: 14px 20px;
    margin: 0 auto 30px;
    font-size: 1.6rem;
    font-weight: 600;
    color: #f9fafb;
    background: linear-gradient(135deg, #1f2937, #374151);
    border-radius: 6px;
    width: fit-content;
}    

table {
    width: 90%;
    margin: auto;
    background: #F7F6F2;
    border-collapse: collapse;
    box-shadow: 0 4px 10px rgba(0,0,0,0.3);
    border-radius: 10px;
    overflow: hidden;
    color: #1C1C1C;
}

th {
    background: #020617;
    color: white;
    font-size: 18px;
    padding: 14px;
    text-transform: uppercase;
}

td {
    border-bottom: 1px solid #BDBDBD;
    padding: 16px;
    font-size: 15px;
}

.status-bdg {
    padding: 6px 14px;
    font-weight: bold;
    border-radius: 6px;
    display: inline-block;
}

.pending {
    background: #ffc107;
    color: #1C1C1C;
}

.confirmed {
    background: #33ff00;
    color: #1C1C1C;
}

.rejected {
    background: #ff0019;
    color: white;
}

tr:hover {
    background: #EDEBE7;
}

</style>
</head>

<body>

<h2>Your bookings</h2>

<table>
    <tr>
        <th>Booking Details</th>
        <th>Status</th>
    </tr>

<?php if (mysqli_num_rows($res) == 0): ?>
    <tr>
        <td colspan="2" class="text-center fw-bold">
            No bookings found
        </td>
    </tr>
<?php else: ?>
<?php while ($row = mysqli_fetch_assoc($res)): ?>
    <tr>
        <td>
            <strong>Sports:</strong> <?= htmlspecialchars($row['sport_name']) ?><br>
            <strong>Ground:</strong> <?= htmlspecialchars($row['turf_name']) ?><br>
            <strong>Date:</strong> <?= $row['booking_date'] ?><br>
            <strong>Time:</strong>
            <?= substr($row['start_time'], 0, 5) ?> -
            <?= substr($row['end_time'], 0, 5) ?>
        </td>
        <td>
            <?= bookingStatusBadge($row['status']) ?>
        </td>
    </tr>
<?php endwhile; ?>
<?php endif; ?>

</table>

</body>
</html>
