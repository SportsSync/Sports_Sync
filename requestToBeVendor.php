<?php
session_start();
require "db.php";

// Only logged-in users
if (!isset($_SESSION['role'])) {
    header("Location: signin.php");
    exit;
}

// Only normal users allowed
if ($_SESSION['role'] !== 'User') {
    header("Location: index.php");
    exit;
}

$success = false;
$error = false;

if (isset($_POST["submitReq"])) {

    $user_id   = $_SESSION['user_id'];
    $turf_name = trim($_POST['turf_name']);
    $city      = trim($_POST['city']);
    $reason    = trim($_POST['reason']);

    $sql = "INSERT INTO vendorrequesttb 
            (user_id, turf_name, city, reason) 
            VALUES (?, ?, ?, ?)";

    $stmt = $conn->prepare($sql);

    if ($stmt) {
        $stmt->bind_param("isss", $user_id, $turf_name, $city, $reason);

        if ($stmt->execute()) {
            $success = true;
        } else {
            $error = true;
        }
    } else {
        $error = true;
    }
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <title>Request Vendor Access | SportsSync</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
  <link rel="shortcut icon" href="favicon.png" type="image/png">
  <style>
  :root {
    --bg-main: #050914;
    --card-bg: rgba(15, 23, 42, 0.85);
    --accent-blue: #3b82f6;
    --accent-blue-dark: #1d4ed8;
    --text-main: #e5e7eb;
    --text-muted: #94a3b8;
  }

  body {
    background-color: #0e0f11; 
  background-image: linear-gradient(45deg, #1f1f1f 25%, transparent 25%), 
                    linear-gradient(-45deg, #1f1f1f 25%, transparent 25%), 
                    linear-gradient(45deg, transparent 75%, #1f1f1f 75%),
                    linear-gradient(-45deg, transparent 75%, #1f1f1f 75%); 
   background-size: 6px 6px; 
   background-position: 0 0, 0 3px, 3px -3px, -3px 0px;
  }

  .request-box {
    background: var(--card-bg);
    padding: 40px;
    border-radius: 18px;
    max-width: 600px;
    margin: 80px auto;
    box-shadow:
      0 30px 70px rgba(0,0,0,0.6),
      inset 0 0 0 1px rgba(59, 130, 246, 0.12);
  }

  h2 {
    color: var(--accent-blue);
    margin-bottom: 15px;
    font-weight: 700;
  }

  p {
    color: var(--text-muted);
    font-size: 0.95rem;
  }

  label {
    color: var(--text-muted);
  }

  .btn-custom {
    background: linear-gradient(
      135deg,
      var(--accent-blue),
      var(--accent-blue-dark)
    );
    color: #020617;
    font-weight: 600;
    border: none;
  }

  .btn-custom:hover {
    box-shadow: 0 12px 35px rgba(59,130,246,0.45);
    transform: translateY(-1px);
    color: #020617;
  }

  /* ================= POPUP ================= */
  .popup-overlay {
    position: fixed;
    inset: 0;
    background: rgba(2,6,23,0.75);
    backdrop-filter: blur(6px);
    display: none;
    align-items: center;
    justify-content: center;
    z-index: 9999;
  }

  .popup-box {
    background: #020617;
    padding: 35px 45px;
    border-radius: 18px;
    text-align: center;
    box-shadow:
      0 25px 60px rgba(0,0,0,0.7),
      inset 0 0 0 1px rgba(59,130,246,0.15);
  }

  .popup-box h4 {
    margin-bottom: 10px;
    font-weight: 600;
  }

  .popup-box p {
    color: var(--text-muted);
  }

  .popup-box.success h4 {
    color: var(--accent-blue);
  }

  .popup-box.error h4 {
    color: #ef4444;
  }
  .btn-back {
  background: linear-gradient(135deg, #7c3aed, #a855f7);
  color: white;
  border: none;
  font-weight: 600;
  padding: 6px 16px;
  border-radius: 30px;
  font-size: 0.85rem;
  transition: all 0.3s ease;
}

.btn-back:hover {
  box-shadow: 0 12px 30px rgba(168,85,247,0.45);
  transform: translateY(-2px);
  color: white;
}
</style>

</head>
<body>
<!-- Success Popup -->
<div id="successPopup" class="popup-overlay">
  <div class="popup-box success">
    <h4>Request Sent Successfully</h4>
    <p>Admin will review your request soon.</p>
  </div>
</div>

<!-- Error Popup -->
<div id="errorPopup" class="popup-overlay">
  <div class="popup-box error">
    <h4>Request Failed</h4>
    <p>Please try again later.</p>
  </div>
</div>

<div class="request-box">
  <a href="index.php" class="btn btn-back mb-3">
  ← Back to Home
  </a>
  <h2>Request to Become a Vendor</h2>
  <p>
    You are currently registered as a user.<br>
    If you want to list your turf and accept bookings, please submit a request.
    Our admin team will review it and get back to you.
  </p>

  <form method="post" action="#">
    <div class="mb-3">
      <label>Business / Turf Name</label>
      <input type="text" name="turf_name" class="form-control" required>
    </div>

    <div class="mb-3">
      <label>City</label>
      <input type="text" name="city" class="form-control" required>
    </div>

    <div class="mb-3">
      <label>Why do you want to become a vendor?</label>
      <textarea name="reason" class="form-control" rows="4" required></textarea>
    </div>

    <button type="submit" class="btn btn-custom w-100" name="submitReq">
      Submit Request
    </button>
  </form>
</div>
<script>
<?php if ($success): ?>
  document.getElementById("successPopup").style.display = "flex";
  setTimeout(() => {
    window.location.replace("index.php");
  }, 2000);
<?php endif; ?>

<?php if ($error): ?>
  document.getElementById("errorPopup").style.display = "flex";
<?php endif; ?>
</script>

</body>
</html>
