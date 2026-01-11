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
  </style>
</head>

<body>

  <div class="container">
  <br><br>
    <h2>Elite Grounds</h2>

    <div class="row justify-content-center align-items-center g-3">

      <!-- Search Bar -->
      <div class="col-md-6">
        <div class="input-group">
          <span class="input-group-text"><i class="bi bi-search"></i></span>
          <input type="text" id="searchBox" class="form-control" placeholder="Search Here">
          <span class="input-group-text"><i class="bi bi-mic-fill"></i></span>
        </div>
      </div>

      <!-- Location Dropdown -->
      <div class="col-md-3">
        <select id="cityFilter" class="form-select"></select>
      </div>

      <!-- Sports Dropdown -->
      <div class="col-md-3">
        <select id="sportFilter" class="form-select"></select>
      </div>
    </div>


    <!-- Turf Cards -->
    <div class="row mt-5" id="turfContainer">
      <!-- Cards will load here via AJAX -->
    </div>
  </div>
  <script>
  $(document).ready(function () {

    loadCities();
    loadSports();
    loadTurfs(); // 🔥 THIS IS WHAT YOU WERE MISSING

    $('#searchBox').on('keyup', function () {
        loadTurfs();
    });

    $('#cityFilter').on('change', function () {
        loadTurfs();
    });

    $('#sportFilter').on('change', function () {
        loadTurfs();
    });
});

/* ================= LOAD TURFS ================= */
function loadTurfs() {

    const search = $('#searchBox').val();
    const city   = $('#cityFilter').val();
    const sport  = $('#sportFilter').val();

    $.ajax({
        url: 'APIfetch_turfs.php',
        method: 'POST',
        data: {
            search: search,
            city: city,
            sport: sport
        },
        success: function (res) {
            $('#turfContainer').html(res);
        }
    });
}

/* ================= LOAD CITIES ================= */
function loadCities() {
    $.ajax({
        url: 'APIfetch_cities.php',
        success: function (res) {
            $('#cityFilter').html(res);
        }
    });
}

/* ================= LOAD SPORTS ================= */
function loadSports() {
    $.ajax({
        url: 'APIfetch_sports.php',
        success: function (res) {
            $('#sportFilter').html(res);
        }
    });
}

  </script><br><br><br><br><br>
  <?php include('../footer.php');?>
</body>
</html>