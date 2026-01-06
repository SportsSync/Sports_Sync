<?php
session_start();
if (!isset($_SESSION['admin'])) {
    header("Location: login.php");
    exit;
}
?>

<!DOCTYPE html>
<html>
<head>
<title>Admin Dashboard</title>
<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>

<nav class="navbar navbar-dark bg-dark px-4">
<span class="navbar-brand">Admin Panel</span>
<a href="login.php" class="btn btn-danger btn-sm">Logout</a>
</nav>

<div class="container mt-4">
<h3>Welcome Admin 👋</h3>

<a href="vendor_requests.php" class="btn btn-warning mt-3">
View Vendor Requests
</a>
</div>

</body>
</html>
