<?php session_start(); ?>

<!DOCTYPE html>
<html>
<head>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Reports</title>

    <style>
        body {
            background: #0b1120;
            color: white;
            font-family: sans-serif;
            margin: 0;
        }

        h2 {
            margin-bottom: 20px;
        }

        .page {
            max-width: 1100px;
            margin: 0 auto;
            padding: 28px 20px 36px;
        }

        .cards {
            display: flex;
            gap: 20px;
            flex-wrap: wrap;
        }

        .card {
            width: 250px;
            max-width: 100%;
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

        @media (max-width: 768px) {
            .page {
                padding: 22px 14px 28px;
            }

            .cards {
                flex-direction: column;
            }

            .card {
                width: 100%;
            }
        }
    </style>
</head>

<body>

<div class="page">
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
</div>

<script>
function go(page){
    window.location.href = page;
}
</script>

</body>
</html>
