<?php
  session_start();
  if (isset($_GET['logout'])) {
    session_destroy();
    header("Location: index.php");
    exit();
  }
?>
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
    #sliderContainer {
      width: 100%;
      max-width: 100%;
      height: 500px; 
      display: flex;
      justify-content: center;
      align-items: center;
      background-color: #000;
      border-radius: 10px;
      overflow: hidden;
    }

    .slider-img {
      width: 100%;
      height: 100%;
      object-fit: cover; 
      transition: opacity 0.5s ease-in-out;
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
    .sport-card {
      transition: transform 0.3s ease, box-shadow 0.3s ease;
      cursor: pointer;
    }

    .sport-card:hover {
      transform: translateY(-8px) scale(1.05);
      box-shadow: 0 12px 25px rgba(0, 0, 0, 0.2);
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
    <div class="collapse navbar-collapse justify-content-end" id="navbarNav">
      <ul class="navbar-nav">
        <?php if (isset($_SESSION['email'])): ?>
          <li class="nav-item">
            <span class="nav-link text-success">
              <?php echo htmlspecialchars($_SESSION['email']); ?>
            </span>
          </li>
          <li class="nav-item">
            <a class="nav-link" href="index.php?logout=1">Logout</a>
          </li>
        <?php else: ?>
          <li class="nav-item">
            <a class="nav-link" href="signin.php">Login</a>
          </li>
          <li class="nav-item">
            <a class="nav-link" href="signup.php">Sign Up</a>
          </li>
        <?php endif; ?>
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
    <div id="sliderContainer" class="rounded overflow-hidden">
      <img id="sliderImage" src="images/turf.jpg" class="slider-img" alt="Slider">
    </div>
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
        <div class="col-6 col-md-4 col-lg-2 mb-4" data-aos="zoom-in" data-aos-delay="0">
          <div class="p-3 bg-white rounded shadow sport-card text-dark">
            <i class="bi bi-activity fs-1 text-success mb-2"></i><br>Cricket
          </div>
        </div>
        <div class="col-6 col-md-4 col-lg-2 mb-4" data-aos="zoom-in" data-aos-delay="100">
          <div class="p-3 bg-white rounded shadow sport-card text-dark">
            <i class="bi bi-dribbble fs-1 text-success mb-2"></i><br>Football
          </div>
        </div>
        <div class="col-6 col-md-4 col-lg-2 mb-4" data-aos="zoom-in" data-aos-delay="200">
          <div class="p-3 bg-white rounded shadow sport-card text-dark">
            <i class="bi bi-basket2-fill fs-1 text-success mb-2"></i><br>Basketball
          </div>
        </div>
        <div class="col-6 col-md-4 col-lg-2 mb-4" data-aos="zoom-in" data-aos-delay="300">
          <div class="p-3 bg-white rounded shadow sport-card text-dark">
            <i class="bi bi-record-circle fs-1 text-success mb-2"></i><br>Pickleball
          </div>
        </div>
        <div class="col-6 col-md-4 col-lg-2 mb-4" data-aos="zoom-in" data-aos-delay="400">
          <div class="p-3 bg-white rounded shadow sport-card text-dark">
            <i class="bi bi-circle-half fs-1 text-success mb-2"></i><br>Tennis
          </div>
        </div>
        <div class="col-6 col-md-4 col-lg-2 mb-4" data-aos="zoom-in" data-aos-delay="500">
          <div class="p-3 bg-white rounded shadow sport-card text-dark">
            <i class="bi bi-wind fs-1 text-success mb-2"></i><br>Badminton
          </div>
        </div>
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
      const images = ["images/bg.jpeg", "images/bg1.jpeg", "images/bg2.jpeg", "images/bg3.jpeg", "images/bg4.jpeg"];
      let index = 0;
      setInterval(() => {
        document.getElementById("sliderImage").src = images[++index % images.length];
      }, 2000);
    }
  </script>
</body>
</html>
