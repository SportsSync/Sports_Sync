<?php
session_start();
$conn = new mysqli("localhost:3306", "root", "", "turf_booking_system");

if ($conn->connect_error) {
    die("DB Error");
}

/* ================= GET COURTS ================= */
if (isset($_GET['get_courts'])) {

    $turf_id = (int)$_GET['turf_id'];

    $res = $conn->query("
        SELECT court_id, court_name 
        FROM turf_courtstb 
        WHERE turf_id = $turf_id
    ");

    $data = [];
    while ($row = $res->fetch_assoc()) {
        $data[] = $row;
    }

    echo json_encode($data);
    exit;
}

/* ================= APPLY MAINTENANCE ================= */
if (isset($_POST['apply'])) {

    $turf_id   = (int)$_POST['turf_id'];
    $courts    = $_POST['courts'] ?? [];
    $from_date = $_POST['from_date'];
    $to_date   = $_POST['to_date'];
    $from_time = $_POST['from_time'];
    $to_time   = $_POST['to_time'];

    if (!$turf_id || empty($courts) || !$from_date || !$to_date || !$from_time || !$to_time) {
        echo "<script>alert('All fields required');</script>";
    } else {

        foreach ($courts as $court_id) {

            $court_id = (int)$court_id;

            $sql = "INSERT INTO maintenance_tb
                    (turf_id, court_id, from_date, to_date, from_time, to_time)
                    VALUES ($turf_id, $court_id, '$from_date', '$to_date', '$from_time', '$to_time')";

            if (!$conn->query($sql)) {
                die("SQL Error: " . $conn->error); // 🔥 shows real problem if any
            }
        }

        echo "<script>alert('✅ Maintenance Applied'); window.location.href='';</script>";
    }
}

?>

<!DOCTYPE html>
<html>
<head>
<title>Maintenance</title>

<style>
body {
    background: radial-gradient(circle at top, #0f1b3d, #050914);
    color: white;
    font-family: 'Segoe UI';
}

/* TURF GRID */
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

/* FORM */
.formBox {
  max-width: 420px;
  margin: 40px auto;
  display: flex;
  flex-direction: column;
  gap: 12px;
}

.input {
  padding: 12px;
  border-radius: 12px;
  background: rgba(255,255,255,0.06);
  color: white;
  border: 1px solid rgba(255,255,255,0.1);
}

/* COURTS */
/* ================= COURTS GRID ================= */
.courts-grid {
  display: grid;
  grid-template-columns: repeat(auto-fit, minmax(140px, 160px));
  justify-content: center; /* ✅ centers all cards */
  gap: 18px;
}

/* ================= COURT CARD ================= */
.court-card {
  position: relative;
  padding: 20px 14px;
  border-radius: 18px;

  background: rgba(15, 23, 42, 0.75);
  backdrop-filter: blur(12px);
  -webkit-backdrop-filter: blur(12px);

  border: 1px solid rgba(255, 255, 255, 0.08);

  text-align: center;
  cursor: pointer;

  transition: all 0.25s ease;
}

/* HOVER */
.court-card:hover {
  transform: translateY(-4px) scale(1.02);
  border-color: #9526F3;
  box-shadow: 0 10px 30px rgba(149, 38, 243, 0.25);
}

/* ================= COURT TEXT ================= */
.court-name {
  font-size: 18px;
  font-weight: 700;
  color: #ffffff;
  letter-spacing: 0.5px;
}

.court-sub {
  font-size: 12px;
  color: #94a3b8;
  margin-top: 6px;
}

/* ================= SELECTED STATE ================= */
.court-card.selected {
  background: linear-gradient(
    135deg,
    #9526F3,
    #c084fc
  );
  border: 1px solid #9526F3;

  transform: translateY(-3px) scale(1.03);

  box-shadow:
    0 12px 35px rgba(149, 38, 243, 0.5),
    inset 0 0 10px rgba(255, 255, 255, 0.2);
}

/* TEXT CHANGE ON SELECT */
.court-card.selected .court-name {
  color: #050914;
}

.court-card.selected .court-sub {
  color: #050914;
}



/* ================= EMPTY STATE ================= */
.no-courts {
  text-align: center;
  color: #94a3b8;
  padding: 20px;
  font-size: 14px;
}

/* BUTTON */
.btn {
  padding: 14px;
  border-radius: 14px;
  background: linear-gradient(135deg,#9526F3,#9526f359);
  border: none;
  font-weight: bold;
  cursor: pointer;
}

/* POPUP */
.popup-overlay {
  position: fixed;
  inset: 0;
  background: rgba(0,0,0,0.75);
  display: none;
  justify-content: center;
  align-items: center;
}

.popup-box {
  background: rgba(15,23,42,0.9);
  padding: 30px;
  border-radius: 20px;
  text-align: center;
}

.popup-btn {
  margin: 10px;
  padding: 10px 20px;
  border-radius: 10px;
  border: none;
  cursor: pointer;
}

.confirm { background: #9526F3; }
.cancel { background: #334155; color:white; }


.formRow {
  display: flex;
  align-items: center;
  justify-content: space-between;
  gap: 12px;
}

.formRow label {
  width: 110px;
  font-size: 13px;
  color: #94a3b8;
}

.formRow .input {
  flex: 1;
}
</style>
</head>

<body>
<form id="maintenanceForm" method="POST">

  <input type="hidden" name="apply" value="1">
  <input type="hidden" name="turf_id" id="form_turf">

  <input type="hidden" name="from_date" id="form_fd">
  <input type="hidden" name="to_date" id="form_td">
  <input type="hidden" name="from_time" id="form_ft">
  <input type="hidden" name="to_time" id="form_tt">

  <div id="courtInputs"></div>

</form>
<h2 style="text-align:center;">Maintenance Block</h2>

<div id="turfCards" class="turfContainer"></div><br>
<br>
<div class="box">
    <div id="courts" class="courts-grid"></div>
  </div>

<div class="formBox">

<input type="hidden" id="turf_id">


<div class="formRow">
  <label>From Date : </label>
  <input type="date" id="from_date" class="input">
</div>

<div class="formRow">
  <label>To Date : </label>
  <input type="date" id="to_date" class="input">
</div>

<div class="formRow">
  <label>From Time : </label>
  <input type="time" id="from_time" class="input">
</div>

<div class="formRow">
  <label>To Time : </label>
  <input type="time" id="to_time" class="input">
</div>


<button onclick="submitForm()" class="btn">Apply Maintenance</button>

</div>

<!-- POPUP -->
<div id="popup" class="popup-overlay">
  <div class="popup-box">
    <h3>Are you sure?</h3>
    <p>This will block selected slots.</p>
    <button class="popup-btn confirm" onclick="confirmSubmit()">Yes</button>
    <button class="popup-btn cancel" onclick="closePopup()">Cancel</button>
  </div>
</div>

<script>

let selectedTurf = null;
let selectedCourts = [];

/* LOAD TURFS */
async function loadTurfs(){

    let res = await fetch('../api/get_vendor_turfs.php');
    let data = await res.json();

    let html = "";

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
    selectedCourts = []; // reset

    document.querySelectorAll('.turfCard').forEach(c=>{
        c.classList.remove('active');
    });

    el.classList.add('active');

    loadCourts(id); // ✅ THIS WAS MISSING
}

/* LOAD COURTS */

    async function loadCourts(turf_id){

    let res = await fetch(`?get_courts=1&turf_id=${turf_id}`);
    let data = await res.json();

    let container = document.getElementById("courts");
    container.innerHTML = "";

    if(data.length === 0){
        container.innerHTML = "<p style='color:#aaa;'>No courts found</p>";
        return;
    }

    data.forEach(c => {

        let div = document.createElement("div");
        div.className = "court-card";

        div.innerHTML = `
            <div class="court-name">${c.court_name}</div>
            <div class="court-sub">Tap to select</div>
        `;

        div.onclick = () => toggleCourt(c.court_id, div);

        container.appendChild(div);
    });
}

/* TOGGLE COURT */
function toggleCourt(id, el){

    if(selectedCourts.includes(id)){
        selectedCourts = selectedCourts.filter(x=>x!==id);
        el.classList.remove("selected");
    } else {
        selectedCourts.push(id);
        el.classList.add("selected");
    }
}

/* VALIDATION + POPUP */
function submitForm(){

    let turf = selectedTurf;
    let fd = document.getElementById('from_date').value;
    let td = document.getElementById('to_date').value;
    let ft = document.getElementById('from_time').value;
    let tt = document.getElementById('to_time').value;

    if(!turf) return alert("Select turf");
    if(!fd || !td) return alert("Select date");
    if(!ft || !tt) return alert("Select time");
    if(selectedCourts.length === 0) return alert("Select courts");

    document.getElementById("popup").style.display = "flex";
}

/* CONFIRM */
function confirmSubmit(){

    closePopup();

    // fill hidden inputs
    document.getElementById('form_turf').value = selectedTurf;
    document.getElementById('form_fd').value = document.getElementById('from_date').value;
    document.getElementById('form_td').value = document.getElementById('to_date').value;
    document.getElementById('form_ft').value = document.getElementById('from_time').value;
    document.getElementById('form_tt').value = document.getElementById('to_time').value;

    // add courts
    let container = document.getElementById("courtInputs");
    container.innerHTML = "";

    selectedCourts.forEach(c=>{
        let input = document.createElement("input");
        input.type = "hidden";
        input.name = "courts[]";
        input.value = c;
        container.appendChild(input);
    });

    // submit form
    document.getElementById("maintenanceForm").submit();
}

function closePopup(){
    document.getElementById("popup").style.display = "none";

}

loadTurfs();

</script>

</body>
</html>