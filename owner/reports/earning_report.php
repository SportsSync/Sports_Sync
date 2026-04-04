<?php
session_start();

$conn = new mysqli("localhost:3306", "root", "", "turf_booking_system");

// ================= AJAX =================
if (isset($_GET['ajax'])) {

    $start = $_GET['start_date'] ?? null;
    $end   = $_GET['end_date'] ?? null;
    $turf  = $_GET['turf_id'] ?? 'all';

    // DEFAULT: last 7 days
    if (!$start || !$end) {
        $end = date("Y-m-d");
        $start = date("Y-m-d", strtotime("-6 days"));
    }

    $sql = "
    SELECT booking_date, SUM(total_amount) as total
    FROM bookingtb
    WHERE booking_date BETWEEN '$start' AND '$end'
    ";

    if ($turf !== "all") {
        $sql .= " AND turf_id = '$turf'";
    }

    $sql .= " GROUP BY booking_date ORDER BY booking_date";

    $res = $conn->query($sql);

    if (!$res) {
        echo json_encode(["error" => $conn->error]);
        exit;
    }

    $data = $res->fetch_all(MYSQLI_ASSOC);

    // INSIGHTS
    $peak = null;
    $low = null;

    if (!empty($data)) {
        $peak = $data[0];
        $low = $data[0];

        foreach ($data as $d) {
            if ($d['total'] > $peak['total']) $peak = $d;
            if ($d['total'] < $low['total']) $low = $d;
        }
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

<!-- FILTER -->
<div style="margin-bottom:15px;">
    <input type="date" id="start" class="filterInput">
    <input type="date" id="end" class="filterInput">
    <button onclick="loadData()" class="applyBtn">Apply</button>
</div>

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

// ================= LOAD TURFS =================
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

// ================= SELECT TURF =================
function selectTurf(id, el){

    selectedTurf = id;

    document.querySelectorAll('.turfCard').forEach(c=>{
        c.classList.remove('active');
    });

    el.classList.add('active');

    loadData();
}

// ================= LOAD DATA =================
async function loadData(){

    let start = document.getElementById('start').value;
    let end = document.getElementById('end').value;

    let res = await fetch(
        `earning_report.php?ajax=1&start_date=${start}&end_date=${end}&turf_id=${selectedTurf}`
    );

    let result = await res.json();
    let data = result.data;

    if(!data || data.length === 0){
        document.getElementById('tbody').innerHTML = `<tr><td colspan="2">No Data</td></tr>`;
        document.getElementById('peak').innerHTML = "";
        document.getElementById('low').innerHTML = "";
        if(chart) chart.destroy();
        return;
    }

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
                label: 'Earnings',
                data: values
            }]
        },
        options: {
            responsive: true,
            maintainAspectRatio: false,
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