<?php session_start(); ?>

<!DOCTYPE html>
<html>
<head>
    <title>Peak Hours</title>

    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>

    <style>
        body {
            background: #0b1120;
            color: white;
            font-family: sans-serif;
        }

        input, select, button {
            padding: 8px;
            margin: 5px;
            border-radius: 6px;
            border: none;
        }

        button {
            background: #2563eb;
            color: white;
            cursor: pointer;
        }

        table {
            width: 100%;
            margin-top: 20px;
            border-collapse: collapse;
        }

        th, td {
            padding: 10px;
            border-bottom: 1px solid #1e293b;
        }

        canvas {
            margin-top: 20px;
        }

        .insight {
            margin-top: 15px;
            font-size: 16px;
        }
    </style>
</head>

<body>

<h2>Peak Hour Report</h2>

<!-- Filters -->
<input type="date" id="start">
<input type="date" id="end">

<select id="turf"></select>

<button onclick="loadData()">Apply</button>

<!-- Insights -->
<div class="insight" id="peak"></div>
<div class="insight" id="low"></div>

<!-- Chart -->
<canvas id="chart"></canvas>

<!-- Table -->
<table>
<thead>
<tr>
    <th>Time Slot</th>
    <th>Bookings</th>
</tr>
</thead>
<tbody id="tbody"></tbody>
</table>

<script>
let chart;

// LOAD TURFS
async function loadTurfs(){
    let res = await fetch('../api/get_vendor_turfs.php');
    let data = await res.json();

    let html = '<option value="">All Turfs</option>';
    data.forEach(t=>{
        html += `<option value="${t.turf_id}">${t.turf_name}</option>`;
    });

    document.getElementById('turf').innerHTML = html;
}

window.onload = loadTurfs;

// LOAD DATA
async function loadData(){

    let start = document.getElementById('start').value;
    let end = document.getElementById('end').value;
    let turf = document.getElementById('turf').value;

    let res = await fetch(`../api/get_peak_hours.php?start_date=${start}&end_date=${end}&turf_id=${turf}`);
    let result = await res.json();

    let data = result.data;

    // EMPTY
    if(data.length === 0){
        document.getElementById('tbody').innerHTML =
            `<tr><td colspan="2">No Data</td></tr>`;
        return;
    }

    // TABLE
    let html = "";
    data.forEach(d=>{
        html += `<tr>
            <td>${d.start_time} - ${d.end_time}</td>
            <td>${d.total_bookings}</td>
        </tr>`;
    });
    document.getElementById('tbody').innerHTML = html;

    // CHART
    let labels = data.map(d => d.start_time + " - " + d.end_time);
    let values = data.map(d => d.total_bookings);

    if(chart) chart.destroy();

    let ctx = document.getElementById('chart');

    chart = new Chart(ctx, {
        type: 'bar',
        data: {
            labels: labels,
            datasets: [{
                label: 'Bookings',
                data: values
            }]
        }
    });

    // INSIGHTS
    let peak = result.insights.peak_hour;
    let low = result.insights.low_hour;

    document.getElementById('peak').innerHTML =
        `🔥 Peak: ${peak.start_time}-${peak.end_time} (${peak.total_bookings})`;

    document.getElementById('low').innerHTML =
        `📉 Low: ${low.start_time}-${low.end_time} (${low.total_bookings})`;
}
</script>

</body>
</html>