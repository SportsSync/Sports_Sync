<?php
  session_start();
  include('db.php');

  $defaultProfileImage = 'user/profile/default_avatar.jpg';
  $profileImage = $defaultProfileImage;

  if (!empty($_SESSION['profile_image']) && file_exists($_SESSION['profile_image'])) {
    $profileImage = $_SESSION['profile_image'];
  }
?>

<?php
include('db.php');
if (isset($_SESSION['email']))
  {
      $user_id = $_SESSION["user_id"];

      $stmt = $conn->prepare("SELECT COUNT(*) as total FROM notifications WHERE user_id = ?");
      $stmt->bind_param("i", $user_id);
      $stmt->execute();
      $result1 = $stmt->get_result();
      $count = $result1->fetch_assoc()['total'];

      $stmt = $conn->prepare("SELECT * FROM notifications WHERE user_id = ? ORDER BY created_at DESC");
      $stmt->bind_param("i", $user_id);
      $stmt->execute();
      $result = $stmt->get_result();

      if (isset($_POST['clear_all'])) {
          $stmt1 = $conn->prepare("DELETE FROM notifications WHERE user_id = ?");
          $stmt1->bind_param("i", $user_id);
          $stmt1->execute();

          // refresh page to update UI
          header("Location: " . $_SERVER['PHP_SELF']);
          exit();
        }
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
<style>
html {
    scroll-behavior: smooth;
}
/* 🔔 Notification Button */
.notif-btn {
    position: relative;
    display: inline-block;
    color: white;
    font-size: 22px;
    cursor: pointer;
    transition: 0.3s;
}

.notif-btn:hover {
    color: #a855f7;
    transform: scale(1.1);
}

/* 🔴 Badge */
.notif-badge {
    position: absolute;
    top: -6px;
    right: -10px;

    background: linear-gradient(135deg, #ff3b3b, #ff6b6b);
    color: white;

    font-size: 10px;
    font-weight: bold;

    padding: 3px 7px;
    border-radius: 50px;

    min-width: 18px;
    text-align: center;

    box-shadow: 0 0 8px rgba(255, 59, 59, 0.7);
}

/* 📩 Sidebar */
.notif-sidebar {
    position: fixed;
    top: 0;
    right: -380px;
    width: 360px;
    height: 100%;

    background: rgba(15, 15, 20, 0.95);
    backdrop-filter: blur(12px);

    box-shadow: -10px 0 25px rgba(0,0,0,0.8);
    border-left: 1px solid rgba(168, 85, 247, 0.2);

    transition: 0.35s ease;
    z-index: 9999;

    display: flex;
    flex-direction: column;
}

.notif-sidebar.active {
    right: 0;
}

/* Header */
.notif-header {
    display: flex;
    justify-content: space-between;
    align-items: center;

    padding: 16px;

    border-bottom: 1px solid rgba(255,255,255,0.05);
    color: white;

    font-size: 18px;
    font-weight: 600;
}

/* Close Button */
.notif-header button {
    background: none;
    border: none;
    color: #aaa;
    font-size: 18px;
    cursor: pointer;
    transition: 0.2s;
}

.notif-header button:hover {
    color: #ff3b3b;
}

/* Content */
.notif-content {
    padding: 15px;
    overflow-y: auto;
}

/* Items */
.notif-item {
    background: linear-gradient(145deg, #1a1a22, #121218);
    padding: 12px;
    border-radius: 12px;
    margin-bottom: 12px;

    border: 1px solid rgba(255,255,255,0.05);

    transition: 0.25s;
}

.notif-item:hover {
    border-color: rgba(168, 85, 247, 0.5);
    box-shadow: 0 0 10px rgba(168, 85, 247, 0.3);
}

/* Text */
.notif-item p {
    margin: 0;
    color: #e5e5e5;
    font-size: 14px;
}

/* Time */
.time {
    font-size: 11px;
    color: #888;
    margin-top: 5px;
}

/* Empty State */
.empty {
    text-align: center;
    color: #777;
    margin-top: 30px;
    font-size: 14px;
}

.clear-btn {
    width: 100%;
    padding: 10px;

    background: linear-gradient(135deg, #7c3aed, #a855f7);
    color: white;

    border: none;
    border-radius: 10px;

    font-size: 14px;
    font-weight: 600;

    cursor: pointer;
    transition: 0.3s ease;

    box-shadow: 0 0 10px rgba(168, 85, 247, 0.4);
}

/* Hover */
.clear-btn:hover {
    transform: translateY(-2px);
    box-shadow: 0 0 18px rgba(168, 85, 247, 0.7);
}

/* Click */
.clear-btn:active {
    transform: scale(0.97);
}

.navbar-center-links .nav-link {
    font-weight: 500;
}

.smart-navbar {
    top: 0;
    margin: 0 auto;
    width: 100%;
    padding: 0.85rem 1rem;
    background: rgba(13, 13, 16, 0.96) !important;
    border-bottom: 1px solid rgba(255, 255, 255, 0.04);
    transition: width 0.35s ease, margin-top 0.35s ease, border-radius 0.35s ease,
        background-color 0.35s ease, box-shadow 0.35s ease, backdrop-filter 0.35s ease,
        transform 0.35s ease;
}

.smart-navbar .navbar-brand,
.smart-navbar .nav-link,
.smart-navbar .navbar-toggler {
    transition: color 0.3s ease, opacity 0.3s ease;
}

.smart-navbar.is-floating {
    top: 12px;
    width: min(96%, 1280px);
    margin-top: 14px;
    border-radius: 22px;
    background: rgba(239, 236, 229, 0.88) !important;
    backdrop-filter: blur(18px);
    -webkit-backdrop-filter: blur(18px);
    box-shadow: 0 18px 40px rgba(0, 0, 0, 0.18);
    border: 1px solid rgba(255, 255, 255, 0.45);
}

.smart-navbar.is-floating .navbar-brand,
.smart-navbar.is-floating .nav-link,
.smart-navbar.is-floating .notif-btn,
.smart-navbar.is-floating .navbar-toggler {
    color: #141414 !important;
}

.smart-navbar.is-floating .notif-btn:hover,
.smart-navbar.is-floating .nav-link:hover,
.smart-navbar.is-floating .navbar-brand:hover {
    color: #5d28c6 !important;
}

.smart-navbar.is-floating .navbar-toggler-icon {
    filter: invert(1);
}

.about-us-image-placeholder {
    min-height: 320px;
    border-radius: 20px;
    overflow: hidden;
    background: rgba(255, 255, 255, 0.04);
}

.about-us-image-placeholder img {
    width: 100%;
    height: 100%;
    min-height: 320px;
    object-fit: cover;
    display: block;
}

@media (min-width: 992px) {
    .navbar .container-fluid {
        position: relative;
    }

    .navbar-center-links {
        position: absolute;
        left: 50%;
        transform: translateX(-50%);
    }
}

@media (max-width: 991.98px) {
    .smart-navbar {
        width: 100%;
        margin-top: 0;
        border-radius: 0;
    }

    .smart-navbar.is-floating {
        width: calc(100% - 20px);
        margin-top: 10px;
        border-radius: 18px;
    }
}
  </style>
<body onload="startSlider();">
<nav id="mainNavbar" class="navbar navbar-expand-lg navbar-dark bg-dark sticky-top smart-navbar">
  <div class="container-fluid">

    <a class="navbar-brand" href="index.php">SportsSync</a>

    <!-- TOGGLER -->
    <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav">
      <span class="navbar-toggler-icon"></span>
    </button>

    <!-- MENU -->
    <div class="collapse navbar-collapse" id="navbarNav">
      <?php if (isset($_SESSION['email'])): ?>
        <ul class="navbar-nav navbar-center-links mx-auto align-items-center gap-lg-4">
          <li class="nav-item">
            <a class="nav-link" href="#about-us">About Us</a>
          </li>
          <li class="nav-item">
            <a class="nav-link" href="#explore">Explore</a>
          </li>
          <li class="nav-item">
            <a class="nav-link" href="#contact-us">Contact Us</a>
          </li>
        </ul>
      <?php endif; ?>

      <ul class="navbar-nav align-items-center gap-3 ms-lg-auto">

        <?php if (isset($_SESSION['email'])): ?>

          <!-- 🔔 Notification -->
          <li class="nav-item">
            <a href="#" class="notif-btn" onclick="openSidebar(); return false;">
              <i class="bi bi-bell-fill"></i>

              <?php if ($count > 0): ?>
                <span class="notif-badge">
                  <?php echo ($count > 99) ? '99+' : $count; ?>
                </span>
              <?php endif; ?>
            </a>
          </li>

          <!-- 👤 Profile -->
          <li class="nav-item">
            <a class="nav-link p-0" href="user/user_settings.php">
              <img src="<?php echo htmlspecialchars($profileImage); ?>" 
                   class="navbar-profile-photo">
            </a>
          </li>

          <!-- 🚪 Logout -->
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

  <!-- About Us Section -->
  <section class="container my-5 py-4" id="about-us" data-aos="fade-up">
    <h2 class="section-title">About Us</h2>
    <div class="row align-items-center g-4">
      <div class="col-lg-6">
        <div class="about-us-image-placeholder">
          <img src="images/newbg3.jpg" alt="About Us">
        </div>
      </div>
      <div class="col-lg-6">
        <p class="text-light">
          We built SportSync because booking a turf was always frustrating-missed calls, double bookings, and ruined plans.
          Instead of just complaining, the five of us decided to fix it ourselves.
        </p>
        <p class="text-light">
          SportSync is our simple attempt to make booking easy and reliable.
          It's not perfect, but it's real and built from our own experience.
        </p>
      </div>
    </div>
  </section>

  <!-- Sports Section -->

  <section class="py-5 " id="explore" data-aos="fade-up">
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
  background:#000000b3;
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
    box-shadow:0 0 25px #9526f359;
  ">
    <h5 style="color:#9526F3;">Login Required</h5>
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

function openSidebar() {
    document.getElementById("notifSidebar").classList.add("active");
}

function closeSidebar() {
    document.getElementById("notifSidebar").classList.remove("active");
}

const mainNavbar = document.getElementById("mainNavbar");

function updateFloatingNavbar() {
    if (!mainNavbar) return;

    if (window.scrollY > 40) {
        mainNavbar.classList.add("is-floating");
    } else {
        mainNavbar.classList.remove("is-floating");
    }
}

updateFloatingNavbar();
window.addEventListener("scroll", updateFloatingNavbar, { passive: true });
</script>
<?php if (isset($_SESSION['email'])): ?>
<div id="notifSidebar" class="notif-sidebar">

    <div class="notif-header">
        <h3>Notifications</h3>
        <button onclick="closeSidebar()">✖</button>
    </div>

    <div id="notifContent" class="notif-content">

<?php if ($result->num_rows > 0): ?>
    <?php while ($row = $result->fetch_assoc()): ?>
        <div class="notif-item">
          <p style="font-size:25px; color:#9526f359; text-align:left;">
              <?php echo htmlspecialchars($row['title']); ?>
          </p><br>
            <p style = "text-align:left;"><?php echo $row['message']; ?></p>
            <span class="time"><?php echo $row['created_at']; ?></span>
        </div>
    <?php endwhile; ?>
    <?php if ($result->num_rows > 0): ?>
    <form method="POST" style="margin-top: 15px;">
        <button type="submit" name="clear_all" class="clear-btn">
            Clear All
        </button>
    </form>
<?php endif; ?>
<?php else: ?>
    <p class="empty">No notifications</p>
<?php endif; ?>
  <?php endif; ?>

</div>

</div>
</body>
</html>
