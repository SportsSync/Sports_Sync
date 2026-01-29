<?php
session_start();
require '../db.php';

if (!isset($_SESSION['user_id'])) {
    echo "<script>
        alert('Please login to continue');
        window.top.location.href = '/Sports_Sync/signin.php';
    </script>";
    exit;
}

date_default_timezone_set('Asia/Kolkata');
$user_id = $_SESSION['user_id'];
$now = date('Y-m-d H:i:s');

/* ---------- FETCH BOOKINGS ---------- */
$sql = "
SELECT 
    b.booking_id,
    b.booking_date,
    b.status,
    s.sport_name,
    t.turf_name,
    MIN(ps.start_time) AS start_time,
    MAX(ps.end_time) AS end_time,
    CONCAT(b.booking_date,' ',MAX(ps.end_time)) AS booking_end
FROM bookingtb b
LEFT JOIN booking_slots_tb bs ON bs.booking_id = b.booking_id
LEFT JOIN turf_price_slotstb ps ON ps.price_slot_id = bs.slot_id
JOIN sportstb s ON s.sport_id = b.sport_id
JOIN turftb t ON t.turf_id = b.turf_id
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
<title>Your Bookings</title>

<style>
body {
    background: #0f0f0f;
    font-family: 'Segoe UI', sans-serif;
    color: #e5e5e5;
    padding: 25px;
}

.wrapper {
    max-width: 1100px;
    margin: auto;
}

.page-title {
    text-align: center;
    font-size: 1.6rem;
    font-weight: 600;
    margin-bottom: 30px;
    color: #f9fafb;
}

/* CARD */
.booking-card {
    display: grid;
    grid-template-columns: 1fr auto;
    gap: 26px;
    padding: 22px 26px;
    border-radius: 16px;
    margin-bottom: 22px;
    background: #121212;
    border: 1px solid #262626;
    transition: all .25s ease;
}

.booking-card:hover {
    transform: translateY(-3px);
    box-shadow: 0 12px 30px rgba(0,0,0,.6);
}

/* EXPIRED */
.booking-card.expired {
    opacity: .45;
}

.booking-card.expired:hover {
    transform: none;
    box-shadow: none;
}

/* INFO */
.booking-info h3 {
    margin: 0 0 12px;
    font-size: 20px;
    color: #C9FF3B;
}

.info-grid {
    display: grid;
    grid-template-columns: repeat(2, minmax(180px,1fr));
    gap: 10px 30px;
}

.label {
    font-size: 12px;
    color: #8a8a8a;
    text-transform: uppercase;
    letter-spacing: .5px;
}

.value {
    font-size: 14.5px;
    color: #e0e0e0;
}

/* STATUS + ACTIONS */
.status {
    display: flex;
    flex-direction: column;
    gap: 10px;
    align-items: flex-end;
}

.status-badge {
    padding: 8px 18px;
    border-radius: 20px;
    font-size: 13px;
    font-weight: 600;
}

.status.confirmed .status-badge {
    background: rgba(124,255,0,.18);
    color: #9CFF00;
}

.status.pending .status-badge {
    background: rgba(255,193,7,.18);
    color: #ffc107;
}

.status.rejected .status-badge {
    background: rgba(229,57,53,.18);
    color: #e53935;
}

/* PDF BUTTONS */
.actions {
    display: flex;
    gap: 10px;
}

.btn {
    padding: 6px 14px;
    border-radius: 6px;
    font-size: 13px;
    text-decoration: none;
    font-weight: 600;
    white-space: nowrap;
}

.btn-view {
    background: #2563eb;
    color: #fff;
}

.btn-download {
    background: #16a34a;
    color: #fff;
}

.btn.disabled {
    pointer-events: none;
    opacity: .5;
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

<h2 class="page-title">Your Bookings</h2>

<?php if (mysqli_num_rows($res) === 0): ?>
    <div class="empty">No bookings found</div>
<?php endif; ?>

<?php while ($row = mysqli_fetch_assoc($res)):
    $isExpired = ($row['booking_end'] < $now);
    $pdfPath = "../pdfs/booking_" . $row['booking_id'] . ".pdf";
?>

<div class="booking-card <?= $isExpired ? 'expired' : '' ?>">

    <div class="booking-info">
        <h3><?= htmlspecialchars($row['turf_name']) ?></h3>

        <div class="info-grid">
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
    </div>

    <div class="status <?= $row['status'] ?>">
        <span class="status-badge">
            <?= ucfirst($row['status']) ?>
        </span>

        <?php if ($row['status'] === 'confirmed'): ?>
            <div class="actions">
                <a href="<?= $pdfPath ?>" target="_blank"
                   class="btn btn-view <?= $isExpired ? 'disabled' : '' ?>">
                    View PDF
                </a>

                <a href="<?= $pdfPath ?>" download
                   class="btn btn-download <?= $isExpired ? 'disabled' : '' ?>">
                    Download
                </a>
            </div>
        <?php endif; ?>
    </div>

</div>

<?php endwhile; ?>

</div>

</body>
</html>
