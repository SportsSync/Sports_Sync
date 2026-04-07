<?php
session_start();
// Check for the admin session we just set
if (!isset($_SESSION['admin']) || $_SESSION['role'] !== 'admin') {
    header("Location: ../signin.php");
    exit;
}
?>
<!DOCTYPE html>
<html>

<head>
    <title>Admin Dashboard | Sport Sync</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.5/font/bootstrap-icons.css">
    <link rel="stylesheet" href="../whole.css">
    <style>
         /* =======================
   BODY (same pattern, improved)
======================= */
body { 
  background-color: #0e0f11; 
  background-image: linear-gradient(45deg, #1f1f1f 25%, transparent 25%), 
                    linear-gradient(-45deg, #1f1f1f 25%, transparent 25%), 
                    linear-gradient(45deg, transparent 75%, #1f1f1f 75%),
                    linear-gradient(-45deg, transparent 75%, #1f1f1f 75%); 
  background-size: 8px 8px; 
  background-position: 0 0, 0 4px, 4px -4px, -4px 0px; 
}


/* =======================
   NAVBAR (match your navbar-top)
======================= */
.navbar {
    background: linear-gradient(
        90deg,
        rgba(18, 18, 18, 0.98),
        rgba(18, 18, 18, 0.9)
    );
    border-bottom: 1px solid var(--border-soft);
    backdrop-filter: blur(8px);
}


/* =======================
   CARD (match your card style)
======================= */
.card-custom {
    background: var(--card-bg);
    border: 1px solid var(--divider);
    border-radius: 14px;
    transition: transform 0.3s ease, box-shadow 0.3s ease;
}

.card-custom:hover {
    transform: scale(1.03);
    box-shadow: 0 0 15px #9526F3;
    border-color: #9526F3;
}


/* =======================
   TEXT COLOR (replace orange)
======================= */
.text-orange {
    color: #9526F3; /* your primary color */
    font-weight: 600;
}

/* =======================
   BUTTON (match your btn-success style)
======================= */
.btn-orange {
    background: transparent;
    border: 2px solid #9526F3;
    border-radius: 25px;
    padding: 6px 24px;
    color: #9526F3;
    cursor: pointer;
    position: relative;
    overflow: hidden;
    transition: color 0.35s ease, box-shadow 0.35s ease;
}

/* hover glow */
.btn-orange:hover {
    color: #fff;
    box-shadow: 0 0 12px rgba(149, 38, 243, 0.6);
}

/* fill animation */
.btn-orange::before {
    content: "";
    position: absolute;
    inset: 0;
    background: linear-gradient(135deg, #9526F3, #7a1fd6, #b44cff);
    transform: scaleX(0);
    transform-origin: left;
    transition: transform 0.4s ease;
    z-index: 0;
}

.btn-orange span {
    position: relative;
    z-index: 1;
}

.btn-orange:hover::before {
    transform: scaleX(1);
}
    </style>
</head>

<body>

    <nav class="navbar navbar-expand-lg navbar-dark px-4 py-3">
        <div class="container-fluid">
            <span class="navbar-brand fw-bold text-orange">SPORT SYNC <span class="text-white">ADMIN</span></span>
            <div class="d-flex align-items-center">
                <span class="text-secondary me-3"><?= $_SESSION['email'] ?></span>
                <a href="../logout.php" class="btn btn-outline-danger btn-sm">Logout</a>
            </div>
        </div>
    </nav>

    <div class="container mt-5">
        <div class="row">
            <div class="col-md-12 mb-4">
                <h2>Welcome back, Admin</h2>
                <p class="text-secondary">Manage your turf requests and platform users from here.</p>
            </div>

            <div class="row">
                <div class="col-md-4">
                    <div class="card card-custom p-4">
                        <i class="bi bi-person-badge text-orange fs-1 mb-3"></i>
                        <h4>Vendor Requests</h4>
                        <p class="text-secondary">Review and approve new turf owners.</p>
                        <a href="vendor_requests.php" class="btn btn-orange w-100">Open Requests</a>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="card card-custom p-4">
                        <i class="bi bi-chat-dots-fill text-orange fs-1 mb-3"></i>
                        <h4>Admin Chat</h4>
                        <p class="text-secondary">Chat with users and vendors.</p>
                        <a href="chat.php" class="btn btn-orange w-100">Open Chat</a>
                    </div>
                </div>
            </div>
        </div>

</body>

</html>