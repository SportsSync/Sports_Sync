<?php
session_start();
if (!isset($_SESSION['admin']) || $_SESSION['role'] !== 'admin') {
    header("Location: ../signin.php");
    exit;
}

include('../db.php');

$limit = 5;
$page = isset($_GET['page']) ? (int)$_GET['page'] : 1;
$start = ($page - 1) * $limit;


$query = "SELECT * FROM contact_us ORDER BY created_at DESC LIMIT $start, $limit";
$result = mysqli_query($conn, $query);

$totalQuery = "SELECT COUNT(*) as total FROM contact_us";
$totalResult = mysqli_query($conn, $totalQuery);
$totalRow = mysqli_fetch_assoc($totalResult);
$totalPages = ceil($totalRow['total'] / $limit);
?>
<!DOCTYPE html>
<html>
<head>
    <title>Contact Messages</title>
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- Bootstrap -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">

    <!-- Your CSS -->
    <link rel="stylesheet" href="whole.css">

    <style>
        body {
            background: #0d0d0d;
        }

        .table-box {
            background: #111;
            border-radius: 12px;
            padding: 20px;
        }

        .table thead {
            background: linear-gradient(90deg, #7b2ff7, #9f44d3);
            color: #fff;
        }

        .table tbody tr {
            background: #eaeaea;
            color: #000;
        }

        .pagination .page-link {
            background: #111;
            color: #9f44d3;
            border: 1px solid #9f44d3;
        }

        .pagination .active .page-link {
            background: #9f44d3;
            color: #fff;
        }
        .btn-dashboard {
            background: transparent;
            border: 2px solid #9526F3;
            border-radius: 25px;
            padding: 6px 24px;
            color: #9526F3;
            position: relative;
            overflow: hidden;
            transition: color 0.35s ease, box-shadow 0.35s ease;
            z-index: 1;
        }

        /* hover glow */
        .btn-dashboard:hover {
            color: #fff;
            box-shadow: 0 0 12px rgba(149, 38, 243, 0.6);
        }

        /* animation layer */
        .btn-dashboard::before {
            content: "";
            position: absolute;
            inset: 0;
            background: linear-gradient(135deg, #9526F3, #7a1fd6, #b44cff);
            transform: scaleX(0);
            transform-origin: left;
            transition: transform 0.4s ease;
            z-index: 0;
        }

        /* TEXT ABOVE */
        .btn-dashboard span {
            position: relative;
            z-index: 2;
            transition: color 0.3s ease;
        }

        /* hover text color */
        .btn-dashboard:hover span {
            color: #fff;
        }

        /* trigger animation */
        .btn-dashboard:hover::before {
            transform: scaleX(1);
        }
    </style>
</head>

<body>

<div class="container mt-5">
    <div class="table-box">

        <h3 class="text-orange mb-4">Contact Messages</h3>

        <table class="table table-bordered">
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Name</th>
                    <th>Email</th>
                    <th>Phone</th>
                    <th>Description</th>
                    <th>Date</th>
                </tr>
            </thead>

            <tbody>
                <?php if (mysqli_num_rows($result) > 0): ?>
                    <?php while ($row = mysqli_fetch_assoc($result)): ?>
                        <tr>
                            <td><?= $row['id'] ?></td>
                            <td><?= $row['name'] ?></td>
                            <td><?= $row['email'] ?></td>
                            <td><?= $row['phone'] ?></td>
                            <td><?= $row['description'] ?></td>
                            <td><?= $row['created_at'] ?></td>
                        </tr>
                    <?php endwhile; ?>
                <?php else: ?>
                    <tr>
                        <td colspan="6" class="text-center">No messages found</td>
                    </tr>
                <?php endif; ?>
            </tbody>
        </table>

        <!-- Pagination -->
        <nav>
            <ul class="pagination justify-content-center mt-3">
                <?php for ($i = 1; $i <= $totalPages; $i++): ?>
                    <li class="page-item <?= ($i == $page) ? 'active' : '' ?>">
                        <a class="page-link" href="?page=<?= $i ?>">
                            <?= $i ?>
                        </a>
                    </li>
                <?php endfor; ?>
            </ul>
        </nav>

        <a href="dashboard.php" class="btn btn-dashboard mt-3"><span> Back to Dashboard</span></a>

    </div>
</div>

</body>
</html>