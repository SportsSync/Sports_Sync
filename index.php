<?php
  session_start();
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
  <style>
  body { 
  background-color: #0e0f11; 
  background-image: linear-gradient(45deg, #1f1f1f 25%, transparent 25%), 
                    linear-gradient(-45deg, #1f1f1f 25%, transparent 25%), 
                    linear-gradient(45deg, transparent 75%, #1f1f1f 75%),
                    linear-gradient(-45deg, transparent 75%, #1f1f1f 75%); 
   background-size: 6px 6px; 
   background-position: 0 0, 0 3px, 3px -3px, -3px 0px; 
  } 
  .hero { 
    height: 70vh; 
    /* background-color: #000000;*/ 
    display: flex; 
    flex-direction: column; 
    justify-content: center; 
    align-items: center; 
    text-align: center; 
  }
   #sliderContainer { 
    width:100dvw; 
    max-width: 100%; 
    height: 80vh; 
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
    color: #e6eef7; 
    font-size: 2.5rem; 
    margin-bottom: 1rem; 
  } 
  .hero p { 
    color: #ffffff; 
  } 
  .hero .btn { 
    margin: 0.5rem; 
    background-color: transparent; 
    border: 2px solid #9526F3; 
    border-radius: 25px; 
    padding: 10px 26px; 
    color: #9526F3; 
    cursor: pointer; 
    position: relative; 
    overflow: hidden; 
    transition: color 0.35s ease, box-shadow 0.35s ease;
    outline: none; /* kills default focus glow */
  } 
  /* hover fill layer */ 
  .hero .btn::before { 
    content: ""; 
    position: absolute; 
    inset: 0;
    background: linear-gradient(
      135deg,
      #9526F3,
      #7a1fd6,
      #b44cff
    );
    transform: scaleX(0);
    transform-origin: left;
    transition: transform 0.4s ease;
    z-index: 0; 
  } 
  /* hover animation */ 
  .hero .btn:hover::before {
     transform: scaleX(1);
    } 
    .hero .btn:hover { 
      color: #f3f3f3;
      box-shadow: 0 0 18px rgba(149, 38, 243, 0.55);
    } 
    .hero .btn:focus,
    .hero .btn:active {
      outline: none;
      box-shadow: none;
    }
    /* keep text above animation */
     .hero .btn span {
       position: relative;
        z-index: 1; 
      } 
      .section-title { 
        color: #9526F3; 
        text-align: center;
         margin-bottom: 1.5rem; 
        } 
        .section-subtitle { 
          text-align: center; 
          color: #aaaaaa; 
          margin-bottom: 2rem;
         } 
         .sport-card {
           border: 1.5px solid rgba(149, 38, 243, 0.15);
            text-align: center;
            transition: 
              border-color 0.3s ease,
              box-shadow 0.3s ease,
              transform 0.2s ease;
           } 
           .sport-card i {
              color: #9526F3;
            }
          .sport-card:hover { 
            border-color: #9526F3;
            box-shadow: 0 12px 30px rgba(149, 38, 243, 0.25);
            transform: translateY(-4px);
            } 
            .stat-number { 
              font-size: 1.5rem; 
              color: #9526F3; 
            }
            
            .stat-label {
               color: #BDBDBD; 
              } 
              
              .highlight-game {
                color: #9526F3; 
                font-family: 'Sanchez', serif;
                font-weight: 400;
                font-style: italic;
                font-size: 1.05em; 
                letter-spacing: 0.5px; 
              } 
              .highlight-best {
                color: #e6eef7;
                font-family: 'Allura', cursive;
                font-weight: 400;
                letter-spacing: 0.2px;
              }
              .hero h1 { 
                color: #e6eef7; 
                font-size: clamp(1.8rem, 4vw, 3.5rem);
                line-height: 1.2;
                max-width: 900px;
                margin-bottom: 1rem; 
              } 
              .hero p {
                 color: #ffffff; 
                 font-size: clamp(0.95rem, 1.5vw, 1.15rem); 
                 line-height: 1.6;
                  max-width: 700px; 
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

  <section class="py-5 " data-aos="fade-up">
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
      const images = ["images/bg.jpeg", "images/bg1.jpeg", "images/bg2.jpeg", "images/bg3.jpeg", "images/bg4.jpeg"];
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
