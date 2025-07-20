<!DOCTYPE html>
<html>
<head>
  <title>Elite Grounds</title>
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.css">
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
  <link href="whole.css" rel="stylesheet">
  <style>
      body {
     background-color: var(--bg-dark);
      color: var(--card-bg);
      font-family: Arial, sans-serif;
       padding-inline: 1rem;
    }
    h2 {
      text-align: center;
      color: var(--highlight);
      margin-top: 20px;
      border-bottom: 2px solid var(--divider);
      padding-bottom: 10px;
    }
     .form-select {
      background-color: var(--card-bg);
      color: var(--bg-dark);
      border: 1px solid var(--border);
    }

    .form-select:focus {
      border-color: var(--highlight);
      box-shadow: 0 0 5px var(--highlight);
    }
    .card {
       background-color: var(--card-bg);
      color: var(--bg-dark);
      border: 1px solid var(--divider);
      transition: transform 0.3s, box-shadow 0.3s;
    }
    .card-title {
      color:  #c8581fff;
      text-align: center;
    }
    .card:hover {
      transform: scale(1.03);
      transition: 0.3s;
      box-shadow: 0 0 15px  var(--highlight);
    }
    .btn-success {
       background-color: var(--highlight);
      color: var(--bg-dark);
      border: none;
    }
    .btn-success:hover {
      background-color: var(--highlight);
      box-shadow: 0 0 8px var(--highlight);
      color: var(--bg-dark);
    }

  </style>
</head>
<body>

  <div class="container">
    <h2>Elite Grounds</h2>

    <div class="row my-4 justify-content-center">
      <div class="col-md-3">
        <select id="locationFilter" class="form-select">
          <option value="all">All Locations</option>
          <option value="surat">Surat</option>
          <option value="mumbai">Mumbai</option>
        </select>
      </div>
      <div class="col-md-3">
        <select id="sportFilter" class="form-select">
          <option value="all">All Sports</option>
          <option value="football">Football</option>
          <option value="cricket">Cricket</option>
          <option value="pickleball">Pickleball</option>
        </select>
      </div>
    </div>


    <div class="row">


      <div class="col-md-4 mb-4 turf-card">
        <div class="card">
          <img src="images/football.png" class="card-img-top" alt="Turf">
          <div class="card-body">
            <h5 class="card-title">Green Turf Arena</h5>
            <p class="card-text" data-location="surat" data-sport="football">
              Location: Surat<br>Sport: Football
            </p>
            <div class="text-center">
              <a href="#" class="btn btn-success">Book Now</a>
            </div>
          </div>
        </div>
      </div>

      <div class="col-md-4 mb-4 turf-card">
        <div class="card">
          <img src="images/football.png" class="card-img-top" alt="Turf">
          <div class="card-body">
            <h5 class="card-title">VR Turf Arena</h5>
            <p class="card-text" data-location="surat" data-sport="cricket">
              Location: Surat<br>Sport: Cricket
            </p>
            <div class="text-center">
              <a href="#" class="btn btn-success">Book Now</a>
            </div>
          </div>
        </div>
      </div>

      <div class="col-md-4 mb-4 turf-card">
        <div class="card">
          <img src="images/football.png" class="card-img-top" alt="Turf">
          <div class="card-body">
            <h5 class="card-title">Kraves Turf Arena</h5>
            <p class="card-text" data-location="mumbai" data-sport="pickleball">
              Location: Mumbai<br>Sport: Pickleball
            </p>
            <div class="text-center">
              <a href="#" class="btn btn-success">Book Now</a>
            </div>
          </div>
        </div>
      </div>

    </div>
  </div>
    <?php
         include("footer.php");
      ?>

  <script>
    const locationFilter = document.getElementById("locationFilter");
    const sportFilter = document.getElementById("sportFilter");

    locationFilter.addEventListener("change", filterCards);
    sportFilter.addEventListener("change", filterCards);

    function filterCards() {
      const selectedLocation = locationFilter.value;
      const selectedSport = sportFilter.value;

      const cards = document.getElementsByClassName("turf-card");

      for (let i = 0; i < cards.length; i++) {
        const card = cards[i];
        const pTag = card.querySelector(".card-text");

        const location = pTag.getAttribute("data-location");
        const sport = pTag.getAttribute("data-sport");

        const matchLocation = (selectedLocation === "all" || selectedLocation === location);
        const matchSport = (selectedSport === "all" || selectedSport === sport);

        if (matchLocation && matchSport) {
          card.style.display = "block";
        } else {
          card.style.display = "none";
        }
      }
    }
  </script>

</body>
</html>
