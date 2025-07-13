<!DOCTYPE html>
<html>
<head>
  <title>Elite Grounds</title>

  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">

  <style>
    body {
      background-color: #1A2730;
      color: white;
      font-family: Arial, sans-serif;
    }
    h2 {
      text-align: center;
      color: #E95D2C;
      margin-top: 20px;
    }
    .card {
      background-color: #22333B;
      color: #B0CEE2;
      border: 1px solid #B0CEE2;
    }
    .card-title {
      color: #E95D2C;
      text-align: center;
    }
    .card:hover {
      transform: scale(1.03);
      transition: 0.3s;
      box-shadow: 0 0 15px rgba(248, 245, 245, 0.89);
    }
    .btn-success {
      background-color: #28a745;
      border: none;
    }
    .btn-success:hover {
      background-color: #28a745;
      box-shadow: 0 0 8px #28a745;
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
          <img src="football.png" class="card-img-top" alt="Turf">
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
          <img src="football.png" class="card-img-top" alt="Turf">
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
          <img src="football.png" class="card-img-top" alt="Turf">
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
