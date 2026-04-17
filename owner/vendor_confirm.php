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
$today = date('Y-m-d');
$q1 = mysqli_query($conn, "
    SELECT COUNT(bs.slot_id) AS booked_slots
    FROM booking_slots_tb bs
    JOIN bookingtb b ON b.booking_id = bs.booking_id
    JOIN turftb t ON t.turf_id = b.turf_id
    WHERE t.owner_id = $owner_id
    AND bs.booking_date = '$today'
    AND b.status = 'confirmed'
");

$booked_slots = mysqli_fetch_assoc($q1)['booked_slots'] ?? 0;
$q4 = mysqli_query($conn, "
    SELECT SUM(pending) AS pending_amount
    FROM (
        SELECT 
            b.booking_id,
            CASE 
                WHEN CONCAT(b.booking_date, ' ', max_end_time) > NOW()
                     AND b.total_amount > b.paid_amount
                THEN (b.total_amount - b.paid_amount)
                ELSE 0
            END AS pending
        FROM bookingtb b
        JOIN turftb t ON t.turf_id = b.turf_id
        LEFT JOIN (
            SELECT 
                bs.booking_id,
                MAX(ps.end_time) AS max_end_time
            FROM booking_slots_tb bs
            LEFT JOIN turf_price_slotstb ps 
                ON ps.price_slot_id = bs.slot_id
            GROUP BY bs.booking_id
        ) slot_data ON slot_data.booking_id = b.booking_id
        WHERE t.owner_id = $owner_id
        AND b.booking_date = CURDATE()
        AND b.status = 'confirmed'
    ) AS sub
");

$pending_amount = mysqli_fetch_assoc($q4)['pending_amount'] ?? 0;

$q3 = mysqli_query($conn, "
    SELECT SUM(
        CASE 
            WHEN CONCAT(b.booking_date, ' ', 
                (SELECT MAX(ps.end_time) 
                 FROM booking_slots_tb bs2
                 JOIN turf_price_slotstb ps ON ps.price_slot_id = bs2.slot_id
                 WHERE bs2.booking_id = b.booking_id)
            ) < NOW()
            THEN 
                (SELECT IFNULL(SUM(p.amount), 0) 
                 FROM payments p 
                 WHERE p.booking_id = b.booking_id 
                 AND p.status = 'success')
            ELSE 
                b.paid_amount
        END
    ) AS earnings
    FROM bookingtb b
    JOIN turftb t ON t.turf_id = b.turf_id
    WHERE t.owner_id = $owner_id
    AND DATE(b.booking_date) = '$today'
    AND b.status = 'confirmed'
");

$earnings = mysqli_fetch_assoc($q3)['earnings'] ?? 0;
/* ---------- REJECT BOOKING ---------- */
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['booking_id'])) {
    $booking_id = (int) $_POST['booking_id'];
    mysqli_query($conn, "UPDATE bookingtb SET status='rejected' WHERE booking_id=$booking_id");
    mysqli_query($conn, "DELETE FROM booking_slots_tb WHERE booking_id=$booking_id");
}

/* ---------- FETCH BOOKINGS ---------- */
$sql = "
SELECT 
    b.booking_id,
    b.booking_date,
    b.status,
    u.name AS user_name,
    u.mobile,
    u.profile_image AS user_image,  
    t.turf_name,
    MIN(ti.image_path) AS turf_image,
    s.sport_name,
    COALESCE(MIN(ps.start_time), '00:00:00') AS start_time,
    COALESCE(MAX(ps.end_time), '00:00:00') AS end_time,
    CONCAT(b.booking_date,' ',MAX(ps.end_time)) AS booking_end
FROM bookingtb b
JOIN user u ON u.id = b.user_id
JOIN turftb t ON t.turf_id = b.turf_id
LEFT JOIN turf_imagestb ti ON ti.turf_id = t.turf_id
LEFT JOIN booking_slots_tb bs ON bs.booking_id = b.booking_id
LEFT JOIN turf_price_slotstb ps ON ps.price_slot_id = bs.slot_id
LEFT JOIN sportstb s ON s.sport_id = ps.sport_id
WHERE t.owner_id = $owner_id
GROUP BY b.booking_id
ORDER BY b.booking_date DESC
";


$res = mysqli_query($conn, $sql);
?>
<?php

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['booking_id'])) {

    $booking_id = $_POST['booking_id'];

    // Get user_id of that booking
    $stmt = $conn->prepare("SELECT user_id FROM bookingtb WHERE booking_id = ?");
    $stmt->bind_param("i", $booking_id);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($row = $result->fetch_assoc()) {

        $user_id = $row['user_id'];

        // Insert notification
        $stmt2 = $conn->prepare("
            INSERT INTO notifications (user_id, type, title, message)
            VALUES (?, 'booking_cancelled', 'Booking cancelled.', 'Your booking has been rejected.')
        ");
        $stmt2->bind_param("i", $user_id);
        $stmt2->execute();
    }

    // OPTIONAL: redirect to prevent resubmit
    header("Location: " . $_SERVER['PHP_SELF']);
    exit();
}
?>
<?php
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['notify_booking_id'])) {

    $booking_id = $_POST['notify_booking_id'];

    // get user_id from booking
    $stmt1 = $conn->prepare("SELECT user_id FROM bookingtb WHERE booking_id = ?");
    $stmt1->bind_param("i", $booking_id);
    $stmt1->execute();
    $resultUser = $stmt1->get_result();

    if ($rowUser = $resultUser->fetch_assoc()) {

        $user_id = $rowUser['user_id'];

        // insert notification
        $stmt2 = $conn->prepare("
            INSERT INTO notifications (user_id, type, title, message)
            VALUES (?, 'Reminder', 'Booking reminder', 'You have a booking for turf.')
        ");
        $stmt2->bind_param("i", $user_id);
        $stmt2->execute();
    }

    // prevent resubmission
    header("Location: " . $_SERVER['PHP_SELF']);
    exit();
}
?>
<!DOCTYPE html>
<html>

<head>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Booking Requests</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.1/font/bootstrap-icons.css">
    <style>
        :root {
            --bg-main: #050914;
            --card-bg: #130b20;
            --border-subtle: #3c185c59;
            --accent-blue: #9526F3;
            --accent-blue-dark: #9526f359;
            --text-main: #e5e7eb;
            --text-muted: #94a3b8;
        }

        /* PAGE */
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
            max-width: 1200px;
            margin: auto;
        }

        .user-thumb {
            width: 70px;
            height: 70px;
            border-radius: 50%;
            overflow: hidden;
            border: 2px solid var(--accent-blue);
        }

        .user-thumb img {
            width: 100%;
            height: 100%;
            object-fit: cover;
        }

        /* CARD */
        .booking-card {
            display: grid;
            grid-template-columns: 90px 1fr 140px;
            align-items: center;
            gap: 22px;
            padding: 20px;
            border-radius: 18px;
            margin-bottom: 22px;
            background: var(--card-bg);
            border: 1px solid var(--border-subtle);
            transition: all .25s ease;
        }

        .booking-card:not(.expired) {
            border-left: 4px solid var(--accent-blue);
        }

        .booking-card:hover {
            transform: translateY(-3px);
            box-shadow: 0 18px 40px rgba(0, 0, 0, .65);
        }

        /* EXPIRED */
        .booking-card.expired {
            opacity: .45;
            border-left: 4px solid #1f2937;
        }

        .booking-card.expired:hover {
            transform: none;
            box-shadow: none;
        }

        /* IMAGE */
        .turf-thumb {
            display: flex;
            flex-direction: column;
            align-items: center;
            gap: 10px;
        }

        .turf-thumb img {
            width: 110px;
            height: 90px;
            border-radius: 12px;
            object-fit: cover;
        }

        /* INFO */
        .booking-info h3 {
            margin: 0 0 10px;
            font-size: 20px;
            color: var(--accent-blue);
            font-weight: 600;
        }

        .info-grid {
            display: grid;
            grid-template-columns: repeat(2, minmax(180px, 1fr));
            gap: 10px 30px;
        }

        .label {
            display: block;
            font-size: 11.5px;
            color: var(--text-muted);
            text-transform: uppercase;
            letter-spacing: .5px;
        }

        .value {
            font-size: 14.5px;
            color: #d1d5db;
        }

        /* EXPIRED BADGE */
        .badge.expired {
            margin-top: 12px;
            display: inline-block;
            padding: 4px 12px;
            font-size: 12px;
            border-radius: 12px;
            background: #020617;
            color: #64748b;
            border: 1px solid #1f2937;
        }

        /* ACTION */
        .action {
            display: flex;
            align-items: center;
        }

        .reject-btn {
            background: linear-gradient(135deg, #ef4444, #b91c1c);
            border: none;
            color: #fff;
            padding: 10px 24px;
            border-radius: 10px;
            font-weight: 600;
            cursor: pointer;
            transition: all .2s ease;
        }

        .reject-btn:hover {
            transform: scale(1.06);
            box-shadow: 0 10px 28px rgba(239, 68, 68, .5);
        }

        .notify-btn {
            background: linear-gradient(135deg, #270042, #8301df);
            border: none;
            color: #fff;
            padding: 10px 24px;
            border-radius: 10px;
            font-weight: 600;
            cursor: pointer;
            transition: all .2s ease;
        }

        .notify-btn:hover {
            transform: scale(1.06);
            box-shadow: 0 10px 28px rgba(176, 1, 224, 0.5);
        }

        /* EMPTY */
        .empty {
            text-align: center;
            padding: 50px;
            background: #020617;
            border-radius: 18px;
            color: #64748b;
            font-size: 18px;
            border: 1px solid #1f2937;
        }
        .dashboard-cards {
    display: grid;
    grid-template-columns: repeat(3, 1fr);
    gap: 20px;
    margin-bottom: 30px;
}

.dash-card {
    background: #130b20;
    border: 1px solid #3c185c59;
    padding: 20px;
    border-radius: 14px;
    text-align: center;
    transition: 0.3s;
}

.dash-card h2 {
    font-size: 28px;
    color: #9526F3;
    margin: 0;
}

.dash-card p {
    font-size: 14px;
    color: #94a3b8;
    margin-top: 8px;
}

.dash-card:hover {
    transform: translateY(-5px);
    box-shadow: 0 10px 30px rgba(0,0,0,0.5);
}
        @media (max-width: 768px) {
            body {
                margin: 0;
            }

            .wrapper {
                padding: 18px 14px 28px;
            }

            .booking-card {
                grid-template-columns: 1fr;
                gap: 16px;
                padding: 18px;
            }

            .user-thumb {
                width: 60px;
                height: 60px;
            }

            .info-grid {
                grid-template-columns: 1fr;
                gap: 12px;
            }

            .action {
                width: 100%;
            }

            .reject-btn {
                width: 100%;
            }
        }
        .qr-fab {
  position: fixed;
  right: 24px;
  bottom: 24px;
  width: 62px;
  height: 62px;
  border-radius: 8px;
  display: inline-flex;
  align-items: center;
  justify-content: center;
  color: #ffffff;
  background: linear-gradient(135deg, #9526F3, #5b21b6);
  border: 1px solid rgba(255, 255, 255, 0.18);
  box-shadow: 0 14px 35px rgba(149, 38, 243, 0.38);
  text-decoration: none;
  z-index: 1200;
  transition: transform 0.25s ease, box-shadow 0.25s ease;
}

.qr-fab i {
  font-size: 1.9rem;
  line-height: 1;
}

.qr-fab:hover,
.qr-fab:focus {
  color: #ffffff;
  transform: translateY(-3px);
  box-shadow: 0 18px 42px rgba(149, 38, 243, 0.52);
  outline: none;
}

.qr-fab-label {
  position: absolute;
  right: 74px;
  white-space: nowrap;
  background: rgba(14, 15, 17, 0.94);
  color: #ffffff;
  border: 1px solid rgba(149, 38, 243, 0.42);
  border-radius: 8px;
  padding: 8px 12px;
  font-size: 0.86rem;
  opacity: 0;
  transform: translateX(8px);
  pointer-events: none;
  transition: opacity 0.2s ease, transform 0.2s ease;
}

.qr-fab:hover .qr-fab-label,
.qr-fab:focus .qr-fab-label {
  opacity: 1;
  transform: translateX(0);
}
        @media (max-width: 575px) {
  .qr-fab {
    right: 16px;
    bottom: 16px;
    width: 56px;
    height: 56px;
  }

  .qr-fab-label {
    display: none;
  }
}
    </style>

</head>

<body>

    <div class="wrapper">
        <div class="dashboard-cards">

    <div class="dash-card">
        <h2>₹ <?= $earnings ?></h2>
        <p>Today's Earnings till now</p>
    </div>
    <div class="dash-card">
    <h2>₹ <?= $pending_amount ?></h2>
    <p>Pending Amount to collect on site<br><br><br>(If you collected amount on player arrival values are changed at the booking's end time)</p>
</div>
    <div class="dash-card">
        <h2><?= $booked_slots ?></h2>
        <p>Today's Booked Slots</p>
    </div>


</div>
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


                <!-- USER IMAGE (LEFT) -->
                <div class="user-thumb">
                    <?php
                    $userImage = (!empty($row['user_image']) && file_exists("../" . $row['user_image']))
                        ? "../" . $row['user_image']
                        : "../default-user.png";
                    ?>
                    <img src="<?= htmlspecialchars($userImage) ?>" alt="User">
                </div>
                <!-- IMAGE
    <div class="turf-thumb">
        <img src="turf_images/<?= htmlspecialchars($image) ?>" alt="Turf">
    </div> -->

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
                                <?= substr($row['start_time'], 0, 5) ?> – <?= substr($row['end_time'], 0, 5) ?>
                            </span>
                        </div>
                    </div>

                    <?php if ($isExpired): ?>
                        <span class="badge expired">EXPIRED</span>
                    <?php endif; ?>
                    <?php if ($row['status'] == 'cancelled'): ?>
                        <div style="margin-top: 5px;">
                            <span style="color:#ff4d4d; font-weight:600;">CANCELLED BY USER</span><br>
                            <a href="../pdfs/cancellation_<?= $row['booking_id'] ?>.pdf" target="_blank"
                                style="color: #9526F3; font-size: 13px; text-decoration: none; font-weight: 600;">
                                Download Cancellation Receipt
                            </a>
                        </div>
                    <?php endif; ?>
                </div>

                <!-- ACTION -->
                <div class="turf-thumb">

                    <img src="turf_images/<?= htmlspecialchars($image) ?>" alt="Turf">

                    <?php if (!$isExpired): ?>
                        <form method="post" onsubmit="return confirm('Reject this booking?');">
                            <input type="hidden" name="booking_id" value="<?= $row['booking_id'] ?>">
                            <button class="reject-btn">Reject</button>
                        </form>
                    <?php endif; ?>
                    <?php if (!$isExpired): ?>
                        <form method="post" onsubmit="return confirm('Send notification to this user?');"
                            style="margin-top:5px;">
                            <input type="hidden" name="notify_booking_id" value="<?= $row['booking_id'] ?>">
                            <button type="submit" class="notify-btn">Notify</button>
                        </form>
                    <?php endif; ?>
                </div>

            </div>

        <?php endwhile; ?>

    </div>
<a href="scan.php" class="qr-fab" title="Scan booking QR" aria-label="Scan booking QR" onclick="loadPage('scan.php'); return false;">
  <span class="qr-fab-label">Scan QR</span>
  <i class="bi bi-qr-code-scan"></i>
</a>
</body>

</html>