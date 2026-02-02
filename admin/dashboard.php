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
    <style>
        body { background: #020617; color: #fff; font-family: 'Segoe UI', sans-serif; }
        .navbar { background: rgba(15, 23, 42, 0.9); border-bottom: 1px solid #1e293b; }
        .card-custom { background: #0b1120; border: 1px solid #1e293b; border-radius: 12px; transition: 0.3s; }
        .card-custom:hover { border-color: #eb7e25; transform: translateY(-5px); }
        .text-orange { color: #eb7e25; }
        .btn-orange { background: #eb7e25; color: #000; font-weight: 600; }
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
            <h2>Welcome back, Admin 👋</h2>
            <p class="text-secondary">Manage your turf requests and platform users from here.</p>
        </div>
        
        <div class="col-md-4">
            <div class="card card-custom p-4">
                <i class="bi bi-person-badge text-orange fs-1 mb-3"></i>
                <h4>Vendor Requests</h4>
                <p class="text-secondary">Review and approve new turf owners.</p>
                <a href="vendor_requests.php" class="btn btn-orange w-100">Open Requests</a>
            </div>
        </div>
    </div>
</div>

</body>
</html>