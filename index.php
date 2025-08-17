<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Elite Grounds - Home</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.css">
  <link rel="stylesheet" href="https://unpkg.com/aos@2.3.4/dist/aos.css">
  <link rel="stylesheet" href="whole.css">
  <style>
    body {
      margin: 0;
      font-family: Arial, sans-serif;
      background-color: #1C1C1C;
      color: #F7F6F2;
    }
    .hero {
      height: 100vh;
      background-color: #1C1C1C;
      display: flex;
      flex-direction: column;
      justify-content: center;
      align-items: center;
      text-align: center;
    }
    .hero h1 {
      color: #D1FF71;
      font-size: 2.5rem;
      margin-bottom: 1rem;
    }
    .hero p {
      color: #BDBDBD;
    }
    .hero .btn {
      margin: 0.5rem;
    }
    .section-title {
      color: #D1FF71;
      text-align: center;
      margin-bottom: 1.5rem;
    }
    .section-subtitle {
      text-align: center;
      color: #BDBDBD;
      margin-bottom: 2rem;
    }
    .stat-number {
      font-size: 1.5rem;
      color: #D1FF71;
    }
    .stat-label {
      color: #BDBDBD;
    }
  </style>
</head>
<body onload="startSlider();">
    <nav class="navbar navbar-expand-lg navbar-dark bg-dark sticky-top">
  <div class="container-fluid">
    <a class="navbar-brand" href="index.php">SportsSync</a>
    <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav">
      <span class="navbar-toggler-icon"></span>
    </button>
    <div class="collapse navbar-collapse justify-content-end" id="navbarNav">
      <ul class="navbar-nav">
        <li class="nav-item">
          <a class="nav-link" href="signin.php">Login</a>
        </li>
        <li class="nav-item">
          <a class="nav-link" href="signup.php">Sign Up</a>
        </li>
      </ul>
    </div>
  </div>
</nav>
  <!-- Hero Section -->
  <section class="hero">
    <h1>Find the Best Grounds. Feel the Real Game</h1>
    <p>Game-ready grounds. Pro-level amenities. Real action.<br>Where passion meets performance.</p>
    <div>
      <a href="sidebar.php" class="btn btn-success">Book Turf</a>
      <a href="vendor.php" class="btn btn-success">Become Vendor</a>
    </div>
  </section>

  <!-- Slider -->
  <section class="container my-5" data-aos="fade-up">
    <img id="sliderImage" src="images/turf.jpg" class="img-fluid rounded shadow border border-light" alt="Slider">
  </section>

  <!-- Stats Section -->
  <section class="container text-center my-5" data-aos="fade-up">
    <div class="row">
      <div class="col-md-3">
        <i class="bi bi-trophy-fill fs-2 text-warning"></i>
        <div class="stat-number">500+</div>
        <div class="stat-label">Premium Turfs</div>
      </div>
      <div class="col-md-3">
        <i class="bi bi-people-fill fs-2 text-warning"></i>
        <div class="stat-number">50K+</div>
        <div class="stat-label">Happy Players</div>
      </div>
      <div class="col-md-3">
        <i class="bi bi-geo-alt-fill fs-2 text-warning"></i>
        <div class="stat-number">25+</div>
        <div class="stat-label">Cities Covered</div>
      </div>
      <div class="col-md-3">
        <i class="bi bi-star-fill fs-2 text-warning"></i>
        <div class="stat-number">4.8★</div>
        <div class="stat-label">Average Rating</div>
      </div>
    </div>
  </section>

  <!-- Sports Section -->
  <section class="py-5 bg-light text-dark" data-aos="fade-up">
    <div class="container">
      <h2 class="section-title">Explore Sports</h2>
      <p class="section-subtitle">From cricket to pickleball, find the perfect turf for your favorite sport</p>
      <div class="row text-center">
        <div class="col-6 col-md-4 col-lg-2 mb-4"><div class="p-3 bg-white rounded shadow">🏏<br>Cricket</div></div>
        <div class="col-6 col-md-4 col-lg-2 mb-4"><div class="p-3 bg-white rounded shadow">⚽<br>Football</div></div>
        <div class="col-6 col-md-4 col-lg-2 mb-4"><div class="p-3 bg-white rounded shadow">🏀<br>Basketball</div></div>
        <div class="col-6 col-md-4 col-lg-2 mb-4"><div class="p-3 bg-white rounded shadow">🏓<br>Pickleball</div></div>
        <div class="col-6 col-md-4 col-lg-2 mb-4"><div class="p-3 bg-white rounded shadow">🎾<br>Tennis</div></div>
        <div class="col-6 col-md-4 col-lg-2 mb-4"><div class="p-3 bg-white rounded shadow">🏸<br>Badminton</div></div>
      </div>
    </div>
  </section>

  <!-- Testimonials -->
  <section class="py-5 text-white" style="background: linear-gradient(135deg, #1C1C1C 0%, #111827 100%);" data-aos="fade-up">
    <div class="container">
      <h2 class="section-title">What Our Players Say</h2>
      <div class="row">
        <div class="col-md-4 mb-4">
          <div class="bg-dark rounded p-4 border">
            <p class="text-warning">★★★★★</p>
            <p>"TurfBook Pro made it easy to find and book grounds. Seamless process!"</p>
            <small>- Arjun Sharma, Cricket Enthusiast</small>
          </div>
        </div>
        <div class="col-md-4 mb-4">
          <div class="bg-dark rounded p-4 border">
            <p class="text-warning">★★★★★</p>
            <p>"Great platform with excellent turfs. Very reliable!"</p>
            <small>- Priya Singh, Football Player</small>
          </div>
        </div>
        <div class="col-md-4 mb-4">
          <div class="bg-dark rounded p-4 border">
            <p class="text-warning">★★★★★</p>
            <p>"As a coach, I book courts weekly. This site saves me time!"</p>
            <small>- Vikram Patel, Pickleball Coach</small>
          </div>
        </div>
      </div>
    </div>
  </section>

  <!-- How It Works -->
  <section class="py-5 bg-light text-dark" data-aos="fade-up">
    <div class="container">
      <h2 class="section-title">How It Works</h2>
      <p class="section-subtitle">Book your perfect turf in 3 steps</p>
      <div class="row text-center">
        <div class="col-md-4">
          <div class="p-3">
            <div class="display-4">🔍</div>
            <h5>Search & Filter</h5>
            <p>Find turfs by city, sport, and amenities.</p>
          </div>
        </div>
        <div class="col-md-4">
          <div class="p-3">
            <div class="display-4">📅</div>
            <h5>Select & Book</h5>
            <p>Pick time slot and complete booking.</p>
          </div>
        </div>
        <div class="col-md-4">
          <div class="p-3">
            <div class="display-4">🏆</div>
            <h5>Play & Enjoy</h5>
            <p>Get confirmation and play your sport!</p>
          </div>
        </div>
      </div>
    </div>
  </section>

  <?php include("footer.php"); ?>

  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
  <script src="https://unpkg.com/aos@2.3.4/dist/aos.js"></script>
  <script>
    AOS.init({ duration: 1000 });
    function startSlider() {
      const images = ["images/1.jpg", "images/2.jpeg", "images/3.jpg", "images/4.jpg", "images/turf.jpg"];
      let index = 0;
      setInterval(() => {
        document.getElementById("sliderImage").src = images[++index % images.length];
      }, 3000);
    }
  </script>
</body>
</html>
