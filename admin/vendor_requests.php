<?php
session_start();
include("../db.php");

if (!isset($_SESSION['admin'])) {
    header("Location: login.php");
    exit;
}

$sql = "
SELECT 
t.turf_id,
t.turf_name,
t.location,
t.description,
t.status,
u.name,
u.email
FROM turftb t
JOIN user u ON t.owner_id = u.id
WHERE t.status = 'pending'
";

$result = mysqli_query($conn, $sql);
?>

<!DOCTYPE html>
<html>
<head>
<title>Vendor Requests</title>
<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>

<div class="container mt-4">
<h3>Pending Vendor Requests</h3>

<table class="table table-bordered mt-3">
<tr>
<th>Owner</th>
<th>Email</th>
<th>Turf</th>
<th>Location</th>
<th>Action</th>
</tr>

<?php while($row = mysqli_fetch_assoc($result)) { ?>
<tr>
<td><?= $row['name'] ?></td>
<td><?= $row['email'] ?></td>
<td><?= $row['turf_name'] ?></td>
<td><?= $row['location'] ?></td>
<td>
<a href="approve_vendor.php?id=<?= $row['turf_id'] ?>" class="btn btn-success btn-sm">Approve</a>
<a href="reject_vendor.php?id=<?= $row['turf_id'] ?>" class="btn btn-danger btn-sm">Reject</a>
</td>
</tr>
<?php } ?>

</table>

<a href="dashboard.php" class="btn btn-secondary">Back</a>
</div>

</body>
</html>
