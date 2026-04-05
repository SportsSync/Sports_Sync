<?php
session_start();

$conn = new mysqli("localhost:3306", "root", "", "turf_booking_system");

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// ================= AJAX =================
if (isset($_GET['ajax'])) {

    $turf = $_GET['turf_id'] ?? 'all';

    // ALWAYS LAST 7 DAYS
    $dates = [];
    $today = new DateTime();

    for ($i = 6; $i >= 0; $i--) {
        $d = clone $today;
        $d->modify("-$i days");
        $dates[$d->format("Y-m-d")] = 0;
    }

    $start = array_key_first($dates);
    $end   = array_key_last($dates);

    // QUERY
    if ($turf === "all") {
        $stmt = $conn->prepare("
            SELECT DATE(booking_date) as booking_date, SUM(total_amount) as total
            FROM bookingtb
            WHERE DATE(booking_date) BETWEEN ? AND ?
            GROUP BY DATE(booking_date)
        ");
        $stmt->bind_param("ss", $start, $end);
    } else {
        $stmt = $conn->prepare("
            SELECT DATE(booking_date) as booking_date, SUM(total_amount) as total
            FROM bookingtb
            WHERE DATE(booking_date) BETWEEN ? AND ?
            AND turf_id = ?
            GROUP BY DATE(booking_date)
        ");
        $stmt->bind_param("ssi", $start, $end, $turf);
    }

    $stmt->execute();
    $res = $stmt->get_result();

    while ($row = $res->fetch_assoc()) {
        $dates[$row['booking_date']] = (float)$row['total'];
    }

    // FORMAT DATA
    $data = [];
    foreach ($dates as $date => $total) {
        $data[] = [
            "booking_date" => $date,
            "total" => $total
        ];
    }

    // INSIGHTS
    $peak = $data[0];
    $low = $data[0];

    foreach ($data as $d) {
        if ($d['total'] > $peak['total']) $peak = $d;
        if ($d['total'] < $low['total']) $low = $d;
    }

    echo json_encode([
        "data" => $data,
        "insights" => [
            "peak_day" => $peak,
            "low_day" => $low
        ]
    ]);

    exit;
}
?>

<!DOCTYPE html>
<html>
<head>
<title>Earnings Report</title>

<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>

<style>
body {
    background: #0b1120;
    color: white;
    font-family: sans-serif;
}

.filterInput {
    padding: 10px 14px;
    border-radius: 10px;
    background: #1e293b;
    color: white;
    border: 1px solid #334155;
}

.applyBtn {
    padding: 10px 18px;
    border-radius: 10px;
    background: #2563eb;
    color: white;
    cursor: pointer;
}

.turfContainer {
    display: flex;
    justify-content: center;
    gap: 15px;
    flex-wrap: wrap;
}

.turfCard {
    width: 140px;
    padding: 10px;
    border-radius: 12px;
    background: #0f172a;
    text-align: center;
    cursor: pointer;
    border: 1px solid transparent;
    transition: 0.2s;
}

.turfCard img {
    width: 100%;
    height: 80px;
    object-fit: cover;
    border-radius: 8px;
}

.turfCard:hover {
    transform: translateY(-4px);
    background: #1e293b;
}

.turfCard.active {
    border: 2px solid #3b82f6;
    background: #1e293b;
}

canvas {
    margin-top: 20px;
    max-height: 300px;
}

table {
    width: 100%;
    margin-top: 20px;
}

th, td {
    padding: 10px;
    border-bottom: 1px solid #1e293b;
}
</style>
</head>

<body>

<div style="max-width:1100px; margin:auto; padding:20px;">

<h2>Earnings Report</h2>

<!-- TURFS -->
<div id="turfCards" class="turfContainer"></div>

<!-- INSIGHTS -->
<div style="display:flex; justify-content:center; gap:30px; margin-top:15px;">
    <div id="peak" style="color:#22c55e;"></div>
    <div id="low" style="color:#ef4444;"></div>
</div>

<!-- CHART -->
<canvas id="chart"></canvas>

<!-- TABLE -->
<table>
<thead>
<tr>
    <th>Date</th>
    <th>Earnings (₹)</th>
</tr>
</thead>
<tbody id="tbody"></tbody>
</table>

</div>

<script>
let chart;
let selectedTurf = "all";

// LOAD TURFS
async function loadTurfs(){

    let res = await fetch('../api/get_vendor_turfs.php');
    let data = await res.json();

    let html = `
    <div class="turfCard active" onclick="selectTurf('all', this)">
        <p>All</p>
    </div>`;

    data.forEach(t=>{
        html += `
        <div class="turfCard" onclick="selectTurf(${t.turf_id}, this)">
            <img src="../turf_images/${t.image_path}" 
                 onerror="this.src='../turf_images/default.jpg'">
            <p>${t.turf_name}</p>
        </div>`;
    });

    document.getElementById('turfCards').innerHTML = html;
}

// SELECT TURF
function selectTurf(id, el){

    selectedTurf = id;

    document.querySelectorAll('.turfCard').forEach(c=>{
        c.classList.remove('active');
    });

    el.classList.add('active');

    loadData();
}

// LOAD DATA
async function loadData(){

    let res = await fetch(`earning_report.php?ajax=1&turf_id=${selectedTurf}`);
    let result = await res.json();

    let data = result.data;

    // TABLE
    let html = "";
    data.forEach(d=>{
        html += `<tr>
            <td>${d.booking_date}</td>
            <td>₹${d.total}</td>
        </tr>`;
    });

    document.getElementById('tbody').innerHTML = html;

    // CHART
    let labels = data.map(d=>d.booking_date);
    let values = data.map(d=>d.total);

    if(chart) chart.destroy();

    chart = new Chart(document.getElementById('chart'), {
        type: 'bar',
        data: {
            labels: labels,
            datasets: [{
                label: 'Last 7 Days Earnings',
                data: values
            }]
        },
        options: {
            responsive: true,
            plugins: {
                legend: {
                    labels: { color: "#94a3b8" }
                }
            },
            scales: {
                x: { ticks: { color: "#94a3b8" } },
                y: { ticks: { color: "#94a3b8" } }
            }
        }
    });

    // INSIGHTS
    let peak = result.insights.peak_day;
    let low = result.insights.low_day;

    document.getElementById('peak').innerHTML =
        `🔥 Highest: ${peak.booking_date} (₹${peak.total})`;

    document.getElementById('low').innerHTML =
        `📉 Lowest: ${low.booking_date} (₹${low.total})`;
}

// INIT
window.onload = () => {
    loadTurfs();
    loadData();
};
</script>

</body>
</html>