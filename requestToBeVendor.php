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
  <style>
    body {
      background-color: #1C1C1C;
      color: #F7F6F2;
      font-family: 'Segoe UI', sans-serif;
    }
    .request-box {
      background: rgba(0,0,0,0.85);
      padding: 40px;
      border-radius: 16px;
      max-width: 600px;
      margin: 80px auto;
      box-shadow: 0 0 30px rgba(209,255,113,0.2);
    }
    h2 {
      color: #D1FF71;
      margin-bottom: 15px;
    }
    p {
      color: #BDBDBD;
      font-size: 0.95rem;
    }
    .btn-custom {
      background-color: #D1FF71;
      color: #000;
      font-weight: 600;
    }
    .btn-custom:hover {
      background-color: #bfe85f;
      color: #000;
    }
    label {
      color: #ccc;
    }
    .popup-overlay {
  position: fixed;
  inset: 0;
  background: rgba(0,0,0,0.7);
  backdrop-filter: blur(5px);
  display: none;
  align-items: center;
  justify-content: center;
  z-index: 9999;
}

.popup-box {
  background: #111;
  padding: 35px 45px;
  border-radius: 18px;
  text-align: center;
  box-shadow: 0 0 30px rgba(0,0,0,0.6);
}

.popup-box h4 {
  margin-bottom: 10px;
}

.popup-box p {
  color: #ccc;
}

.popup-box.success h4 {
  color: #D1FF71;
}

.popup-box.error h4 {
  color: #dc3545;
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
