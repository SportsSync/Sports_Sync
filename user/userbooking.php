<?php
session_start();
require '../db.php';

if (!isset($_SESSION['user_id'])) {
    $basePath = explode('/', $_SERVER['PHP_SELF'])[1];

echo "<script>
    alert('Please login to continue');
    window.top.location.href = '/$basePath/signin.php';
</script>";
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
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>Your Bookings</title>

<style>
 body { 
  background-color: #0e0f11; 
  background-image: linear-gradient(45deg, #1f1f1f 25%, transparent 25%), 
                    linear-gradient(-45deg, #1f1f1f 25%, transparent 25%), 
                    linear-gradient(45deg, transparent 75%, #1f1f1f 75%),
                    linear-gradient(-45deg, transparent 75%, #1f1f1f 75%); 
   background-size: 6px 6px; 
   background-position: 0 0, 0 3px, 3px -3px, -3px 0px; 
  } 

.wrapper {
    max-width: 1100px;
    margin: auto;
}
.btn-danger {
    background: #e53935;
    color: #fff;
    border: none;
}

.btn-secondary {
    background: #555;
    color: #ccc;
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
    color: #9526F3;
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
    background: #7cff002e;
    color: #9526F3;
}

.status.pending .status-badge {
    background: #ffc1072e;
    color: #9526F3;
}

.status.rejected .status-badge {
    background: #e539352e;
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

@media (max-width: 768px) {
    body {
        margin: 0;
    }

    .wrapper {
        padding: 18px 14px 28px;
    }

    .page-title {
        font-size: 1.35rem;
        margin-bottom: 22px;
    }

    .booking-card {
        grid-template-columns: 1fr;
        gap: 18px;
        padding: 18px;
    }

    .info-grid {
        grid-template-columns: 1fr;
        gap: 12px;
    }

    .status {
        align-items: stretch;
    }

    .actions {
        flex-direction: column;
    }

    .btn {
        width: 100%;
        text-align: center;
    }
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
    $booking_time = strtotime($row['booking_date'] . ' ' . $row['start_time']);
$current_time = time();

$canCancel = ($booking_time - $current_time) > (36 * 60 * 60);
$total_hours = ($booking_time - $current_time) / 3600;
$hours_left = floor($total_hours - 36);
$hours_left = max(0, $hours_left);
    $pdfPath = "../pdfs/booking_" . $row['booking_id'] . ".pdf";
    $cancelPdfPath = "../pdfs/cancellation_" . $row['booking_id'] . ".pdf";
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

    <!-- CANCEL BUTTON -->
    <?php if(!$isExpired): ?>

        <?php if($canCancel): ?>
            <button class="btn btn-danger"
                onclick="cancelBooking(<?= $row['booking_id'] ?>)">
                Cancel Booking
            </button>

            <small style="color:#aaa;">
                Cancelable for next <?= $hours_left ?> hrs
            </small>

        <?php else: ?>
            <button class="btn btn-secondary disabled">
                Cannot Cancel (&lt;36h)
            </button>
        <?php endif; ?>

    <?php endif; ?>

<?php elseif ($row['status'] === 'cancelled'): ?>

    <span style="color:#ff4d4d; font-weight:600;">
        Booking Cancelled and payment refunded (50%)
    </span>
    <div class="actions mt-2">
        <a href="<?= $cancelPdfPath ?>" target="_blank" class="btn btn-view">
            View Cancellation PDF
        </a>
    </div>

<?php endif; ?>
    </div>

</div>

<?php endwhile; ?>

</div>
<script>
function cancelBooking(id){
    if(!confirm("Are you sure you want to cancel this booking?")){
        return;
    }

    fetch("apiBooking/cancel_booking.php", {
        method: "POST",
        headers: {
            "Content-Type": "application/json"
        },
        body: JSON.stringify({ booking_id: id })
    })
    .then(res => res.json())
    .then(data => {
        if(data.status === "success"){
            alert("Booking cancelled successfully!");
            if(data.pdf_url) {
                window.open("../" + data.pdf_url, "_blank");
            }
            location.reload();
        } else {
            alert("Error: " + data.msg);
        }
    })
    .catch(err => {
        console.error("Fetch Error:", err);
        alert("A server error occurred. Please check the console or backend logs.");
    });
}
</script>
</body>
</html>
