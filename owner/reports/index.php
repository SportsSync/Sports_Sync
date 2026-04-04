<?php session_start(); ?>

<!DOCTYPE html>
<html>
<head>
    <title>Reports</title>

    <style>
        body {
            background: #0b1120;
            color: white;
            font-family: sans-serif;
        }

        h2 {
            margin-bottom: 20px;
        }

        .cards {
            display: flex;
            gap: 20px;
        }

        .card {
            width: 250px;
            padding: 20px;
            border-radius: 15px;
            background: linear-gradient(145deg, #0f172a, #020617);
            box-shadow: 0 0 20px rgba(0,0,0,0.5);
            cursor: pointer;
            transition: 0.3s;
        }

        .card:hover {
            transform: translateY(-5px);
        }

        .card h3 {
            margin-bottom: 10px;
        }

        .card p {
            color: #94a3b8;
        }
    </style>
</head>

<body>

<h2>Reports</h2>

<div class="cards">

    <div class="card" onclick="go('peak_hours.php')">
        <h3>Peak Hour Analysis</h3>
        <p>Understand most booked time slots</p>
    </div>

    <div class="card" onclick="go('earning_report.php')">
        <h3>Earnings Report</h3>
        <p>Track your revenue trends</p>
    </div>

</div>

<script>
function go(page){
    window.location.href = page;
}
</script>

</body>
</html>