<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">

  <title>Elite Grounds</title>

  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css">
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.css">
  <link rel="stylesheet" href="../whole.css">
  <script src="../jquery-3.7.1.min.js"></script>
  <style>
    body {
      background-color: var(--bg-dark);
      color: var(--highlight);
      /* padding: 25px; */
      margin: 0;
    }

    /* Title */
    h2 {
      text-align: center;
      color: var(--highlight);
      margin-bottom: 20px;
      border-bottom: 2px solid var(--divider);
      padding-bottom: 10px;
    }

    /* Filters */
    .form-select,
    .form-control {
      background: var(--card-bg);
      color: var(--bg-dark);
      border: 1px solid var(--border);
    }

    .form-select:focus,
    .form-control:focus {
      border-color: var(--highlight);
      box-shadow: 0 0 5px var(--highlight);
    }

    /* Card */
    .card {
      background: var(--card-bg);
      border: 1px solid var(--divider);
      transition: .3s;
    }

    .card:hover {
      transform: scale(1.03);
      box-shadow: 0 0 15px var(--highlight);
    }

    .card-title {
      color: #c8581fff;
      font-weight: 600;
    }

    .card-text {
      color: #0e0d0dff;
    }

    .btn-success {
      background: var(--highlight);
      color: var(--bg-dark);
      border: none;
    }

    .btn-success:hover {
      box-shadow: 0 0 10px var(--highlight);
    }
    .filter-bar {
  display: flex;
  gap: 12px;
  background: #111;
  padding: 14px;
  border-radius: 14px;
  align-items: center;
}

.filter-item {
  flex: 1;
}

.filter-item select,
.search-box input {
  width: 100%;
  height: 44px;
  border-radius: 10px;
  border: 1px solid #333;
  background: #1c1c1c;
  color: #fff;
  padding: 0 14px;
}

.search-box {
  position: relative;
  flex: 2;
}

.search-box i {
  position: absolute;
  left: 14px;
  top: 50%;
  transform: translateY(-50%);
  color: #aaa;
}

.search-box input {
  padding-left: 40px;
}

  </style>
</head>

<body>

  <div class="container">
    <br><br>
    <h2>Elite Grounds</h2>

    <div class="filter-bar shadow-sm">
  <div class="filter-item search-box">
    <i class="bi bi-search"></i>
    <input type="text" id="searchBox" placeholder="Search turf or location">
  </div>

  <div class="filter-item">
    <select id="cityFilter"></select>
  </div>

  <div class="filter-item">
    <select id="sportFilter"></select>
  </div>

  <div class="filter-item">
    <select id="distanceFilter">
      <option value="">Distance</option>
      <option value="5">Within 5 km</option>
      <option value="10">Within 10 km</option>
      <option value="25">Within 25 km</option>
    </select>
  </div>
</div>


    <!-- Turf Cards -->
    <div class="row mt-5" id="turfContainer">
      <!-- Cards will load here via AJAX -->
    </div>
  </div>
  <script>
    let userLat = null;
    let userLng = null;
    $(document).ready(function () {

      loadCities();
      loadSports();
      loadTurfs();
  
      if (navigator.geolocation) {
        navigator.geolocation.getCurrentPosition(
          function (pos) {
            userLat = pos.coords.latitude;
            userLng = pos.coords.longitude;
            loadTurfs(); // load with distance
          },
          function () {
            loadTurfs(); // load without distance
          }
        );
      } else {
        loadTurfs();
      }

      $('#searchBox').on('keyup', function () {
        loadTurfs();
      });

      $('#cityFilter').on('change', function () {
        loadTurfs();
      });

      $('#sportFilter').on('change', function () {
        loadTurfs();
      });
      $('#distanceFilter').on('change', function () {
        loadTurfs();
      });

    });

    /* ================= LOAD TURFS ================= */
    function loadTurfs() {
      $.ajax({
        url: 'apiSearch/APIfetch_turfs.php',
        method: 'POST',
        data: {
          search: $('#searchBox').val(),
          city: $('#cityFilter').val(),
          sport: $('#sportFilter').val(),
          distance: $('#distanceFilter').val(),
          lat: userLat,
          lng: userLng
        },
        success: function (res) {
          $('#turfContainer').html(res);
        }
      });
    }


    /* ================= LOAD CITIES ================= */
    function loadCities() {
      $.ajax({
        url: 'apiSearch/APIfetch_cities.php',
        success: function (res) {
          $('#cityFilter').html(res);
        }
      });
    }

    /* ================= LOAD SPORTS ================= */
    function loadSports() {
      $.ajax({
        url: 'apiSearch/APIfetch_sports.php',
        success: function (res) {
          $('#sportFilter').html(res);
        }
      });
    }

  </script><br><br><br><br><br>
  <?php include('../footer.php'); ?>
</body>

</html>