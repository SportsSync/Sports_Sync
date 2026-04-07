<?php
session_start();
include('../db.php');

if (!isset($_SESSION['admin']) || $_SESSION['role'] !== 'admin') {
    header("Location: ../signin.php");
    exit;
}

// Filters
$search = $_GET['search'] ?? '';
$status = $_GET['status'] ?? 'all';
$role = $_GET['role'] ?? 'all';
// Pagination
$limit = 5;
$page = isset($_GET['page']) ? (int) $_GET['page'] : 1;
$offset = ($page - 1) * $limit;

// Base Query
$where = "WHERE u.role != 'admin'";

// Search
if (!empty($search)) {
    $search = mysqli_real_escape_string($conn, $search);
    $where .= " AND (u.name LIKE '%$search%' OR u.email LIKE '%$search%' OR u.mobile LIKE '%$search%')";
}

// Status filter
if ($status != 'all') {
    $where .= " AND u.status='$status'";
}
if ($role != 'all') {
    $where .= " AND u.role='$role'";
}
// Count total users
$countQuery = "SELECT COUNT(*) as total FROM user u $where";
$countResult = mysqli_query($conn, $countQuery);
$totalRows = mysqli_fetch_assoc($countResult)['total'];
$totalPages = ceil($totalRows / $limit);

// Main query
$query = "
SELECT u.*, COUNT(b.booking_id) as total_bookings
FROM user u
LEFT JOIN bookingtb b ON u.id = b.user_id
$where
GROUP BY u.id
ORDER BY total_bookings DESC
LIMIT $limit OFFSET $offset
";

$result = mysqli_query($conn, $query);
?>

<!DOCTYPE html>
<html>

<head>
    <title>Manage Users</title>
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">

    <style>
        body {
            background: #020617;
            color: #fff;
        }

        .card-custom {
            background: #0b1120;
            border: 1px solid #1e293b;
            border-radius: 12px;
        }

        .text-orange {
            color: #eb7e25;
        }

        .badge-active {
            background: #16a34a;
        }

        .badge-blocked {
            background: #dc2626;
        }

        .form-control,
        .form-select {
            background: #0b1120;
            border: 1px solid #1e293b;
            color: #fff;
        }

        .form-control::placeholder {
            color: #aaa;
        }

        .btn-orange {
            background: #eb7e25;
            color: #000;
            font-weight: 600;
        }

        .pagination .page-link {
            background: #0b1120;
            border: 1px solid #1e293b;
            color: #fff;
        }

        .pagination .active .page-link {
            background: #eb7e25;
            color: #000;
        }
    </style>
</head>

<body>

    <div class="container-fluid px-3 px-md-4 mt-4">

        <h4 class="mb-3">User Management</h4>

        <!-- 🔍 FILTERS -->
        <form method="GET" class="row g-2 mb-3">

            <div class="col-12">
                <input type="text" name="search" value="<?= htmlspecialchars($search) ?>" class="form-control"
                    placeholder="Search user...">
            </div>

            <div class="col-6">
                <select name="status" class="form-select">
                    <option value="all">All Status</option>
                    <option value="active" <?= $status == 'active' ? 'selected' : '' ?>>Active</option>
                    <option value="blocked" <?= $status == 'blocked' ? 'selected' : '' ?>>Blocked</option>
                </select>
            </div>

            <div class="col-6">
                <select name="role" class="form-select">
                    <option value="all">All Roles</option>
                    <option value="User" <?= $role == 'User' ? 'selected' : '' ?>>User</option>
                    <option value="Vendor" <?= $role == 'Vendor' ? 'selected' : '' ?>>Vendor</option>
                </select>
            </div>

            <div class="col-12">
                <button class="btn btn-orange w-100">Apply Filters</button>
            </div>

        </form>

        <!-- 💻 DESKTOP TABLE -->
        <div class="card card-custom p-3 d-none d-md-block">
            <div class="table-responsive">
                <table class="table table-dark text-center align-middle mb-0">

                    <thead>
                        <tr>
                            <th>Name</th>
                            <th>Email</th>
                            <th>Bookings</th>
                            <th>Status</th>
                            <th>Action</th>
                        </tr>
                    </thead>

                    <tbody>
                        <?php while ($row = mysqli_fetch_assoc($result)) { ?>
                            <tr>
                                <td><?= $row['name'] ?></td>
                                <td class="small"><?= $row['email'] ?></td>
                                <td><strong><?= $row['total_bookings'] ?></strong></td>

                                <td>
                                    <?= $row['status'] == 'active'
                                        ? '<span class="badge badge-active">Active</span>'
                                        : '<span class="badge badge-blocked">Blocked</span>' ?>
                                </td>

                                <td>
                                    <?php if ($row['status'] == 'active') { ?>
                                        <a href="block_user.php?id=<?= $row['id'] ?>" class="btn btn-danger btn-sm">Block</a>
                                    <?php } else { ?>
                                        <a href="unblock_user.php?id=<?= $row['id'] ?>"
                                            class="btn btn-success btn-sm">Unblock</a>
                                    <?php } ?>
                                </td>
                            </tr>
                        <?php } ?>
                    </tbody>

                </table>
            </div>
        </div>

        <!-- 📱 MOBILE CARDS -->
        <div class="d-md-none">
            <?php
            mysqli_data_seek($result, 0);
            while ($row = mysqli_fetch_assoc($result)) {
                ?>
                <div class="card card-custom p-3 mb-3">

                    <h5><?= $row['name'] ?></h5>
                    <p class="small text-secondary"><?= $row['email'] ?></p>

                    <div class="mt-2">
                        <div class="label">Bookings</div>
                        <div class="value"><?= $row['total_bookings'] ?></div>
                    </div>

                    <div class="mt-2">
                        <div class="label">Status</div>
                        <?= $row['status'] == 'active'
                            ? '<span class="badge bg-success">Active</span>'
                            : '<span class="badge bg-danger">Blocked</span>' ?>
                    </div>

                    <div class="d-flex justify-content-between mt-1">
                        <span>Status</span>
                        <?= $row['status'] == 'active'
                            ? '<span class="badge badge-active">Active</span>'
                            : '<span class="badge badge-blocked">Blocked</span>' ?>
                    </div>

                    <div class="mt-3">
                        <?php if ($row['status'] == 'active') { ?>
                            <a href="block_user.php?id=<?= $row['id'] ?>" class="btn btn-danger w-100">Block</a>
                        <?php } else { ?>
                            <a href="unblock_user.php?id=<?= $row['id'] ?>" class="btn btn-success w-100">Unblock</a>
                        <?php } ?>
                    </div>

                </div>
            <?php } ?>
        </div>

        <!-- 📄 PAGINATION -->
        <nav class="mt-4">
            <ul class="pagination justify-content-center">

                <?php for ($i = 1; $i <= $totalPages; $i++) { ?>
                    <li class="page-item <?= $i == $page ? 'active' : '' ?>">
                        <a class="page-link"
                            href="?page=<?= $i ?>&search=<?= $search ?>&status=<?= $status ?>&role=<?= $role ?>">
                            <?= $i ?>
                        </a>
                    </li>
                <?php } ?>

            </ul>
        </nav>

    </div>

</body>

</html>