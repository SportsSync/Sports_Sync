<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <title>Turf Booking</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.5/font/bootstrap-icons.css">
  <!-- Flatpickr CSS (dark theme) -->
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/flatpickr/dist/flatpickr.min.css">
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/flatpickr/dist/themes/dark.css">

  <style>
    body {
      background-image: url('images/bg4.jpeg');
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
      background-color: #eb7e25;
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
      background: linear-gradient(90deg, #f0974eff, #eb7e25);
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
      justify-content: space-between;
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
      background-color: #eb7e25;
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
  
  <form action="/submit-booking" method="post">
    <p id="tname"
      style="text-align: center;font-size: 50px;font-family:'Franklin Gothic Medium', 'Arial Narrow', Arial, sans-serif">
      </p>
    <p id="turfadd" style="text-align: center;font-size: 20px;font-family:'Rajdhani', sans-serif ;"></p>


    <img class="turf-photo" src="images/bg.jpeg">

    <div class="mb-4">
      <label for="datePicker" class="form-label">Select Date:</label>
      <input id="datePicker" type="date" class="form-control" placeholder="Choose a date" readonly>
    </div>




    <div class="mb-3">
      <label for="time" class="form-label">Available Slots :</label>
      <div id="slots-container"></div>

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
      </div> -->
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

    <div id="warning" style="color: red;"></div>

    <p id="totalDisplay" style="text-align:center; font-size: larger; margin-top:20px;">Total Price: ₹0 (without
      charges)</p>
    <button type="button" onclick="validate()">Book Now</button>

    <!-- popmenu -->
    <div id="popupmenu" class="popmenu">
      <div class="popup-content">
        <div id="page1">
          <span class="close" onclick="closepopup()">&times;</span>
          <p style="text-align: center; text-decoration: underline; font-size: larger;">Book Your Slot</p>
          <label>Your Details</label>

          <div>Name <span class = "warning"> *</span></div>
          <input type="text" class="form-control" id="name" placeholder="Your Name">
          <div class="warning" id="name_warning"></div><br>

          <div>Mobile number<span class = "warning"> *</span></div>
          <input type="text" class="form-control" id="mobilenumber" placeholder="Your Mobile Number">
          <span class="warning" id="number_warning"></span><br>

          <button type="button" onclick="checkpage1()">Confirm</button>
        </div>


        <div id="page2">
          <span class="close" onclick="closepopup()">&times;</span>
            <!--<div class="payment-divider"></div>  TOP DASHED LINE  -->
          <p style="text-align: center; text-decoration: underline; font-size: larger;">Booking Summary</p>
          <div class="payment-row">
            <span>Turf name : </span>
            <span id="turfname"></span>
          </div>
          <div class="payment-row">
            <span>Date : </span>
            <span id="date"></span>
          </div>
          <div class="payment-row">
            <span>Time slot : </span>
            <span id="slot"></span>
          </div>
          <div class="payment-box">
            <div class="payment-row">
              <span>Amount : </span>
              <span id="amt"></span>
            </div>
            <div class="payment-row">
              <span>Extra charges : </span>
              <span id="charge"></span>
            </div>
            <div class="payment-row">
              <span>Total : </span>
              <span id="totalamt"></span>
            </div>
            <!--<div class="payment-divider"></div>  TOP DASHED LINE  -->
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

</html>