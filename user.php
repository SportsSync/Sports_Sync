<!DOCTYPE html>
<html>
<head>
  <title>Elite Grounds</title>

  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">

  <style>
     :root {
      --bg-dark: #1C1C1C;
      --highlight: #D1FF71;
      --card-bg: #F7F6F2;
      --divider: #A9745B;
      --border: #BDBDBD;
    }
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
      color:  var(--highlight);
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
    .footer {
  background-color: #A9745B;
  color: #F7F6F2;
  padding: 60px 0 30px;
}

.footer a {
  color: #F7F6F2;
  text-decoration: none;
  transition: color 0.3s;
}

.footer a:hover {
  color: #D1FF71;
}

.footer-title {
  font-weight: 600;
  margin-bottom: 1rem;
  color: #1C1C1C;
}

.footer-description {
  font-size: 14px;
  line-height: 1.5;
  color: #F7F6F2;
}

.footer-links {
  list-style: none;
  padding: 0;
}

.footer-links li {
  margin-bottom: 8px;
}

.footer-divider {
  border-top: 1px solid #BDBDBD;
  margin: 2rem 0;
}

.footer-brand .brand-text {
  font-size: 24px;
  font-weight: bold;
  color: #1C1C1C;
}

.social-links a {
  margin-right: 10px;
  font-size: 18px;
  color: #F7F6F2;
}

.social-links a:hover {
  color: #D1FF71;
}

.footer p {
  margin: 0;
  font-size: 14px;
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

    <footer class="footer">
        <div class="container">
            <div class="row">
                <div class="col-md-4 mb-4">
                    <div class="footer-brand d-flex align-items-center mb-3">
                        <div class="brand-icon me-2">
                            <i class="bi bi-dribbble"></i>
                        </div>
                        <span class="brand-text">Sport Sync</span>
                    </div>
                    <p class="footer-description">
                        India's leading sports facility booking platform. Find and book premium turfs for all your sporting needs.
                    </p>
                    <div class="social-links">
                        <a href="#"><i class="bi bi-facebook"></i></a>
                        <a href="#"><i class="bi bi-twitter"></i></i></a>
                        <a href="#"><i class="bi bi-instagram"></i></a>
                        <a href="#"><i class="bi bi-facebook"></i></a>
                    </div>
                </div>
                <div class="col-md-2 mb-4">
                    <h6 class="footer-title">Platform</h6>
                    <ul class="footer-links">
                        <li><a href="#">Book Turf</a></li>
                        <li><a href="#">My Bookings</a></li>
                        <li><a href="#">Become Vendor</a></li>
                        <li><a href="#">Mobile App</a></li>
                    </ul>
                </div>
                <div class="col-md-2 mb-4">
                    <h6 class="footer-title">Sports</h6>
                    <ul class="footer-links">
                        <li><a href="#">Cricket</a></li>
                        <li><a href="#">Football</a></li>
                        <li><a href="#">Basketball</a></li>
                        <li><a href="#">Tennis</a></li>
                    </ul>
                </div>
                <div class="col-md-2 mb-4">
                    <h6 class="footer-title">Support</h6>
                    <ul class="footer-links">
                        <li><a href="#">Help Center</a></li>
                        <li><a href="#">Contact Us</a></li>
                        <li><a href="#">Terms of Service</a></li>
                        <li><a href="#">Privacy Policy</a></li>
                    </ul>
                </div>
                <div class="col-md-2 mb-4">
                    <h6 class="footer-title">Cities</h6>
                    <ul class="footer-links">
                        <li><a href="#">Bangalore</a></li>
                        <li><a href="#">Mumbai</a></li>
                        <li><a href="#">Delhi</a></li>
                        <li><a href="#">Chennai</a></li>
                    </ul>
                </div>
            </div>
            <hr class="footer-divider">
            <div class="row align-items-center">
                <div class="col-md-6">
                    <p class="footer-copyright">© 2024 TurfBook Pro. All rights reserved.</p>
                </div>
            </div>
        </div>
    </footer>



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
