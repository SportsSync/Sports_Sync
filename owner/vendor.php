<?php
session_start();
//echo "<script>alert(\"start\")</script>";
include("db.php");
$sportPrefixes = [
  1 => 'F', // Football
  2 => 'C', // Cricket
  3 => 'P', // Pickleball
  4 => 'T', // Tennis
];
//fetch city for dropdown
$cities = [];
$res = mysqli_query($conn, "SELECT city_id, city_name FROM citytb ORDER BY city_name");
while ($row = mysqli_fetch_assoc($res)) {
  $cities[] = $row;
}
if ($_SERVER['REQUEST_METHOD'] == "POST") {
  mysqli_begin_transaction($conn);
  try {
    if (empty($_POST['sports']) || empty($_POST['price'])) {
      throw new Exception("Sports and pricing required");
    }
    //echo "<script>alert(\"ok\")</script>";
    $start_time = $_POST['start_time']; // e.g. 06:00
    $end_time = $_POST['end_time'];   // e.g. 23:00

    $startTs = strtotime($start_time);
    $endTs = strtotime($end_time);

    if ($endTs <= $startTs) {
      $endTs += 86400; // next day
    }

    $turf_name = $_POST["turf_name"];
    $location = $_POST["turf_add"];
    $description = $_POST["description"];

    $owner_id = $_SESSION['user_id'];
    if (empty($_POST['city_id'])) {
      throw new Exception("City is required");
    }
    $city_id = (int) $_POST['city_id'];

    // =================Turf tb=====================
    $sql = "INSERT INTO turftb
(owner_id, turf_name, city_id, location, description)
VALUES (?,?,?,?,?)";

    $stmt = mysqli_prepare($conn, $sql);
    mysqli_stmt_bind_param(
      $stmt,
      "isiss",
      $owner_id,
      $turf_name,
      $city_id,
      $location,
      $description
    );
    mysqli_stmt_execute($stmt);


    $turf_id = mysqli_insert_id($conn);
    //amenities mapped for turd
    if (!empty($_POST['amenities'])) {
      foreach ($_POST['amenities'] as $amenity_id) {
        $sql = "INSERT INTO turf_amenitiestb (turf_id, amenity_id) VALUES (?,?)";
        $stmt = mysqli_prepare($conn, $sql);
        mysqli_stmt_bind_param($stmt, "ii", $turf_id, $amenity_id);
        mysqli_stmt_execute($stmt);
      }
    }
    //sports mapped for turf
    foreach ($_POST['sports'] as $sport_id) {
      if (
        !isset($_POST['courts'][$sport_id]) ||
        !is_numeric($_POST['courts'][$sport_id]) ||
        $_POST['courts'][$sport_id] < 1
      ) {
        throw new Exception("Invalid number of courts for sport $sport_id");
      }

      $courts = (int) $_POST['courts'][$sport_id];

      $sql = "INSERT INTO turf_sportstb (turf_id, sport_id, no_of_courts)
          VALUES (?,?,?)";

      $stmt = mysqli_prepare($conn, $sql);
      mysqli_stmt_bind_param($stmt, "iii", $turf_id, $sport_id, $courts);
      mysqli_stmt_execute($stmt);

      // ================= TURF COURTS =================
      if (!isset($sportPrefixes[$sport_id])) {
        throw new Exception("Court prefix not defined for sport $sport_id");
      }
      $prefix = $sportPrefixes[$sport_id];
      for ($i = 1; $i <= $courts; $i++) {

        $courtName = $prefix . $i; // C1, C2, F1...

        $sql = "INSERT INTO turf_courtstb (turf_id, sport_id, court_name, status)
          VALUES (?,?,?, 'A')";

        $stmt = mysqli_prepare($conn, $sql);
        mysqli_stmt_bind_param($stmt, "iis", $turf_id, $sport_id, $courtName);
        mysqli_stmt_execute($stmt);
      }
    }
    // =================Turf slot tb=================
//for weekdays
    foreach ($_POST['sports'] as $sport_id) {
      if (!isset($_POST['price'][$sport_id])) {
        throw new Exception("Pricing missing for sport $sport_id");
      }

      if (empty($_POST['price'][$sport_id]['weekday'])) {
        throw new Exception("Weekday price missing for sport $sport_id");
      }

      for ($t = $startTs; $t < $endTs; $t += 3600) {

        $slotStart = date("H:i", $t);
        $slotEnd = date("H:i", min($t + 3600, $endTs));

        $hour = (int) date("H", $t);
        if ($hour < 12) {
          $price = $_POST['price'][$sport_id]['weekday']['morning'];
        } elseif ($hour < 18) {
          $price = $_POST['price'][$sport_id]['weekday']['evening'];
        } else {
          $price = $_POST['price'][$sport_id]['weekday']['night'];
        }
        if (!is_numeric($price) || $price <= 0) {
          throw new Exception("Invalid price");
        }

        $sql = "INSERT INTO turf_price_slotstb
            (turf_id, sport_id, start_time, end_time, price_per_hour, is_weekend)
            VALUES (?,?,?,?,?,0)";

        $stmt = mysqli_prepare($conn, $sql);
        mysqli_stmt_bind_param(
          $stmt,
          "iissd",
          $turf_id,
          $sport_id,
          $slotStart,
          $slotEnd,
          $price
        );
        mysqli_stmt_execute($stmt);
      }
    }
    //for weekend
    foreach ($_POST['sports'] as $sport_id) {

      if (empty($_POST['price'][$sport_id]['weekend'])) {
        continue;
      }
      if (!isset($_POST['price'][$sport_id])) {
        throw new Exception("Pricing missing for sport $sport_id");
      }
      for ($t = $startTs; $t < $endTs; $t += 3600) {

        $slotStart = date("H:i", $t);
        $slotEnd = date("H:i", min($t + 3600, $endTs));
        $hour = (int) date("H", $t);

        if ($hour < 12) {
          $price = $_POST['price'][$sport_id]['weekend']['morning'];
        } elseif ($hour < 18) {
          $price = $_POST['price'][$sport_id]['weekend']['evening'];
        } else {
          $price = $_POST['price'][$sport_id]['weekend']['night'];
        }

        if (!is_numeric($price) || $price <= 0) {
          continue;//this if weekend price not provided
          throw new Exception("Invalid weekend price");
        }

        $sql = "INSERT INTO turf_price_slotstb
            (turf_id, sport_id, start_time, end_time, price_per_hour, is_weekend)
            VALUES (?,?,?,?,?,1)";

        $stmt = mysqli_prepare($conn, $sql);
        mysqli_stmt_bind_param(
          $stmt,
          "iissd",
          $turf_id,
          $sport_id,
          $slotStart,
          $slotEnd,
          $price
        );
        mysqli_stmt_execute($stmt);
      }
    }
    //hot hours
// HOT HOURS (SAFE + FINAL)
    foreach ($_POST['sports'] as $sport_id) {

      if (empty($_POST['hot'][$sport_id]) || !is_array($_POST['hot'][$sport_id])) {
        continue;
      }

      foreach ($_POST['hot'][$sport_id] as $hot) {

        // ⛔ Skip incomplete rows
        if (
          empty($hot['start']) ||
          empty($hot['end']) ||
          !isset($hot['price']) ||
          $hot['price'] === ''
        ) {
          continue;
        }

        $baseDate = date("Y-m-d", $startTs);
        $hotStart = strtotime($baseDate . " " . $hot['start']);
        $hotEnd = strtotime($baseDate . " " . $hot['end']);

        if ($hotEnd <= $hotStart) {
          $hotEnd += 86400;
        }

        // ⛔ Must be hour-aligned
        if (($hotEnd - $hotStart) % 3600 !== 0) {
          throw new Exception("Hot hour must be full-hour based");
        }

        $hotPrice = (float) $hot['price'];

        if ($hotPrice < 0) {
          throw new Exception("Invalid hot hour price");
        }

        // ⛔ Must be inside operating hours
        if ($hotStart < $startTs || $hotEnd > $endTs) {
          throw new Exception("Hot hour outside operating time");
        }

        // 🔁 Update each affected hour slot
        for ($t = $hotStart; $t < $hotEnd; $t += 3600) {

          $slotStart = date("H:i", $t);
          $slotEnd = date("H:i", $t + 3600);

          $sql = "UPDATE turf_price_slotstb
                    SET price_per_hour = ?
                    WHERE turf_id = ?
                    AND sport_id = ?
                    AND start_time = ?
                    AND end_time = ?";

          $stmt = mysqli_prepare($conn, $sql);
          mysqli_stmt_bind_param(
            $stmt,
            "diiss",
            $hotPrice,
            $turf_id,
            $sport_id,
            $slotStart,
            $slotEnd
          );
          mysqli_stmt_execute($stmt);
        }
      }
    }


    // =================Turf image tb=================
    if (
      isset($_FILES['turf_images']) &&
      is_array($_FILES['turf_images']['name']) &&
      count($_FILES['turf_images']['name']) > 0 &&
      $_FILES['turf_images']['name'][0] !== ''
    ) {

      foreach ($_FILES['turf_images']['name'] as $key => $img_name) {

        $tmp_name = $_FILES['turf_images']['tmp_name'][$key];

        $folder = "turf_images/";
        $newName = uniqid("turf_", true) . "_" . basename($img_name);
        $allowed = ['image/jpeg', 'image/png', 'image/webp', 'image/jpg'];

        if (!in_array(mime_content_type($tmp_name), $allowed)) {
          throw new Exception("Invalid image type");
        }

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
    mysqli_commit($conn);
    //echo "<script>alert(\"success\")</script>";
  } catch (Exception $e) {
    mysqli_rollback($conn);
    //echo "<script>alert(\"not ok\")</script>";
    die("Error occurred: " . $e->getMessage());
  }

}

?>
<!DOCTYPE html>
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
      border: 1px solid rgba(255, 255, 255, 0.15);
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
    <form method="post" action="<?php echo htmlspecialchars($_SERVER['PHP_SELF']); ?>" enctype="multipart/form-data">

      <h2>Turf Details</h2>

      <!-- Turf Name -->
      <div class="mb-3">
        <label><span class="warning">*</span> Turf Name</label>
        <input type="text" id="turf_name" name="turf_name" class="form-control" placeholder="Enter your Turf Name">
      </div><br>

      <!-- Address -->
      <div class="mb-3">
        <label><span class="warning">*</span> City</label>
        <select name="city_id" class="form-control" required>
          <option value="">-- Select City --</option>
          <?php foreach ($cities as $city): ?>
            <option value="<?= $city['city_id'] ?>">
              <?= htmlspecialchars($city['city_name']) ?>
            </option>
          <?php endforeach; ?>
        </select>
      </div>
      <div class="mb-3">
        <label for="address" class="form-label" style="display: block; margin-bottom: 5px;"><span class="warning">*
          </span>Turf Address:</label>
        <textarea id="turf_add" name="turf_add" rows="4" cols="40" class="form-control"
          placeholder="Enter your Full Address"></textarea>
      </div><br>

      <!--image upload-->
      <div class="mb-3">
        <label for="imageUpload"><span class="warning">* </span>Upload an Image:</label>
        <input type="file" id="turf_images" name="turf_images[]" multiple accept="image/*">
      </div><br>

      <!--description-->
      <div class="mb-3">
        <label class="form-label">Description</label>
        <textarea id="description" name="description" rows="3" class="form-control" placeholder="About your turf"
          required></textarea><br>
      </div>
      <!--aminities-->
      <div class="mb-3">
        <label class="form-label">Select your Amenities:</label><br>
        <input type="checkbox" name="amenities[]" value="1"> Cafeteria<br>
        <input type="checkbox" name="amenities[]" value="2"> Washroom<br>
        <input type="checkbox" name="amenities[]" value="3"> Sitting Area<br>
        <input type="checkbox" name="amenities[]" value="4"> Sports Equipment<br>

      </div>
      <br>

      <!-- Operating Time -->
      <div class="mb-3">
        <label><span class="warning">*</span> Operating Time</label>
        <div class="time-row">
          <input type="time" class="form-control" name="start_time" required>
          <input type="time" class="form-control" name="end_time" required>
        </div>
      </div><br>

      <!-- Sports -->
      <div class="mb-3">
        <label><span class="warning">*</span> Sports Available</label><br>
        <input type="checkbox" class="sportCheck" name="sports[]" value="1"> Football
        <input type="checkbox" class="sportCheck" name="sports[]" value="2"> Cricket
        <input type="checkbox" class="sportCheck" name="sports[]" value="3"> PickleBall
        <input type="checkbox" class="sportCheck" name="sports[]" value="4"> Tennis
      </div>

      <!-- Pricing Cards will appear here -->
      <div id="pricingContainer"></div>

      <template id="pricingTemplate">
        <div class="price-box mt-4 p-3 border rounded">

          <h6 class="text-warning sport-title"></h6>
          <div class="mb-2">
            <label class="small">Number of Courts</label>
            <input type="number" class="form-control" min="1" value="1" name="courts[SPORT_ID]" required>
          </div>

          <!-- Weekday Prices -->
          <label>Weekday Prices</label>
          <input type="number" class="form-control mb-2" placeholder="Morning ₹"
            name="price[SPORT_ID][weekday][morning]" required>
          <input type="number" class="form-control mb-2" placeholder="Evening ₹"
            name="price[SPORT_ID][weekday][evening]" required>
          <input type="number" class="form-control mb-2" placeholder="Night ₹" name="price[SPORT_ID][weekday][night]"
            required>
          <!-- Weekend -->
          <div class="mt-2">
            <input type="checkbox" class="weekendToggle">
            <label>Different weekend prices</label>
          </div>

          <div class="weekendPrices mt-2" style="display:none;">
            <input type="number" class="form-control mb-2" placeholder="Weekend Morning ₹"
              name="price[SPORT_ID][weekend][morning]">
            <input type="number" class="form-control mb-2" placeholder="Weekend Evening ₹"
              name="price[SPORT_ID][weekend][evening]">
            <input type="number" class="form-control" placeholder="Weekend Night ₹"
              name="price[SPORT_ID][weekend][night]">
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

        </div>

        <template class="hotHourRowTemplate">
          <div class="d-flex gap-2 align-items-end hotHourRow mb-2">
            <input type="time" class="form-control" name="hot[SPORT_ID][][start]">
            <input type="time" class="form-control" name="hot[SPORT_ID][][end]">
            <input type="number" class="form-control" name="hot[SPORT_ID][][price]">
            <button type="button" class="btn btn-danger btn-sm removeHotHour">✕</button>
          </div>
        </template>

      </template>

      <button type="submit" class="btn btn-custom w-100 mt-4">Register</button>

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

          const sportId = this.value;

          box.dataset.sport = sportId;
          clone.querySelector('.sport-title').innerText =
            this.nextSibling.textContent.trim() + " Pricing";

          clone.querySelectorAll('input').forEach(input => {
            if (input.name) {
              input.name = input.name.replace('SPORT_ID', sportId);
            }
          });

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
            row.querySelectorAll('input').forEach(input => {
              if (input.name) {
                input.name = input.name.replace('SPORT_ID', sportId);
              }
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