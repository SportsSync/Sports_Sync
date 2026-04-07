<?php
  session_start();
  $defaultProfileImage = 'user/profile/default_avatar.jpg';
  $profileImage = $defaultProfileImage;

  if (!empty($_SESSION['profile_image']) && file_exists($_SESSION['profile_image'])) {
    $profileImage = $_SESSION['profile_image'];
  }
?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Elite Grounds - Home</title>
  <link rel="shortcut icon" href="favicon.png" type="image/png">
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.css">
  <link rel="stylesheet" href="https://unpkg.com/aos@2.3.4/dist/aos.css">
  <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@600;700&family=Allura&family=Sanchez:ital@1&display=swap" rel="stylesheet">
  <link rel="stylesheet" href="whole.css">
</head>
<body onload="startSlider();">
<nav class="navbar navbar-expand-lg navbar-dark bg-dark sticky-top">
  <div class="container-fluid">
    
    <a class="navbar-brand" href="index.php">SportsSync</a>

    <!-- ✅ TOGGLER (THIS WAS MISSING) -->
    <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav">
      <span class="navbar-toggler-icon"></span>
    </button>

    <!-- MENU -->
    <div class="collapse navbar-collapse justify-content-end" id="navbarNav">
      <ul class="navbar-nav">
        <?php if (isset($_SESSION['email'])): ?>
          <li class="nav-item">
            <a class="nav-link py-0 d-flex align-items-center" href="user/user_settings.php" aria-label="Profile">
              <img
                src="<?php echo htmlspecialchars($profileImage); ?>"
                alt="Profile"
                class="navbar-profile-photo"
              >
            </a>
          </li>
          <li class="nav-item">
            <a class="nav-link" href="logout.php">Logout</a>
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
    <h1>
      Find the <span class="highlight-best">Best Grounds</span>. Feel the </br>
    <span class="highlight-game">Real Game</span>
    </h1>
    <p>Game-ready grounds. Pro-level amenities. Real action.<br>Where passion meets performance.</p>
    <div>
      <a href="user/navbar.php" class="btn btn-success"><span>Book Turf</span></a>
      <a href="
      <?php 
        if(!isset($_SESSION["role"])){
            echo "signin.php";
        }else{
          if($_SESSION["role"] == "User"){
            echo "requestToBeVendor.php";
          }else{
            echo "owner/owner.php";
          }
        }
      ?>
      " class="btn btn-success" id="becomeVendorBtn"><?php if(!isset($_SESSION["role"]) || $_SESSION["role"] == "User"){
            echo "<span>Become a Vendor</span>";
          }else{
            echo "<span>Vendor Panel<span>";
          }?>
</a>
    </div>
  </section>

  <!-- Slider -->
  <section class="container my-5" data-aos="fade-up">
    <div id="sliderContainer" class="rounded overflow-hidden">
      <img id="sliderImage" src="images/newbg2.jpg" class="slider-img" alt="Slider">
    </div>
  </section>


  <!-- Stats Section -->
  <section class="container text-center my-5" data-aos="fade-up">
    <div class="row">
      <div class="col-md-3">
        <i class="bi bi-trophy-fill fs-2 text-white"></i>
        <div class="stat-number">500+</div>
        <div class="stat-label">Premium Turfs</div>
      </div>
      <div class="col-md-3">
        <i class="bi bi-people-fill fs-2 text-white"></i>
        <div class="stat-number">50K+</div>
        <div class="stat-label">Happy Players</div>
      </div>
      <div class="col-md-3">
        <i class="bi bi-geo-alt-fill fs-2 text-white"></i>
        <div class="stat-number">25+</div>
        <div class="stat-label">Cities Covered</div>
      </div>
      <div class="col-md-3">
        <i class="bi bi-star-fill fs-2 text-white"></i>
        <div class="stat-number">4.8</div>  
        <div class="stat-label">Average Rating</div>
      </div>
    </div>
  </section>

  <!-- Sports Section -->

  <section class="py-5 " data-aos="fade-up">
    <div class="container">
      <h2 class="section-title">Explore Sports</h2>
      <p class="section-subtitle">From cricket to pickleball, find the perfect turf for your favorite sport</p>
      <div class="row text-center">
        <div class="col-6 col-md-4 col-lg-2 mb-4" data-aos="zoom-in" data-aos-delay="0">
          <div class="sport-card">
            <i class="bi bi-activity fs-1 mb-2"></i><br>Cricket
          </div>
        </div>
        <div class="col-6 col-md-4 col-lg-2 mb-4" data-aos="zoom-in" data-aos-delay="100">
          <div class="sport-card">
            <i class="bi bi-dribbble fs-1 mb-2"></i><br>Football
          </div>
        </div>
        <div class="col-6 col-md-4 col-lg-2 mb-4" data-aos="zoom-in" data-aos-delay="200">
          <div class="sport-card">
            <i class="bi bi-basket2-fill fs-1 mb-2"></i><br>Basketball
          </div>
        </div>
        <div class="col-6 col-md-4 col-lg-2 mb-4" data-aos="zoom-in" data-aos-delay="300">
          <div class="sport-card">
            <i class="bi bi-record-circle fs-1 mb-2"></i><br>Pickleball
          </div>
        </div>
        <div class="col-6 col-md-4 col-lg-2 mb-4" data-aos="zoom-in" data-aos-delay="400">
          <div class="sport-card">
            <i class="bi bi-circle-half fs-1 mb-2"></i><br>Tennis
          </div>
        </div>
        <div class="col-6 col-md-4 col-lg-2 mb-4" data-aos="zoom-in" data-aos-delay="500">
          <div class="sport-card">
            <i class="bi bi-wind fs-1 mb-2"></i><br>Badminton
          </div>
        </div>
      </div>
    </div>
  </section>

  <!-- Testimonials -->
  <section class="py-5" data-aos="fade-up">
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
  <section class="py-5" data-aos="fade-up">
    <div class="container">
      <h2 class="section-title">How It Works</h2>
      <p class="section-subtitle">Book your perfect turf in 3 steps</p>
      <div class="row text-center">
        <div class="col-md-4">
          <div class="p-1 bg-dark">
            <div class="display-4">🔍</div>
            <h5>Search & Filter</h5>
            <p>Find Turfs by City, Sport, and Amenities.</p>
          </div>
        </div>
        <div class="col-md-4">
          <div class="p-1 bg-dark">
            <div class="display-4">📅</div>
            <h5>Select & Book</h5>
            <p>Pick Time Slot and Complete Booking.</p>
          </div>
        </div>
        <div class="col-md-4">
          <div class="p-1 bg-dark">
            <div class="display-4">🏆</div>
            <h5>Play & Enjoy</h5>
            <p>Get Confirmation and Play your Sport!</p>
          </div>
        </div>
      </div>
    </div>
  </section>
  <div id="loginPopup" style="
  display:none;
  position:fixed;
  inset:0;
  background:rgba(0,0,0,0.7);
  backdrop-filter:blur(4px);
  z-index:9999;
  align-items:center;
  justify-content:center;
">
  <div style="
    background:#111;
    padding:30px 40px;
    border-radius:16px;
    text-align:center;
    box-shadow:0 0 25px rgba(255,193,7,0.4);
  ">
    <h5 style="color:#ffc107;">Login Required</h5>
    <p style="color:#ccc;margin:0;">
      Please sign in before becoming a vendor
    </p>
  </div>
</div>

  <?php include("footer.php"); ?>

  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
  <script src="https://unpkg.com/aos@2.3.4/dist/aos.js"></script>
  <script>
    AOS.init({ duration: 1000 });
    function startSlider() {
      // Best result: use landscape images close to 1600x900 (16:9 ratio).
      const images = ["images/newbg1.jpg", "images/newbg2.jpg", "images/newbg3.jpg", "images/newbg4.jpg", "images/newbg5.jpg"];
      let index = 0;
      setInterval(() => {
        document.getElementById("sliderImage").src = images[++index % images.length];
      }, 2000);
    }
  document.getElementById("becomeVendorBtn").addEventListener("click", function(e) {

  <?php if(!isset($_SESSION["role"])): ?>
    e.preventDefault();

    const popup = document.getElementById("loginPopup");
    popup.style.display = "flex";

    let redirected = false;

    function goToSignin() {
      if (redirected) return;
      redirected = true;
      window.location.replace("signin.php");
    }

    // Auto redirect after 1.5 sec
    const timer = setTimeout(goToSignin, 1000);

    // Redirect on ANY key press
    document.addEventListener("keydown", function handler() {
      clearTimeout(timer);
      document.removeEventListener("keydown", handler);
      goToSignin();
    });

  <?php endif; ?>

});

// Hide popup when page is restored (back button fix) 
window.addEventListener("pageshow", function () {
  const popup = document.getElementById("loginPopup");
  if (popup) popup.style.display = "none";
});
</script>

</body>
</html>
