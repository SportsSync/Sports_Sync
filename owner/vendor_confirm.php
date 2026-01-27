<?php
session_start();
require '../db.php';

if (!isset($_SESSION['user_id'])) {
    header("Location: ../signin.php");
    exit;
}

date_default_timezone_set('Asia/Kolkata');
$owner_id = $_SESSION['user_id'];
$now = date('Y-m-d H:i:s');

/* ---------- REJECT BOOKING ---------- */
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['booking_id'])) {
    $booking_id = (int)$_POST['booking_id'];
    mysqli_query($conn, "UPDATE bookingtb SET status='rejected' WHERE booking_id=$booking_id");
    mysqli_query($conn, "DELETE FROM booking_slots_tb WHERE booking_id=$booking_id");
}

/* ---------- FETCH BOOKINGS ---------- */
$sql = "
SELECT 
    b.booking_id,
    b.booking_date,
    u.name AS user_name,
    u.mobile,
    t.turf_name,
    MIN(ti.image_path) AS turf_image,
    s.sport_name,
    MIN(ps.start_time) AS start_time,
    MAX(ps.end_time) AS end_time,
    CONCAT(b.booking_date,' ',MAX(ps.end_time)) AS booking_end
FROM bookingtb b
JOIN user u ON u.id = b.user_id
JOIN turftb t ON t.turf_id = b.turf_id
LEFT JOIN turf_imagestb ti ON ti.turf_id = t.turf_id
JOIN booking_slots_tb bs ON bs.booking_id = b.booking_id
JOIN turf_price_slotstb ps ON ps.price_slot_id = bs.slot_id
JOIN sportstb s ON s.sport_id = ps.sport_id
WHERE t.owner_id = $owner_id
GROUP BY b.booking_id
ORDER BY b.booking_date DESC
";


$res = mysqli_query($conn, $sql);
?>

<!DOCTYPE html>
<html>
<head>
<title>Booking Requests</title>

<style>
body {
    background: #0f0f0f;
    font-family: 'Segoe UI', sans-serif;
    color: #e5e5e5;
    padding: 20px;
}

.wrapper {
    max-width: 1200px;
    margin: auto;
}

/* CARD */
.booking-card {
    display: grid;
    grid-template-columns: 120px 1fr auto;
    gap: 22px;
    padding: 20px;
    border-radius: 16px;
    margin-bottom: 22px;
    background: #121212;
    border: 1px solid #262626;
    transition: all .25s ease;
}

.booking-card:not(.expired) {
    border-left: 4px solid #9CFF00;
}

.booking-card:hover {
    transform: translateY(-3px);
    border-color: rgba(156,255,0,.45);
    box-shadow: 0 14px 34px rgba(0,0,0,.7);
}

/* EXPIRED */
.booking-card.expired {
    opacity: .45;
    border-left: 4px solid #333;
}

.booking-card.expired:hover {
    transform: none;
    box-shadow: none;
}

/* IMAGE */
.turf-thumb img {
    width: 100%;
    height: 100%;
    border-radius: 12px;
    object-fit: cover;
}

/* INFO */
.booking-info h3 {
    margin: 0 0 10px;
    font-size: 20px;
    color: #C9FF3B;
}

.info-grid {
    display: grid;
    grid-template-columns: repeat(2, minmax(180px, 1fr));
    gap: 10px 30px;
}

.label {
    display: block;
    font-size: 11.5px;
    color: #8a8a8a;
    text-transform: uppercase;
    letter-spacing: .5px;
}

.value {
    font-size: 14.5px;
    color: #e0e0e0;
}

/* EXPIRED BADGE */
.badge.expired {
    margin-top: 12px;
    display: inline-block;
    padding: 4px 12px;
    font-size: 12px;
    border-radius: 12px;
    background: #262626;
    color: #888;
}

/* ACTION */
.action {
    display: flex;
    align-items: center;
}

.reject-btn {
    background: #e53935;
    border: none;
    color: #fff;
    padding: 10px 24px;
    border-radius: 10px;
    font-weight: 600;
    cursor: pointer;
    transition: all .2s ease;
}

.reject-btn:hover {
    background: #c62828;
    transform: scale(1.06);
    box-shadow: 0 8px 22px rgba(229,57,53,.55);
}

/* EMPTY */
.empty {
    text-align: center;
    padding: 50px;
    background: #141414;
    border-radius: 16px;
    color: #777;
    font-size: 18px;
}
</style>
</head>

<body>

<div class="wrapper">

<?php if (mysqli_num_rows($res) === 0): ?>
    <div class="empty">No booking requests</div>
<?php endif; ?>

<?php while ($row = mysqli_fetch_assoc($res)):
    $isExpired = ($row['booking_end'] < $now);
    $image = (!empty($row['turf_image'])) 
    ? $row['turf_image'] 
    : 'default.jpg';

?>

<div class="booking-card <?= $isExpired ? 'expired' : '' ?>">

    <!-- IMAGE -->
    <div class="turf-thumb">
        <img src="turf_images/<?= htmlspecialchars($image) ?>" alt="Turf">
    </div>

    <!-- INFO -->
    <div class="booking-info">
        <h3><?= htmlspecialchars($row['turf_name']) ?></h3>

        <div class="info-grid">
            <div>
                <span class="label">Name</span>
                <span class="value"><?= htmlspecialchars($row['user_name']) ?></span>
            </div>

            <div>
                <span class="label">Phone</span>
                <span class="value"><?= htmlspecialchars($row['mobile']) ?></span>
            </div>

            <div>
                <span class="label">Sport</span>
                <span class="value"><?= htmlspecialchars($row['sport_name']) ?></span>
            </div>

            <div>
                <span class="label">Date</span>
                <span class="value"><?= $row['booking_date'] ?></span>
            </div>

            <div>
                <span class="label">Time</span>
                <span class="value">
                    <?= substr($row['start_time'],0,5) ?> – <?= substr($row['end_time'],0,5) ?>
                </span>
            </div>
        </div>

        <?php if ($isExpired): ?>
            <span class="badge expired">EXPIRED</span>
        <?php endif; ?>
    </div>

    <!-- ACTION -->
    <?php if (!$isExpired): ?>
    <div class="action">
        <form method="post" onsubmit="return confirm('Reject this booking?');">
            <input type="hidden" name="booking_id" value="<?= $row['booking_id'] ?>">
            <button class="reject-btn">Reject</button>
        </form>
    </div>
    <?php endif; ?>

</div>

<?php endwhile; ?>

</div>

</body>
</html>
