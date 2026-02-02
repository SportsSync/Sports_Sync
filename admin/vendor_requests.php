<?php
session_start();
include("../db.php");

if (!isset($_SESSION['admin']) || $_SESSION['role'] !== 'admin') {
    header("Location: ../signin.php");
    exit;
}

/* ===============================
   FETCH PENDING REQUESTS
   =============================== */
$sql = "
SELECT 
    vr.id AS request_id,
    vr.turf_name,
    vr.city,
    vr.reason,
    vr.status,
    u.name,
    u.email
FROM vendorrequesttb vr
JOIN user u ON vr.user_id = u.id
WHERE vr.status = 'P'
ORDER BY vr.created_At DESC
";

$result = mysqli_query($conn, $sql);
$hasData = mysqli_num_rows($result) > 0;

/* ===============================
   FETCH HISTORY
   =============================== */
$historySql = "
SELECT 
    vr.turf_name,
    vr.city,
    vr.status,
    u.name,
    u.email
FROM vendorrequesttb vr
JOIN user u ON vr.user_id = u.id
WHERE vr.status IN ('A','R')
ORDER BY vr.created_At DESC
";

$historyResult = mysqli_query($conn, $historySql);
$hasHistory = mysqli_num_rows($historyResult) > 0;
?>

<!DOCTYPE html>
<html>
<head>
<title>Vendor Requests</title>

<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">

<style>
body { background:#020617; color:#fff; }

.admin-card {
    background:#020617;
    padding:24px;
    border-radius:12px;
    box-shadow:0 10px 30px rgba(0,0,0,.45);
}

.table thead th {
    background:#111827;
    color:#fff;
}

.table tbody tr {
    background:#0b1120;
    color:#fff;
}

.status-approved {
    background:#22c55e;
    padding:4px 10px;
    border-radius:999px;
    font-size:.8rem;
}

.status-rejected {
    background:#ef4444;
    padding:4px 10px;
    border-radius:999px;
    font-size:.8rem;
}
</style>
</head>

<body>

<div class="container mt-5 admin-card">

<h3 class="mb-4">Pending Vendor Requests</h3>

<table class="table table-bordered align-middle">
<thead>
<tr>
    <th>Owner</th>
    <th>Email</th>
    <th>Turf Name</th>
    <th>City</th>
    <th>Reason</th>
    <th style="width:160px;">Action</th>
</tr>
</thead>

<tbody>
<?php if ($hasData): ?>
<?php while($row = mysqli_fetch_assoc($result)): ?>
<tr>
    <td><?= htmlspecialchars($row['name']) ?></td>
    <td><?= htmlspecialchars($row['email']) ?></td>
    <td><?= htmlspecialchars($row['turf_name']) ?></td>
    <td><?= htmlspecialchars($row['city']) ?></td>
    <td><?= htmlspecialchars($row['reason']) ?></td>
    <td>
        <a href="approve_vendor.php?id=<?= $row['request_id'] ?>" class="btn btn-success btn-sm">Approve</a>
        <a href="reject_vendor.php?id=<?= $row['request_id'] ?>" class="btn btn-danger btn-sm">Reject</a>
    </td>
</tr>
<?php endwhile; ?>
<?php else: ?>
<tr>
<td colspan="6" class="text-center text-secondary">No pending requests</td>
</tr>
<?php endif; ?>
</tbody>
</table>

<a href="dashboard.php" class="btn btn-secondary mt-3">Back to Dashboard</a>

<hr class="my-5">

<h4>Vendor Request History</h4>

<table class="table table-bordered align-middle mt-3">
<thead>
<tr>
    <th>Owner</th>
    <th>Email</th>
    <th>Turf</th>
    <th>City</th>
    <th>Status</th>
</tr>
</thead>

<tbody>
<?php if ($hasHistory): ?>
<?php while($row = mysqli_fetch_assoc($historyResult)): ?>
<tr>
    <td><?= $row['name'] ?></td>
    <td><?= $row['email'] ?></td>
    <td><?= $row['turf_name'] ?></td>
    <td><?= $row['city'] ?></td>
    <td>
        <?php if ($row['status'] === 'A'): ?>
            <span class="status-approved">Approved</span>
        <?php else: ?>
            <span class="status-rejected">Rejected</span>
        <?php endif; ?>
    </td>
</tr>
<?php endwhile; ?>
<?php else: ?>
<tr>
<td colspan="5" class="text-center text-secondary">No history available</td>
</tr>
<?php endif; ?>
</tbody>
</table>

</div>

</body>
</html>
