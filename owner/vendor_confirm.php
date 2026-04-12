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

</body>

</html>