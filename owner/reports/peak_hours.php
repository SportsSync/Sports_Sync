<?php session_start(); ?>

<!DOCTYPE html>
<html>
<head>
    <title>Peak Hours</title>

    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>

    <style>
        .turfCard {
    width: 130px;
    padding: 8px;
    border-radius: 10px;
    background: #0f172a;
    cursor: pointer;
    text-align: center;
    border: 1px solid transparent;
    transition: 0.2s;
}

.turfCard img {
    width: 100%;
    height: 70px;
    object-fit: cover;
    border-radius: 6px;
}

.turfCard p {
    margin-top: 5px;
    font-size: 13px;
}

.turfCard:hover {
    transform: scale(1.05);
}

.turfCard.active {
    border: 2px solid #3b82f6;
}
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
        /* ===== FILTER INPUT ===== */
.filterInput {
    padding: 10px 14px;
    border-radius: 10px;
    background: #1e293b;
    color: white;
    border: 1px solid #334155;
    font-size: 14px;
}

/* ===== APPLY BUTTON ===== */
.applyBtn {
    padding: 10px 18px;
    border-radius: 10px;
    background: #2563eb;
    color: white;
    font-weight: 500;
    transition: 0.2s;
}

.applyBtn:hover {
    background: #1d4ed8;
}

/* ===== TURF CONTAINER (CENTERED) ===== */
.turfContainer {
    display: flex;
    justify-content: center;   /* 🔥 CENTER ALIGN */
    gap: 15px;
    flex-wrap: wrap;
}

/* ===== TURF CARD ===== */
.turfCard {
    width: 140px;
    padding: 10px;
    border-radius: 12px;
    background: #0f172a;
    text-align: center;
    cursor: pointer;
    transition: 0.25s;
    border: 1px solid transparent;
}

.turfCard img {
    width: 100%;
    height: 80px;
    object-fit: cover;
    border-radius: 8px;
}

.turfCard p {
    margin-top: 8px;
    font-size: 14px;
    font-weight: 500;
}

/* HOVER */
.turfCard:hover {
    transform: translateY(-4px);
    background: #1e293b;
}

/* ACTIVE */
.turfCard.active {
    border: 2px solid #3b82f6;
    background: #1e293b;
}
    </style>
</head>

<body>

<div style="max-width:1100px; margin:auto; padding:20px;">

<h2 style="margin-bottom:5px;">Peak Hour Report</h2>

<!-- Filters -->
<div style="display:flex; flex-direction:column; gap:15px; margin-bottom:20px;">

    <!-- ROW 1: DATE + APPLY -->
    <div style="display:flex; align-items:center; gap:12px;">
        <input type="date" id="start" class="filterInput">
        <input type="date" id="end" class="filterInput">

        <button onclick="loadData()" class="applyBtn">
            Apply
        </button>
    </div>

    <!-- ROW 2: TURF CARDS -->
    <div id="turfCards" class="turfContainer"></div>

</div>

<!-- Insights -->
<div style="display:flex; justify-content:center; gap:30px; margin-bottom:15px;">
    <div id="peak" style="color:#22c55e; font-weight:500;"></div>
    <div id="low" style="color:#ef4444; font-weight:500;"></div>
</div>

<!-- Chart -->
<div style="height:350px;">
    <canvas id="chart"></canvas>
</div>
<div id="chartMsg" style="text-align:center; color:#94a3b8; margin-top:10px;"></div>
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

</div>

<script>
let chart;

// LOAD TURFS
let selectedTurf = "all";

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


function selectTurf(id, element){

    selectedTurf = id;

    document.querySelectorAll('.turfCard').forEach(c=>{
        c.classList.remove('active');
    });

    element.classList.add('active');

    loadData(); // auto reload
}

// LOAD DATA
async function loadData(){

    let start = document.getElementById('start').value;
    let end = document.getElementById('end').value;
    let turf = selectedTurf;
    
    let res = await fetch(
    `../api/get_peak_hours.php?start_date=${start}&end_date=${end}&turf_id=${turf}`
    );
    let result = await res.json();

    let data = result.data;

    // EMPTY
    if(!data || data.length === 0){

    document.getElementById('tbody').innerHTML =
        `<tr><td colspan="2">No Data</td></tr>`;

    document.getElementById('peak').innerHTML = "";
    document.getElementById('low').innerHTML = "";

    document.getElementById('chartMsg').innerHTML = "No data to display";

    if(chart){
        chart.destroy();
        chart = null;
    }

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
    },
    options: {
        responsive: true,
        maintainAspectRatio: false,
        plugins: {
            legend: {
                labels: {
                    color: "#94a3b8"
                }
            }
        },
        scales: {
            x: {
                ticks: { color: "#94a3b8" }
            },
            y: {
                ticks: { color: "#94a3b8" }
            }
        }
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
window.onload = () => {
    loadTurfs();
    loadData();
};
</script>

</body>
</html>