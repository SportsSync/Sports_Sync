<?php
session_start();
require '../db.php';

if (!isset($_SESSION['user_id'])) {
    header("Location: ../signin.php");
    exit;
}

$owner_id = $_SESSION['user_id'];

/* ---------------- HANDLE REJECT ACTION ---------------- */
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['booking_id'])) {
    $booking_id = (int)$_POST['booking_id'];

    $update = "
        UPDATE bookingtb 
        SET status = 'rejected'
        WHERE booking_id = $booking_id
    ";
    mysqli_query($conn, $update);
    mysqli_query($conn, "DELETE FROM booking_slots_tb WHERE booking_id = $booking_id");
}

/* ---------------- FETCH PENDING BOOKINGS ---------------- */
$sql = "
SELECT 
    b.booking_id,
    b.booking_date,
    b.status,
    u.name AS user_name,
    u.mobile,
    t.turf_name,
    s.sport_name,
    MIN(ps.start_time) AS start_time,
    MAX(ps.end_time) AS end_time
FROM bookingtb b
JOIN user u ON u.id = b.user_id
JOIN turftb t ON t.turf_id = b.turf_id
JOIN booking_slots_tb bs ON bs.booking_id = b.booking_id
JOIN turf_price_slotstb ps ON ps.price_slot_id = bs.slot_id
JOIN sportstb s ON s.sport_id = ps.sport_id
WHERE t.owner_id = $owner_id
GROUP BY b.booking_id
ORDER BY b.created_at ASC
";

$res = mysqli_query($conn, $sql);
?>
<!DOCTYPE html>
<html>
<head>
<title>Vendor Requests</title>

<style>
body {
    font-family: Arial, sans-serif;
    background: #1C1C1C;
    margin: 0;
    padding: 20px;
    color: #F7F6F2;
}

table {
    width: 95%;
    margin: auto;
    background: #F7F6F2;
    border-collapse: collapse;
    box-shadow: 0 4px 10px rgba(0,0,0,0.3);
    border-radius: 10px;
    overflow: hidden;
    color: #1C1C1C;
}

th {
    background: #A9745B;
    color: white;
    font-size: 18px;
    padding: 14px;
    text-transform: uppercase;
}

td {
    border-bottom: 1px solid #BDBDBD;
    padding: 14px;
    font-size: 15px;
    vertical-align: top;
}

.reject-btn {
    background: #dc3545;
    color: white;
    padding: 8px 18px;
    border: none;
    cursor: pointer;
    border-radius: 6px;
    font-weight: bold;
}

.reject-btn:hover {
    background: #b5313e;
}

tr:hover {
    background: #EDEBE7;
}
</style>
</head>

<body>

<table>
<tr>
    <th>Booking Details</th>
    <th>Reject</th>
</tr>

<?php if (mysqli_num_rows($res) === 0): ?>
<tr>
    <td colspan="2" style="text-align:center;font-weight:bold;">
        No pending booking requests
    </td>
</tr>
<?php endif; ?>

<?php while ($row = mysqli_fetch_assoc($res)): ?>
<tr>
<td>
    <strong>Name:</strong> <?= htmlspecialchars($row['user_name']) ?><br>
    <strong>Phone:</strong> <?= htmlspecialchars($row['mobile']) ?><br>
    <strong>Sport:</strong> <?= htmlspecialchars($row['sport_name']) ?><br>
    <strong>Date:</strong> <?= $row['booking_date'] ?><br>
    <strong>Time:</strong>
    <?= substr($row['start_time'],0,5) ?> -
    <?= substr($row['end_time'],0,5) ?><br>
    <strong>Ground:</strong> <?= htmlspecialchars($row['turf_name']) ?><br>
    <strong>Status:</strong> <?= ucfirst($row['status']) ?>
</td>

<td>
    <form method="post" onsubmit="return confirm('Reject this booking?');">
        <input type="hidden" name="booking_id" value="<?= $row['booking_id'] ?>">
        <button type="submit" class="reject-btn">Reject</button>
    </form>
</td>
</tr>
<?php endwhile; ?>

</table>

</body>
</html>
