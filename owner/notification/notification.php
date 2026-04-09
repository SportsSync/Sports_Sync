<?php
session_start();
include('../db.php');

if (!isset($_SESSION['user_id'])) {
    die("Unauthorized");
}

$user_id = $_SESSION['user_id'];

// CLEAR ALL NOTIFICATIONS
if (isset($_POST['clear_all'])) {
    $stmt = $conn->prepare("DELETE FROM notification_tb WHERE user_id = ?");
    $stmt->bind_param("i", $user_id);
    $stmt->execute();
}

// FETCH NOTIFICATIONS
$stmt = $conn->prepare("SELECT * FROM notification_tb WHERE user_id = ? ORDER BY created_at DESC");
$stmt->bind_param("i", $user_id);
$stmt->execute();
$result = $stmt->get_result();
?>

<!DOCTYPE html>
<html>
<head>
    <title>Notifications</title>

    <style>
        body {
            margin: 0;
            font-family: 'Segoe UI', sans-serif;
            background: #0b0b0f;
            color: #fff;
        }

        .container {
            width: 85%;
            margin: auto;
            padding: 30px 0;
        }

        h1 {
            color: #c084fc;
            margin-bottom: 25px;
        }

        .notification-card {
            background: linear-gradient(145deg, #111, #1c1c25);
            border: 1px solid #2a2a35;
            padding: 16px;
            border-radius: 12px;
            margin-bottom: 12px;
            transition: 0.2s ease;
        }

        .notification-card:hover {
            transform: translateY(-2px);
        }

        .notification-text {
            font-size: 15px;
        }

        .time {
            font-size: 12px;
            color: #888;
            margin-top: 5px;
        }

        .clear-btn {
            display: inline-block;
            margin-top: 25px;
            padding: 12px 20px;
            border-radius: 30px;
            border: none;
            background: linear-gradient(45deg, #9333ea, #d946ef);
            color: white;
            cursor: pointer;
            font-size: 14px;
        }

        .clear-btn:hover {
            opacity: 0.85;
        }

        .empty {
            text-align: center;
            margin-top: 60px;
            color: #666;
        }
    </style>
</head>

<body>

<div class="container">
    <h1>Your Notifications</h1>

    <?php if ($result->num_rows > 0): ?>
        
        <?php while ($row = $result->fetch_assoc()): ?>
            <div class="notification-card">
                <div class="notification-text">
                    <?php echo htmlspecialchars($row['notification']); ?>
                </div>
                <div class="time">
                    <?php echo $row['created_at']; ?>
                </div>
            </div>
        <?php endwhile; ?>

        <form method="POST">
            <button type="submit" name="clear_all" class="clear-btn">
                Clear All
            </button>
        </form>

    <?php else: ?>
        <div class="empty">No notifications available</div>
    <?php endif; ?>

</div>

</body>
</html>