<?php
session_start();
require '../db.php';

if (!isset($_GET['turf_id'])) {
  die("Invalid turf");
}
$turf_id = (int) $_GET['turf_id'];
?>
<!DOCTYPE html>
<html>

<head>
  <title>Turf Booking</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">

  <style>
    body {
  background-color: #0e0f11;
  background-image:
    linear-gradient(45deg, #1f1f1f 25%, transparent 25%),
    linear-gradient(-45deg, #1f1f1f 25%, transparent 25%),
    linear-gradient(45deg, transparent 75%, #1f1f1f 75%),
    linear-gradient(-45deg, transparent 75%, #1f1f1f 75%);
  background-size: 6px 6px;
  background-position: 0 0, 0 3px, 3px -3px, -3px 0px;
  color: #ffffff;
  padding-bottom: 80px;
  font-family: Arial, sans-serif;
}

/* ================= BOX ================= */
.box {
  background: #000;
  padding: 20px;
  border-radius: 12px;
  margin-bottom: 20px;
}

/* ================= ITEM ================= */
.item {
  padding: 10px 15px;
  border: 1px solid #2a2a2a;
  border-radius: 8px;
  cursor: pointer;
}

.item.selected {
  background: #caff33;
  color: #000;
}

/* ================= SLOT GRID ================= */
.slots-grid {
  display: grid;
  grid-template-columns: repeat(auto-fill, minmax(140px, 1fr));
  gap: 14px;
}

/* SLOT CARD */
.slot-card {
  background: #000;
  border: 1.5px solid #2a2a2a;
  border-radius: 10px;
  padding: 10px 8px;
  cursor: pointer;
  transition: all 0.18s ease;
  text-align: center;
}

.slot-card:hover {
  border-color: #caff33;
  transform: translateY(-2px);
}

/* SELECTED */
.slot-card.selected {
  background: linear-gradient(180deg, #caff33, #b5f000);
  border-color: #caff33;
  color: #000;
}

/* TIME */
.slot-time {
  font-size: 14px;
  font-weight: 600;
  letter-spacing: 0.3px;
}

/* PRICE */
.slot-price {
  font-size: 12px;
  color: #8b8b8b;
  margin-top: 4px;
  transition: color 0.15s ease, font-weight 0.15s ease;
}

.slot-card:hover .slot-price {
  color: #caff33;
  font-weight: 600;
}

.slot-card.selected .slot-price {
  color: #000;
  font-weight: 700;
}

/* DISABLED */
.slot-card.disabled {
  opacity: 0.4;
  cursor: not-allowed;
  pointer-events: none;
}

/* ================= SPORTS GRID ================= */
.sports-grid {
  display: grid;
  grid-template-columns: repeat(auto-fill, minmax(110px, 1fr));
  gap: 14px;
}

.sport-card {
  background: #000;
  border: 1px solid #2a2a2a;
  border-radius: 12px;
  padding: 12px 8px;
  text-align: center;
  cursor: pointer;
  transition: all 0.2s ease;
}

.sport-card:hover {
  transform: translateY(-2px);
  border-color: #caff33;
}

.sport-card.selected {
  background: linear-gradient(180deg, #caff33, #b5f000);
  border-color: #caff33;
  color: #000;
}

.sport-icon {
  width: 36px;
  height: 36px;
  margin: 0 auto 6px;
  font-size: 26px;
  color: #caff33;
}

.sport-card.selected .sport-icon {
  color: #000;
}

.sport-name {
  font-weight: 600;
  font-size: 14px;
}

/* ================= DATE STRIP ================= */
.date-strip {
  display: flex;
  gap: 12px;
  overflow-x: auto;
  padding: 10px 0;
}

.date-strip::-webkit-scrollbar {
  height: 6px;
}

.date-strip::-webkit-scrollbar-thumb {
  background: #2a2a2a;
  border-radius: 10px;
}

.date-card {
  min-width: 70px;
  text-align: center;
  padding: 10px 6px;
  border-radius: 10px;
  border: 1px solid #2a2a2a;
  cursor: pointer;
  background: #000;
  color: #aaa;
  transition: 0.2s;
}

.date-card.active {
  background: #caff33;
  color: #000;
  border-color: #caff33;
  font-weight: 700;
}

/* ================= COURTS ================= */
.courts-grid {
  display: grid;
  grid-template-columns: repeat(auto-fill, minmax(120px, 1fr));
  gap: 16px;
}

.court-card {
  background: #000;
  border: 1px solid #2a2a2a;
  border-radius: 14px;
  padding: 18px 10px;
  text-align: center;
  cursor: pointer;
  transition: all 0.2s ease;
}

.court-card:hover {
  transform: translateY(-3px);
  border-color: #caff33;
}

.court-card.selected {
  background: linear-gradient(180deg, #caff33, #b5f000);
  border-color: #caff33;
  color: #000;
}

.court-name {
  font-size: 18px;
  font-weight: 700;
}

.court-sub {
  font-size: 12px;
  color: #aaa;
  margin-top: 4px;
}

.court-card.selected .court-sub {
  color: #fff;
}

/* ================= TOP BAR ================= */
.top-bar {
  position: sticky;
  top: 0;
  z-index: 20;
  background: #0e0f11;
  padding: 14px 0 6px;
}

.back-btn {
  background: transparent;
  border: 1.5px solid #caff33;
  color: #caff33;
  padding: 6px 16px;
  border-radius: 999px;
  font-weight: 600;
  transition: all 0.18s ease;
}

.back-btn:hover {
  background: rgba(202, 255, 51, 0.15);
}

.back-btn:active {
  transform: scale(0.96);
}

/* ================= BOOK BAR ================= */
.book-bar {
  position: sticky;
  bottom: 0;
  z-index: 20;
  background: #0e0f11;
  border-top: 1px solid #2a2a2a;
  padding: 12px 0;
  display: flex;
  justify-content: space-between;
  align-items: center;
}

.book-total {
  font-size: 16px;
  font-weight: 600;
  color: #e0e0e0;
}

/* CTA */
.book-btn {
  background: linear-gradient(135deg, #caff33, #b5f000);
  border: none;
  color: #000;
  padding: 10px 26px;
  font-size: 15px;
  font-weight: 800;
  border-radius: 8px;
  cursor: pointer;
  transition: transform 0.15s ease, box-shadow 0.15s ease;
}

.book-btn:hover:not(:disabled) {
  transform: scale(1.05);
  box-shadow: 0 10px 25px rgba(202, 255, 51, 0.35);
}

.book-btn:active:not(:disabled) {
  transform: scale(0.96);
  box-shadow: 0 6px 14px rgba(202, 255, 51, 0.25);
}

.book-btn:disabled {
  background: #2a2a2a;
  color: #777;
  cursor: not-allowed;
  box-shadow: none;
}

/* SUMMARY */
#sumTime div {
  padding: 4px 0;
  font-weight: 500;
}

  </style>
</head>

<body class="container py-4">
  <!-- TOP BAR -->
  <div class="top-bar">
    <button class="back-btn" onclick="goBack()">← Back</button>
  </div>

  <h2 id="turfName"></h2>
  <p id="turfLoc"></p>

  <!-- DATE STRIP -->
  <div class="box">
    <label>Select Date</label>
    <div id="dateStrip" class="date-strip"></div>
  </div>

  <div class="box">
    <label>Select Sport</label>
    <div id="sports" class="sports-grid"></div>
  </div>

  <div class="box">
    <label>Select Court</label>
    <div id="courts" class="courts-grid"></div>
  </div>

  <div class="box">
    <label>Select Slots</label>
    <div id="slots" class="slots-grid"></div>
  </div>

  <h4>Total: ₹<span id="total">0</span></h4>

  <!-- BOOK BUTTON BAR -->
  <div class="book-bar">
    <div class="book-total">
      Total: ₹<span id="stickyTotal">0</span>
    </div>

    <button class="book-btn" id="confirmBtn" disabled>
      Book Now
    </button>
  </div>

  <script>
    let selectedSlots = [];

    const userSession = {
      name: "<?= $_SESSION['name'] ?? '' ?>",
      email: "<?= $_SESSION['email'] ?? '' ?>",
      mobile: "<?= $_SESSION['mobile'] ?? '' ?>"
    };

    const turf_id = <?= $turf_id ?>;
    let selectedDate = "";
    let sport_id = "";
    let court_id = "";
    let total = 0;

    const dateStrip = document.getElementById("dateStrip");

    /* ---------- DATE STRIP GENERATION (21 DAYS) ---------- */
    function generateDates(days = 21) {
      const today = new Date();

      for (let i = 0; i < days; i++) {
        const d = new Date();
        d.setDate(today.getDate() + i);

        const yyyy = d.getFullYear();
        const mm = String(d.getMonth() + 1).padStart(2, "0");
        const dd = String(d.getDate()).padStart(2, "0");
        const apiDate = `${yyyy}-${mm}-${dd}`;

        const card = document.createElement("div");
        card.className = "date-card";
        card.innerHTML = `
      <div class="day">${d.toLocaleDateString("en-US", { weekday: "short" })}</div>
      <div class="date">${dd}</div>
      <div class="month">${d.toLocaleDateString("en-US", { month: "short" })}</div>
    `;

        card.onclick = () => {
          document.querySelectorAll(".date-card").forEach(c => c.classList.remove("active"));
          card.classList.add("active");

          selectedDate = apiDate;

          // reset slots & total
          slots.innerHTML = "";
          total = 0;
          updateTotal();

          // reload logic (SAME AS YOUR CURRENT CODE)
          if (sport_id && court_id) {
            loadSlots();
          } else {
            loadSports();
          }
        };

        // auto select today
        if (i === 0) {
          card.classList.add("active");
          selectedDate = apiDate;
        }

        dateStrip.appendChild(card);
      }
    }

    /* ---------- INITIAL LOAD ---------- */
    generateDates(21);
    loadSports();

    let turfNameText = "";

    fetch(`apiBooking/get_turf.php?turf_id=${turf_id}`)
      .then(r => r.json())
      .then(d => {
        if (d.status !== "success") {
          alert("Failed to load turf details");
          return;
        }
        turfName.innerText = d.turf_name;
        turfLoc.innerText = d.location;
        turfNameText = d.turf_name; // 🔥 critical
      });


    /* ---------- EXISTING LOGIC (UNCHANGED) ---------- */
    function loadSports() {
      fetch(`apiBooking/get_sports.php?turf_id=${turf_id}`)
        .then(r => r.json())
        .then(data => {
          sports.innerHTML = "";
          courts.innerHTML = "";
          slots.innerHTML = "";

          data.forEach(s => {
            let div = document.createElement("div");
            div.className = "sport-card";

            // simple icon mapping (can replace with images later)
            let icon = "🏏";
            if (s.sport_name.toLowerCase().includes("football")) icon = "⚽";
            if (s.sport_name.toLowerCase().includes("badminton")) icon = "🏸";
            if (s.sport_name.toLowerCase().includes("tennis")) icon = "🎾";

            div.innerHTML = `
        <div class="sport-icon">${icon}</div>
        <div class="sport-name">${s.sport_name}</div>
      `;

            div.onclick = () => {
              document.querySelectorAll(".sport-card").forEach(i => i.classList.remove("selected"));
              div.classList.add("selected");
              sport_id = s.sport_id;
              loadCourts();
            };

            sports.appendChild(div);
          });
        });
    }

    function loadCourts() {
      fetch(`apiBooking/get_courts.php?turf_id=${turf_id}&sport_id=${sport_id}`)
        .then(r => r.json())
        .then(data => {
          courts.innerHTML = "";
          slots.innerHTML = "";
          data.forEach(c => {
            let div = document.createElement("div");
            div.className = "court-card";
            div.innerHTML = `
        <div class="court-name">${c.court_name}</div>
        <div class="court-sub">Available</div>
      `;
            div.onclick = () => {
              document.querySelectorAll(".court-card").forEach(i => i.classList.remove("selected"));
              div.classList.add("selected");
              court_id = c.court_id;
              loadSlots();
            };
            courts.appendChild(div);
          });
        });
    }


    function loadSlots() {
      fetch(`apiBooking/get_slots.php?turf_id=${turf_id}&sport_id=${sport_id}&court_id=${court_id}&date=${selectedDate}`)
        .then(r => r.json())
        .then(data => {
          slots.innerHTML = "";
          total = 0;
          updateTotal();

          data.forEach(s => {
            let div = document.createElement("div");
            div.className = "slot-card";

            div.innerHTML = `
        <div class="slot-time">
          ${s.start_time.slice(0, 5)} - ${s.end_time.slice(0, 5)}
        </div>
        <div class="slot-price">
          ₹${s.price_per_hour}
        </div>
      `;
            div.dataset.slotId = s.slot_id;
            //disabled already booked
            if (s.is_booked == 1) {
              div.classList.add("disabled");
              div.style.opacity = "0.35";
              div.style.pointerEvents = "none";

              slots.appendChild(div);
              return;
            }

            div.onclick = () => {
              div.classList.toggle("selected");

              if (div.classList.contains("selected")) {
                selectedSlots.push({
                  slot_id: s.slot_id,
                  start: s.start_time.slice(0, 5),
                  end: s.end_time.slice(0, 5)
                });

                total += parseInt(s.price_per_hour);
              } else {
                selectedSlots = selectedSlots.filter(
                  t => t.slot_id !== s.slot_id
                );

                total -= parseInt(s.price_per_hour);
              }

              updateTotal();
            };
            slots.appendChild(div);
          });
        });
    }

    function goBack() {
      window.history.back();
    }

    function updateTotal() {
      document.getElementById("total").innerText = total;
      document.getElementById("stickyTotal").innerText = total;
      document.getElementById("confirmBtn").disabled = total <= 0;
    }
    document.getElementById("confirmBtn").onclick = openSummary;

    function openSummary() {
      if (!userSession.email) {
        alert("Please login to continue booking");
        window.location.href = "../signin.php";
        return;
      }

      if (selectedSlots.length === 0) return;

      // sort by start time
      selectedSlots.sort((a, b) => a.start.localeCompare(b.start));

      document.getElementById("sumTurf").innerText =
        document.getElementById("turfName").innerText;

      document.getElementById("sumUser").innerText = userSession.name;
      document.getElementById("sumEmail").innerText = userSession.email;
      document.getElementById("sumMobile").innerText = userSession.mobile;

      document.getElementById("sumDate").innerText = selectedDate;

      // 🔥 hour-wise display
      document.getElementById("sumTime").innerHTML =
        selectedSlots
          .map(t => `<div>${t.start} - ${t.end}</div>`)
          .join("");

      document.getElementById("sumTotal").innerText = total;

      document.getElementById("summaryOverlay").style.display = "flex";
    }


    function closeSummary() {
      document.getElementById("summaryOverlay").style.display = "none";
    }

    function confirmBooking() {
  fetch("apiBooking/confirm_booking.php", {
    method: "POST",
    headers: { "Content-Type": "application/json" },
    body: JSON.stringify({
      turf_id: turf_id,
      court_id: court_id,
      sport_id: sport_id,
      booking_date: selectedDate,
      total: total,
      slots: selectedSlots.map(s => s.slot_id)
    })
  })
  .then(r => r.json())
  .then(res => {
    if (res.status === "success") {

      // 1️⃣ Show confirmation
      alert("✅ Booking Confirmed!");

      // 2️⃣ Open PDF in new tab
      if (res.pdf_url) {
        window.open(res.pdf_url, "_blank");
      }

      // 3️⃣ Close summary overlay
      closeSummary();

      // 4️⃣ Optional: reload after small delay
      setTimeout(() => {
        location.reload();
      }, 1000);

    } else {
      alert(res.msg || "Booking failed");
    }
  })
  .catch(err => {
    console.error(err);
    alert("Something went wrong. Please try again.");
  });
}



  </script>

  <!-- BOOKING SUMMARY MODAL -->
  <div id="summaryOverlay" style="display:none;
  position:fixed; inset:0; background:rgba(0,0,0,.75);
  z-index:9999; align-items:center; justify-content:center;">

    <div style="background:#111;
    border:1px solid #333;
    border-radius:14px;
    width:420px;
    padding:24px;
    color:#fff;">

      <h5 style="color:#caff33;margin-bottom:16px;">Booking Summary</h5>

      <div class="mb-2"><strong>Turf:</strong> <span id="sumTurf"></span></div>

      <hr style="border-color:#333">

      <div class="mb-2"><strong>Name:</strong> <span id="sumUser"></span></div>
      <div class="mb-2"><strong>Email:</strong> <span id="sumEmail"></span></div>
      <div class="mb-2"><strong>Mobile:</strong> <span id="sumMobile"></span></div>

      <hr style="border-color:#333">

      <div class="mb-2"><strong>Date:</strong> <span id="sumDate"></span></div>
      <div class="mb-2"><strong>Time:</strong> <span id="sumTime"></span></div>

      <hr style="border-color:#333">

      <h5>Total: ₹<span id="sumTotal"></span></h5>

      <div class="d-flex justify-content-end gap-2 mt-4">
        <button onclick="closeSummary()" class="btn btn-secondary">Cancel</button>
        <button onclick="confirmBooking()" class="btn btn-success">Confirm Booking</button>
      </div>

    </div>
  </div>
</body>

</html>

<!-- <!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <title>Turf Booking</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.5/font/bootstrap-icons.css">
  
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/flatpickr/dist/flatpickr.min.css">
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/flatpickr/dist/themes/dark.css">

  <style>
    body {
      background-image: url('https://images.unsplash.com/photo-1617696618050-b0fef0c666af?q=80&w=870&auto=format&fit=crop&ixlib=rb-4.1.0&ixid=M3wxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHx8fA%3D%3D');
      background-size: cover;
      background-position: center;
      background-color: #2b2a2a00;
      background-attachment: fixed;
      background-repeat: no-repeat;
      color: #F1F1F1;
      font-family: 'Segoe UI', sans-serif;
    }

    h1 {
      text-align: center;
      color: #4ccff0;
      margin-top: 40px;
      font-weight: 600;
      font-size: 2.5rem;
    }

    form {
      background-color: #000000b9;
      padding: 40px;
      border-radius: 16px;
      max-width: 60%;
      min-height: 90vh;
      margin: 60px auto;
      box-shadow: 0 0 0px rgba(14, 14, 14, 0.9);
    }

    label {
      color: #F1F1F1;
      font-weight: 500;
      margin-bottom: 5px;
      font-size: 30px;
      font-family: 'Rajdhani', sans-serif;
    }

    .form-control,
    .form-select {
      background-color: #2C2C3E;
      border: none;
      color: #F1F1F1;
    }

    .form-control::placeholder,
    .form-select option {
      color: #A0A0B0;
    }

    .form-control:focus,
    .form-select:focus {
      background-color: #2C2C3E;
      color: white;
      box-shadow: 0 0 0 0.2rem rgba(76, 201, 240, 0.25);
    }

    .input-group-text {
      background-color: #2C2C3E;
      color: #4CC9F0;
      border: none;
    }

    button {
      background-color: #D1FF71;
      border: none;
      color: #000000ec;
      padding: 10px 24px;
      width: 50%;
      border-radius: 8px;
      text-align: center;
      font-weight: 600;
      font-size: 1.25rem;
      display: block;
      margin: 30px auto 0 auto;
      transition: background-color 0.3s ease;
      cursor: pointer;
    }

    button:hover {
      background-color: #ceff65;
      color: #000000;
      transform: scale(1.05);
    }

    .slots {
      display: flex;
      gap: 12px;
      margin-top: 20px;
    }

    .slot {
      flex-shrink: 0;
      display: flex;
      flex-direction: column;
      justify-content: center;
      align-items: center;
      padding: 12px 20px;
      border: 2px solid #BDBDBD;
      border-radius: 10px;
      cursor: pointer;
      font-weight: bold;
      color: whitesmoke;
      transition: all 0.1s ease-in-out;
    }

    .slot:hover {
      background-color: #68d3f3;
      color: white;
      transform: translatey(-6px);
      background-color: #2C2C3E;
    }


    .slot.selected {
      background-color: #caff33;
      color: white;
    }



    /* popup */
    /* The popup (hidden by default) */
    .popmenu {
      display: none;
      /* Hidden by default */
      position: fixed;
      /* Stay in place */
      z-index: 1000;
      /* Sit on top */
      backdrop-filter: blur(10px);
      left: 0;
      top: 0;
      width: 100%;
      /* Full width */
      height: 100%;
      /* Full height */
      background-color: rgba(0, 0, 0, 0.4);
      /* Black w/ opacity */
    }

   .popup-content {
      background: #1f1f2e; /* Modern dark background */
      color: #f1f1f1;
      border-radius: 12px;
      padding: 25px 20px;
      width: 360px;
      margin: 8% auto;
      box-shadow: 0 8px 20px rgba(0, 0, 0, 0.7);
      font-family: 'Poppins', sans-serif;
      position: relative;
      border: 1px solid #444;
      overflow: hidden;
    }

    /* Top Accent Bar */
    .popup-content::before {
      content: "";
      position: absolute;
      top: 0;
      left: 0;
      width: 100%;
      height: 6px;
      background: linear-gradient(90deg, #f0974eff, #caff33);
      border-top-left-radius: 12px;
      border-top-right-radius: 12px;
    }

    /* Divider Lines */
    .payment-divider {
      border-top: 1px dashed #666;
      margin: 12px 0;
    }

    /* Payment Rows */
    .payment-row {
      display: flex;
      justify-content: flex-end;
      align-items: flex-start;
      flex-wrap: wrap;
      padding: 6px 0;
      font-size: 0.95rem;
      color: #ddd;
    }

    /* Highlight Total */
    .payment-row:last-child {
      font-weight: bold;
      font-size: 1.1rem;
      color: #fff;
    }

    /* Close Button */
    .close {
      color: #aaa;
      float: right;
      font-size: 24px;
      cursor: pointer;
    }
    .close:hover {
      color: #fff;
    }

    /*.payment-divider {
      border-top: 3px dashed #777;
      margin: 15px 0;
    }*/

    .payment-row {
      display: flex;
      justify-content: space-between;
      padding: 8px 0;
      border-bottom: 1px dashed #ccc;
      font-size: 1rem;
    }

    .payment-row:last-child {
      border-bottom: none;
    }

    /* Close button */
    .close {
      color: #000000;
      float: right;
      font-size: 28px;
      cursor: pointer;
    }


    #court-selector {
      display: grid;
      grid-template-columns: repeat(4, 1fr);
      gap: 20px;
      justify-items: center;
      margin-top: 20px;
    }

    .court-box {
      width: 100px;
      height: 100px;
      background-color: #2C2C3E;
      border: 2px solid #B0CEE2;
      border-radius: 16px;
      display: flex;
      align-items: center;
      justify-content: center;
      font-weight: 600;
      font-size: 1.4rem;
      color: #F1F1F1;
      cursor: pointer;
      transition: 0.2s ease-in-out;
      box-shadow: 0 4px 10px rgba(0, 0, 0, 0.3);
    }

    .court-box:hover {
      background-color: #2C2C3E;
      color: white;
      transform: scale(1.05);
    }

    .court-box.selected {
      background-color: #caff33;
      border: 2px solid white;
      color: white;
    }

    .turf-photo {
      width: 400px;
      border-radius: 15px;
      display: block;
      object-fit: cover;
      margin: 20px auto;
      
    }

    .warning {
            color: red;
            font-size: 13px;
        }
    </style>

<script>
  var isdateselected = false;
  var isslotselected = false;
  
  // function selectDate(el) {
    //  const isselected = el.classList.contains('selected');
    //  document.querySelectorAll('.date-box').forEach(box => box.classList.remove('selected'));
    //  isdateselected = false;
    //   if (!isselected) {
      //     el.classList.add('selected');
    //    isdateselected = true;
    //  }
    // }
    let turfname = "J.p Dawar's Turf";
    let turfaddress = "📍veer narmad south gujarat university,surat."; 

    //slot genration
    const slotGroups = [
      {
        label: "Morning slots",
        price: 600,
        startHour: 7,
        endHour: 12
      },
      {
        label: "Afternoon slots",
        price: 800,
        startHour: 12,
        endHour: 18
      },
      {
        label: "Evening slots",
        price: 1000,
        startHour: 18,
        endHour: 22
      }
    ];

    function on_load() {
      document.getElementById("tname").innerText = turfname;
      document.getElementById("turfadd").innerText = turfaddress;


      const container = document.getElementById('slots-container');
      slotGroups.forEach(group => {
        // Add title
        const title = document.createElement('p');
        title.style.textAlign = "center";
        title.style.fontSize = "larger";
        title.innerText = `${group.label} (Per hour charges ₹${group.price})`;
        container.appendChild(title);

        // Slots wrapper
        const slotsWrapper = document.createElement('div');
        slotsWrapper.className = "slots d-flex flex-wrap gap-3 py-2 px-2";
        slotsWrapper.setAttribute('price', group.price);

        // Create slots by hour
        for (let hour = group.startHour; hour < group.endHour; hour++) {
          const nextHour = hour + 1;
          const slot = document.createElement('div');
          slot.className = 'slot';
          slot.innerText = formatTime(hour) + " to " + formatTime(nextHour);
          slot.onclick = () => selectslot(slot);
          slotsWrapper.appendChild(slot);
        }

        container.appendChild(slotsWrapper);
        container.appendChild(document.createElement('br'));
      });
    }
    function formatTime(hour) {
      const suffix = hour >= 12 ? "PM" : "AM";
      let h = hour % 12;
      if (h === 0) h = 12;
      return `${h}:00`;
    }

    let total = 0;

    function calculateTotal() {
      total = 0;
      document.querySelectorAll('.slot.selected').forEach(slot => {
        const parent = slot.closest('.slots'); // const parent = slot.closest('.slots');
        const price = parseInt(parent.getAttribute('price')) || 0;
        total += price;
      });
      document.getElementById('totalDisplay').textContent = 'Total Price: ₹' + total + " (Without extra charges)";
    }

    function selectslot(el) {
  const isselected = el.classList.contains('selected');
  if (isselected) {
    el.classList.remove('selected');
  } else {
    el.classList.add('selected');
  }
  calculateTotal();
  isslotselected = document.querySelectorAll('.slot.selected').length > 0;
}


    function selectCourt(el) {
      document.querySelectorAll('.court-box').forEach(court => court.classList.remove('selected'));
      el.classList.add('selected');
    }

    //Pop menu
    function openpage1() {
      document.getElementById("popupmenu").style.display = "block"
      document.getElementById("page1").style.display = "block";
      document.getElementById("page2").style.display = "none";
    }
    function openpage2() {
      document.getElementById("popupmenu").style.display = "block"
      document.getElementById("page1").style.display = "none";
      document.getElementById("page2").style.display = "block";

      let slot = document.querySelectorAll(".slot.selected")
      let slotname = "";
      slot.forEach(element => {
        slotname += element.innerText + " | ";
      });

      let cgst = (total * 9) / 100;
      let sgst = (total * 9) / 100;
      let platformfee = (total * 10) / 100;
      let discount = (total * 5) / 100;
      let totalamt = total + cgst + sgst + platformfee;
      let totalcharge = cgst + sgst + platformfee;
     document.getElementById("turfname").innerText = turfname;
      document.getElementById("slot").innerText = slotname;
      document.getElementById("date").innerText = selecteddate;
      document.getElementById("amt").innerText = "₹" + total;
      document.getElementById("charge").innerText = "₹" + totalcharge;
      document.getElementById("totalamt").innerText = "₹" + totalamt;
    }



    // // ✅ Just insert the VALUES, not the labels!
    // document.getElementById("name").innerText = "Pushpal Desai.";
    // document.getElementById("amt").innerText = "₹" + total;
    // document.getElementById("cgst").innerText = "₹" + cgst.toFixed(2);
    // document.getElementById("sgst").innerText = "₹" + sgst.toFixed(2);
    // document.getElementById("platformfee").innerText = "₹" + platformfee.toFixed(2);
    // document.getElementById("discount").innerText = "- ₹" + discount.toFixed(2);
    // document.getElementById("totalamt").innerText = "₹" + totalamt.toFixed(2);

    function closepopup() {
      document.getElementById("popupmenu").style.display = "none"
    }
    // for page1 to check name and mobile number.
    function checkpage1() {
      let name = document.getElementById("name").value.trim();
      let number = document.getElementById("mobilenumber").value.trim();
      let name_pattern = /^[a-zA-Z ]{2,}$/;
      let number_pattern = /^[789]{1}[0-9]{9}$/
      let is_name = true;
      let is_number = true;
      if (name === "") {
          document.getElementById("name_warning").innerText = "Your name is required."; is_name = false;
      } else if (name_pattern.test(name) == false) {
          document.getElementById("name_warning").innerText = "Please give appropriate name."; is_name = false;
      } else {
          document.getElementById("name_warning").innerText = ""; is_name = true;
      }

       if (number === "") {
          document.getElementById("number_warning").innerText = "Your mobile number is required."; is_number = false;
      } else if (number_pattern.test(number) == false) {
          document.getElementById("number_warning").innerText = "Please give valid mobile number."; is_number = false;
      } else {
          document.getElementById("number_warning").innerText = ""; is_number = true;
      }

      if (is_name && is_number) {
         openpage2();
       }
    } 
    window.onclick = function(event) {
  const popup = document.getElementById("popupmenu");
  if (event.target == popup) {
    popup.style.display = "none";
  }
}

    var selecteddate = "";

    //validation of date & time
    function validate() {

      selecteddate = document.getElementById("datePicker").value;

      if (!selecteddate) {
        document.getElementById("warning").innerText = "Please select the date for your booking.";
      } else if (!isslotselected) {
        document.getElementById("warning").innerText = "Please select the slot for your booking.";
      } else {
        document.getElementById("warning").innerText = "";
        openpage1();
      }
    }


  </script>

</head>

<body onload="on_load()">
  
  <form action="/submit-booking" method="POST">
    <p id="tname"
      style="text-align: center;font-size: 50px;font-family:'Franklin Gothic Medium', 'Arial Narrow', Arial, sans-serif">
      </p>
    <p id="turfadd" style="text-align: center;font-size: 20px;font-family:'Rajdhani', sans-serif ;"></p>


    <img class="turf-photo" src="images/bg.jpeg">

    <div class="mb-4">
      <label for="datePicker" class="form-label">Select Date:</label>
      <input id="datePicker" name="datePicker" type="date" class="form-control" placeholder="Choose a date" readonly>
    </div>




    <div class="mb-3">
      <label for="time" class="form-label">Available Slots :</label>
      <div id="slots-container" name="slots-container"></div>

      <!-- <p style="text-align: center;font-size: larger;">Morning slots (Per hour charges ₹600)</p>
      <div class="d-flex flex-wrap gap-3 py-2 px-2 slots" id="time" price="600"> 
        <div class="slot" onclick="selectslot(this)">6:00 to 7:00</div>
        <div class="slot" onclick="selectslot(this)">7:00 to 8:00</div>
        <div class="slot" onclick="selectslot(this)">8:00 to 9:00</div>
        <div class="slot" onclick="selectslot(this)">9:00 to 10:00</div>
        <div class="slot" onclick="selectslot(this)">10:00 to 11:00</div>
        <div class="slot" onclick="selectslot(this)">11:00 to 12:00</div>
      </div><br>

      <p style="text-align: center;font-size: larger;">Afternoon slots (Per hour charges ₹800)</p>
      <div class="d-flex flex-wrap gap-3 py-2 px-2 slots" id="time" price="800">
        <div class="slot" onclick="selectslot(this)">12:00 to 1:00</div>
        <div class="slot" onclick="selectslot(this)">1:00 to 2:00</div>
        <div class="slot" onclick="selectslot(this)">2:00 to 3:00</div>
        <div class="slot" onclick="selectslot(this)">3:00 to 4:00</div>
        <div class="slot" onclick="selectslot(this)">4:00 to 5:00</div>
        <div class="slot" onclick="selectslot(this)">5:00 to 6:00</div>
      </div><br>

      <p style="text-align: center;font-size: larger;">Evening slots (Per hour charges ₹1000)</p>
      <div class="d-flex flex-wrap gap-3 py-2 px-2 slots" id="time" price="1000">
        <div class="slot" onclick="selectslot(this)">6:00 to 7:00</div>
        <div class="slot" onclick="selectslot(this)">7:00 to 8:00</div>
        <div class="slot" onclick="selectslot(this)">8:00 to 9:00</div>
        <div class="slot" onclick="selectslot(this)">9:00 to 10:00</div>
      </div> ././
    </div><br>

    <div class="mb-4">
      <label class="form-label">Choose a Court:</label>
      <div class="d-flex flex-wrap gap-3 px-2" id="court-selector">
        <div class="court-box" onclick="selectCourt(this)">A1</div>
        <div class="court-box" onclick="selectCourt(this)">B1</div>
        <div class="court-box" onclick="selectCourt(this)">B2</div>
        <div class="court-box" onclick="selectCourt(this)">C1</div>
        <div class="court-box" onclick="selectCourt(this)">B3</div>
      </div>
    </div>

    <div id="warning" name="warning" style="color: red;"></div>

    <p id="totalDisplay" style="text-align:center; font-size: larger; margin-top:20px;">Total Price: ₹0 (without
      charges)</p>
    <button type="button" onclick="validate()">Book Now</button>

    
    <div id="popupmenu" class="popmenu">
      <div class="popup-content">
        <div id="page1">
          <span class="close" onclick="closepopup()">&times;</span>
          <p style="text-align: center; text-decoration: underline; font-size: larger;">Book Your Slot</p>
          <label>Your Details</label>

          <div>Name <span class = "warning"> *</span></div>
          <input type="text" class="form-control" id="name" name="name" placeholder="Your Name">
          <div class="warning" id="name_warning" name="name_warning"></div><br>

          <div>Mobile number<span class = "warning"> *</span></div>
          <input type="text" class="form-control" id="mobilenumber" name="mobilenumber" placeholder="Your Mobile Number">
          <span class="warning" id="number_warning" name="number_warning"></span><br>

          <button type="button" onclick="checkpage1()">Confirm</button>
        </div>


        <div id="page2">
          <span class="close" onclick="closepopup()">&times;</span>
            <!--<div class="payment-divider"></div>  TOP DASHED LINE  
          <p style="text-align: center; text-decoration: underline; font-size: larger;">Booking Summary</p>
          <div class="payment-row">
            <span>Turf name : </span>
            <span id="turfname" name="turfname"></span>
          </div>
          <div class="payment-row">
            <span>Date : </span>
            <span id="date" name="date"></span>
          </div>
          <div class="payment-row">
            <span>Time slot : </span>
            <span id="slot" name="slot"></span>
          </div>
          <div class="payment-box">
            <div class="payment-row">
              <span>Amount : </span>
              <span id="amt" name="amt"></span>
            </div>
            <div class="payment-row">
              <span>Extra charges : </span>
              <span id="charge" name="charge"></span>
            </div>
            <div class="payment-row">
              <span>Total : </span>
              <span id="totalamt" name="totalamt"></span>
            </div>
            <!--<div class="payment-divider"></div>  TOP DASHED LINE  
          </div>
          <button type="button">Pay now</button>
        </div>

      </div>
    </div>
  </form>
  <script src="https://cdn.jsdelivr.net/npm/flatpickr"></script>
  <script>
    flatpickr("#datePicker", {
      theme: "dark",              // matches your dark theme
      dateFormat: "d M Y, D",     // e.g., 15 Jul 2025, Tue
      minDate: "today",
      inline: false,              // set to true for embedded calendar
      onChange: function (selectedDates, dateStr) {
        console.log("User picked:", dateStr);
        // Add your custom handling here
      }
    });
  </script>
</body> 

</html>-->