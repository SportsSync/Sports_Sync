<!DOCTYPE html>

<?php
    include ("db.php");

    if($_SERVER['REQUEST_METHOD']=="POST"){

        $turf_name=$_POST['turf_name'];
        $location=$_POST['turf_add'];
        $description=$_POST['description'];
        $starttime=$_POST['fromtime'];
        $endtime=$_POST['totime'];
        //temp apne session use karvanu che
        $owner_id=1;

// =================Turf tb=====================
        $sql="Insert into turftb(owner_id,turf_name,location,description) values(?,?,?,?)";
        $stmt = mysqli_prepare($conn, $sql);
        mysqli_stmt_bind_param($stmt, "isss", $owner_id, $turf_name, $location, $description);
        mysqli_stmt_execute($stmt);
        
        $turf_id=mysqli_insert_id($conn);

// =================Turf slot tb=================
        $sql2 = "INSERT INTO turf_price_slotstb
        (turf_id, start_time, end_time, price_per_hour, is_weekend)
        VALUES (?, ?, ?, 0, 0)";

            $stmt2 = mysqli_prepare($conn, $sql2);
            mysqli_stmt_bind_param($stmt2, "iss", $turf_id, $starttime, $endtime);
            mysqli_stmt_execute($stmt2);

// =================Turf image tb=================
           if (!empty($_FILES['turf_images']['name'][0])) {

    foreach ($_FILES['turf_images']['name'] as $key => $img_name) {

        $tmp_name = $_FILES['turf_images']['tmp_name'][$key];

        $folder = "turf_images/";
        $newName = time() . "_" . basename($img_name);

        move_uploaded_file($tmp_name, $folder . $newName);

        $sql3 = "INSERT INTO turf_imagestb (turf_id, image_path)
                 VALUES (?, ?)";

        $stmt3 = mysqli_prepare($conn, $sql3);
        mysqli_stmt_bind_param($stmt3, "is", $turf_id, $newName);
        mysqli_stmt_execute($stmt3);

        //      if (!empty($_POST['sports'])) {
        //     foreach ($_POST['sports'] as $sport_id) {
        //         $sql3 = "INSERT INTO turf_sportstb (turf_id, sport_id)
        //              VALUES (?, ?)";
        //         $stmt3 = mysqli_prepare($conn, $sql3);
        //         mysqli_stmt_bind_param($stmt3, "ii", $turf_id, $sport_id);
        //         mysqli_stmt_execute($stmt3);
        //     }
        // }
    }
}

    }

?>
>>>>>>> Stashed changes
<html>
<head>
    <title>Vendor Turf Registration</title>

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">

    <style>
        body.vendor-turf-page {
            background-image: url('https://images.unsplash.com/photo-1617696618050-b0fef0c666af?q=80&w=870&auto=format&fit=crop');
            background-size: cover;
            background-position: center;
            background-attachment: fixed;
            background-repeat: no-repeat;
            color: #f1f1f1;
            font-family: 'Segoe UI', sans-serif;
        }

        .vendor-turf-page .form-container {
            background: rgba(0, 0, 0, 0.85);
            padding: 40px;
            border-radius: 16px;
            max-width: 450px;
            margin: 60px auto;
            box-shadow: 0 8px 16px rgba(0, 0, 0, 0.6);
        }

        .vendor-turf-page h2 {
            text-align: center;
            color: #eb7e25;
            margin-bottom: 25px;
            font-weight: 600;
        }

        .vendor-turf-page label {
            font-size: 14px;
            color: #ddd;
        }

        .vendor-turf-page .form-control {
            border-radius: 8px;
        }

        .vendor-turf-page .warning {
            color: red;
            font-size: 13px;
        }

        .vendor-turf-page .btn-custom {
            background-color: #eb7e25;
            color: #000;
            font-weight: 600;
            border-radius: 10px;
        }

        .vendor-turf-page .btn-custom:hover {
            color: #fff;
        }

        .time-row {
            display: flex;
            gap: 15px;
        }

        .price-box {
            border: 1px solid rgba(255,255,255,0.15);
            padding: 15px;
            border-radius: 12px;
            margin-top: 15px;
        }

        .price-box h6 {
            margin-bottom: 10px;
            color: #ffc107;
        }

        .hot-hour-row {
            display: flex;
            gap: 8px;
            margin-bottom: 8px;
        }

        .add-hot-btn {
            font-size: 13px;
            color: #eb7e25;
            cursor: pointer;
        }
    </style>
</head>

<body class="vendor-turf-page">

<div class="form-container">
<form>

<h2>Turf Details</h2>

      <!-- Address -->
      <div class="mb-3">
        <label for="address" class="form-label" style="display: block; margin-bottom: 5px;"><span class="warning">*
          </span>Turf Address:</label>
        <textarea id="turf_add" name="turf_add" rows="4" cols="40" class="form-control" placeholder="Enter your Full Address"></textarea>
      </div><br>


<!-- Turf Name -->
<div class="mb-3">
<label><span class="warning">*</span> Turf Name</label>
<input type="text" class="form-control">
</div>

<!-- Address -->
<div class="mb-3">
<label><span class="warning">*</span> Turf Address</label>
<textarea class="form-control" rows="3"></textarea>
</div>

<!--image upload--> 
<div class="mb-3"> 
  <label for="imageUpload"><span class="warning">* </span>Upload an Image:</label> 
  <input type="file" id="imageUpload" name="imageUpload" multiple accept="image/*">
 </div>
 <br>
<!--description--> 
<div class="mb-3">
   <label class="form-label">Description</label>
    <textarea id="description" name="description" rows="3" class="form-control" placeholder="About your turf" required></textarea><br> </div> <!--aminities--> <div class="mb-3"> <label class="form-label">Select your Amenities:</label><br> <input type="checkbox" id="cafe" name="cafe" value="Cafeteria"> <label for="hobby1">Cafeteria</label><br> <input type="checkbox" id="wash" name="wash" value="Washroom"> <label for="hobby2">Washroom</label><br> <input type="checkbox" id="sit" name="sit" value="Sitting Area"> <label for="hobby3">Sitting Area</label><br> <input type="checkbox" id="equip" name="equip" value="Sports Equipment"> <label for="hobby4">Sports Equipment</label> 
  </div> 
<br>

<!-- Operating Time -->
<div class="mb-3">
<label><span class="warning">*</span> Operating Time</label>
<div class="time-row">
<input type="time" class="form-control">
<input type="time" class="form-control">
</div>
</div>

<!-- Sports -->
<div class="mb-3">
<label><span class="warning">*</span> Sports Available</label><br>
<input type="checkbox" class="sportCheck" value="Football"> Football<br>
<input type="checkbox" class="sportCheck" value="Cricket"> Cricket<br>
<input type="checkbox" class="sportCheck" value="Badminton"> Badminton<br>
<input type="checkbox" class="sportCheck" value="Tennis"> Tennis
</div>

<!-- Pricing Cards will appear here -->
<div id="pricingContainer"></div>

<template id="pricingTemplate">
  <div class="price-box mt-4 p-3 border rounded">

    <h6 class="text-warning sport-title"></h6>

    <!-- Weekday Prices -->
    <label>Weekday Prices</label>
    <input type="number" class="form-control mb-2" placeholder="Morning ₹">
    <input type="number" class="form-control mb-2" placeholder="Evening ₹">
    <input type="number" class="form-control mb-2" placeholder="Night ₹">

    <!-- Weekend -->
    <div class="mt-2">
      <input type="checkbox" class="weekendToggle">
      <label>Different weekend prices</label>
    </div>

    <div class="weekendPrices mt-2" style="display:none;">
      <input type="number" class="form-control mb-2" placeholder="Weekend Morning ₹">
      <input type="number" class="form-control mb-2" placeholder="Weekend Evening ₹">
      <input type="number" class="form-control" placeholder="Weekend Night ₹">
    </div>

    <hr class="text-secondary">

    <!-- HOT HOUR -->
<div class="mt-2">
  <input type="checkbox" class="hotHourToggle">
  <label><strong>Enable Hot Hour Pricing</strong></label>
</div>

<div class="hotHourBox mt-2" style="display:none;">

  <div class="hotHourList"></div>

  <button type="button" class="btn btn-sm btn-outline-warning addHotHour mt-2">
    + Add Hot Hour
  </button>

</div>

    <div class="hotHourBox mt-2" style="display:none;">
      <label class="small">Hot Hour Time</label>
      <div class="d-flex gap-2 mb-2">
        <input type="time" class="form-control">
        <input type="time" class="form-control">
      </div>

      <input type="number" class="form-control" placeholder="Hot Hour Price ₹">
    </div>

  </div>

  <template class="hotHourRowTemplate">
  <div class="d-flex gap-2 align-items-end hotHourRow mb-2">
    <input type="time" class="form-control" required>
    <input type="time" class="form-control" required>
    <input type="number" class="form-control" placeholder="₹ Price" required>
    <button type="button" class="btn btn-danger btn-sm removeHotHour">✕</button>
  </div>
</template>

</template>

<button class="btn btn-custom w-100 mt-4">Register</button>

</form>
</div>

<script>
  const sportChecks = document.querySelectorAll('.sportCheck');
  const container = document.getElementById('pricingContainer');
  const template = document.getElementById('pricingTemplate');

  sportChecks.forEach(check => {
    check.addEventListener('change', function () {

      if (this.checked) {
        const clone = template.content.cloneNode(true);
        const box = clone.querySelector('.price-box');

        box.dataset.sport = this.value;
        clone.querySelector('.sport-title').innerText =
          this.value + " Pricing";

        // Weekend toggle
        const weekendToggle = clone.querySelector('.weekendToggle');
        const weekendBox = clone.querySelector('.weekendPrices');

        weekendToggle.addEventListener('change', function () {
          weekendBox.style.display = this.checked ? "block" : "none";
        });

        // HOT HOUR MULTI
        const hotToggle = clone.querySelector('.hotHourToggle');
        const hotBox = clone.querySelector('.hotHourBox');
        const addBtn = clone.querySelector('.addHotHour');
        const list = clone.querySelector('.hotHourList');
        const rowTemplate = clone.querySelector('.hotHourRowTemplate');

        hotToggle.addEventListener('change', function () {
          hotBox.style.display = this.checked ? "block" : "none";
          if (this.checked && list.children.length === 0) {
            addHotHour();
          }
        });

        function addHotHour() {
          const row = rowTemplate.content.cloneNode(true);
          row.querySelector('.removeHotHour')
            .addEventListener('click', function () {
              this.closest('.hotHourRow').remove();
            });
          list.appendChild(row);
        }

        addBtn.addEventListener('click', addHotHour);

        container.appendChild(clone);
      } 
      else {
        document
          .querySelectorAll(`[data-sport="${this.value}"]`)
          .forEach(el => el.remove());
      }
    });
  });
</script>


</body>
</html>
