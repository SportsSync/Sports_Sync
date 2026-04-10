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
<meta name="viewport" content="width=device-width, initial-scale=1.0">

<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">

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

.admin-card {
    background:#121212;
    padding:24px;
    border: 1px solid #262626;
    border-radius:12px;
    box-shadow:0 10px 30px rgba(0,0,0,.45);
}

.table thead th {
    background:#9526F3;
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

.table-wrap {
    overflow-x: auto;
}

.action-buttons {
    display: flex;
    gap: 8px;
    flex-wrap: wrap;
}
.btn-dashboard{
    background: transparent;
    border: 2px solid #9526F3;
    border-radius: 25px;
    padding: 6px 24px;
    color: #9526F3;
    position: relative;
    overflow: hidden;
}
@media (max-width: 768px) {
    .container.admin-card {
        margin-top: 1.5rem !important;
        padding: 18px 14px;
    }

    .action-buttons {
        flex-direction: column;
    }

    .action-buttons .btn,
    .table-wrap table {
        width: 100%;
    }

    .table th,
    .table td {
        white-space: nowrap;
    }
}
</style>
</head>

<body>

<div class="container mt-5 admin-card">

<h3 class="mb-4 text-white">Pending Vendor Requests</h3>

<div class="table-wrap">
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
        <div class="action-buttons">
            <a href="approve_vendor.php?id=<?= $row['request_id'] ?>" class="btn btn-success btn-sm">Approve</a>
            <a href="reject_vendor.php?id=<?= $row['request_id'] ?>" class="btn btn-danger btn-sm">Reject</a>
        </div>
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
</div>

<a href="dashboard.php" class="btn btn-dashboard mt-3">Back to Dashboard</a>

<hr class="my-5">

<h4 class="text-white">Vendor Request History</h4>

<div class="table-wrap">
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

</div>

</body>
</html>
