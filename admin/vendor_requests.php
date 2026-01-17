<?php
session_start();
include("../db.php");

// 🔒 Admin auth check (enable later for production)
// if (!isset($_SESSION['admin'])) {
//     header("Location: login.php");
//     exit;
// }

/* ===============================
   FETCH PENDING VENDOR REQUESTS
   =============================== */
$sql = "
SELECT 
    t.turf_id,
    t.turf_name,
    t.location,
    u.name,
    u.email
FROM turftb t
JOIN vendorrequesttb vr ON vr.id = t.turf_id
JOIN `user` u ON t.owner_id = u.id
WHERE vr.status = 'pending'
";

$result = mysqli_query($conn, $sql);
if (!$result) {
    die("Query failed: " . mysqli_error($conn));
}

/* ✅ SINGLE SOURCE OF TRUTH */
$hasData = mysqli_num_rows($result) > 0;

$historySql = "
SELECT 
    t.turf_name,
    t.location,
    u.name,
    u.email,
    vr.status
FROM turftb t
JOIN vendorrequesttb vr ON vr.id = t.turf_id
JOIN `user` u ON t.owner_id = u.id
WHERE vr.status IN ('approved', 'rejected')
ORDER BY vr.id DESC
";

$historyResult = mysqli_query($conn, $historySql);
if (!$historyResult) {
    die("History query failed: " . mysqli_error($conn));
}

$hasHistory = mysqli_num_rows($historyResult) > 0;
?>

<!DOCTYPE html>
<html>
<head>
<title>Vendor Requests</title>

<script src="https://cdn.jsdelivr.net/npm/@tailwindcss/browser@4"></script>
<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">

<style>
/* ===== ADMIN THEME ===== */
body {
    background-color: #0f172a;
}

.admin-card {
    background-color: #020617;
    border-radius: 12px;
    padding: 24px;
    box-shadow: 0 10px 30px rgba(0,0,0,0.6);
}

.table thead th {
    background-color: #636B2F;
    color: #000000;
    border-color: #334155;
}

.table tbody tr {
    background-color: #000000;
    color: #ffffff;
}

.action-btns a,
.action-btns button {
    margin-right: 6px;
}

.status-approved {
    background-color: #07a340;
    color: white;
    padding: 4px 10px;
    border-radius: 999px;
    font-size: 0.8rem;
}

.status-rejected {
    background-color: #e01313;
    color: white;
    padding: 4px 10px;
    border-radius: 999px;
    font-size: 0.8rem;
}

</style>
</head>

<body>

<!-- CENTERED LAYOUT -->
<div class="min-h-[35vw] flex items-center justify-center">

    <div class="admin-card w-[90%] max-w-6xl">

        <h3 class="text-2xl font-semibold text-white mb-4">
            Pending Vendor Requests
        </h3>

        <!-- TABLE -->
        <table class="table table-bordered align-middle">
            <thead>
                <tr>
                    <th>Owner</th>
                    <th>Email</th>
                    <th>Turf</th>
                    <th>Location</th>
                    <th style="width:180px;">Action</th>
                </tr>
            </thead>

            <tbody>

            <?php if ($hasData) { ?>
                <!-- ================= REAL DATA ================= -->
                <?php while ($row = mysqli_fetch_assoc($result)) { ?>
                <tr>
                    <td><?= htmlspecialchars($row['name']) ?></td>
                    <td><?= htmlspecialchars($row['email']) ?></td>
                    <td><?= htmlspecialchars($row['turf_name']) ?></td>
                    <td><?= htmlspecialchars($row['location']) ?></td>
                    <td class="action-btns">
                        <a href="approve_vendor.php?id=<?= $row['turf_id'] ?>"
                           class="btn btn-success btn-sm">
                           Approve
                        </a>
                        <a href="reject_vendor.php?id=<?= $row['turf_id'] ?>"
                           class="btn btn-danger btn-sm">
                           Reject
                        </a>
                    </td>
                </tr>
                <?php } ?>

            <?php } else { ?>
                <!-- ================= DUMMY DATA (UI PREVIEW) ================= -->
                <tr class="opacity-75">
                    <td>Rahul Sharma</td>
                    <td>rahul@gmail.com</td>
                    <td>GreenField Arena</td>
                    <td>Andheri West</td>
                    <td class="action-btns">
                        <button class="btn btn-success btn-sm" disabled>Approve</button>
                        <button class="btn btn-danger btn-sm" disabled>Reject</button>
                    </td>
                </tr>

                <tr class="opacity-75">
                    <td>Amit Verma</td>
                    <td>amit@gmail.com</td>
                    <td>Urban Kick Turf</td>
                    <td>Powai</td>
                    <td class="action-btns">
                        <button class="btn btn-success btn-sm" disabled>Approve</button>
                        <button class="btn btn-danger btn-sm" disabled>Reject</button>
                    </td>
                </tr>

                <tr class="opacity-75">
                    <td>Sneha Patel</td>
                    <td>sneha@gmail.com</td>
                    <td>SkyBox Sports</td>
                    <td>Vashi</td>
                    <td class="action-btns">
                        <button class="btn btn-success btn-sm" disabled>Approve</button>
                        <button class="btn btn-danger btn-sm" disabled>Reject</button>
                    </td>
                </tr>
            <?php } ?>

            </tbody>
        </table>

        <!-- BACK BUTTON -->
        <div class="mt-4">
            <a href="dashboard.php" class="btn btn-secondary">
                Back to Dashboard
            </a>
        </div>

    </div>
</div>
<!-- ================= HISTORY TABLE ================= -->
<h3 class="text-xl font-semibold text-white mt-10 mb-4">
    Vendor Request History
</h3>

<table class="table table-bordered align-middle">
    <thead>
        <tr>
            <th>Owner</th>
            <th>Email</th>
            <th>Turf</th>
            <th>Location</th>
            <th>Status</th>
        </tr>
    </thead>

    <tbody>
    <?php if ($hasHistory) { ?>

        <?php while ($row = mysqli_fetch_assoc($historyResult)) { ?>
        <tr>
            <td><?= htmlspecialchars($row['name']) ?></td>
            <td><?= htmlspecialchars($row['email']) ?></td>
            <td><?= htmlspecialchars($row['turf_name']) ?></td>
            <td><?= htmlspecialchars($row['location']) ?></td>
            <td>
                <?php if ($row['status'] === 'approved') { ?>
                    <span class="status-approved">Approved</span>
                <?php } else { ?>
                    <span class="status-rejected">Rejected</span>
                <?php } ?>
            </td>
        </tr>
        <?php } ?>

    <?php } else { ?>
        <tr>
            <td colspan="5" class="text-center text-gray-400 py-4">
                No request history available.
            </td>
        </tr>
    <?php } ?>
    </tbody>
</table>


</body>
</html>
