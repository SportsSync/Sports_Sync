<?php
session_start();
$conn = new mysqli("localhost:3306","root","","turf_booking_system");

$turf_id = $_GET['turf_id'];
?>

<?php
include('../db.php');

if (!isset($_GET['turf_id'])) {
    die('Invalid request');
}

$turf_id = (int) $_GET['turf_id'];
$fromVendor = isset($_GET['from']) && $_GET['from'] === 'vendor';

/* TURF BASIC INFO */
$sql = "
SELECT 
  t.turf_name,
  t.location,
  t.latitude,
  t.longitude,
  t.description,
  c.city_name
FROM turftb t
LEFT JOIN citytb c ON c.city_id = t.city_id
WHERE t.turf_id = $turf_id
LIMIT 1
";
$res = mysqli_query($conn, $sql);
$turf = mysqli_fetch_assoc($res);
if (!$turf)
    die('Turf not found');

/* IMAGES */
$imgRes = mysqli_query(
    $conn,
    "SELECT image_path FROM turf_imagestb WHERE turf_id=$turf_id"
);

/* SPORTS */
$sportRes = mysqli_query($conn, "
SELECT s.sport_name, ts.no_of_courts
FROM turf_sportstb ts
JOIN sportstb s ON s.sport_id = ts.sport_id
WHERE ts.turf_id=$turf_id
");

/* AMENITIES */
$amenRes = mysqli_query($conn, "
SELECT a.amenity_name
FROM turf_amenitiestb ta
JOIN amenitiestb a ON a.amenity_id = ta.amenity_id
WHERE ta.turf_id=$turf_id
");

$reviewRes = mysqli_query($conn, "
SELECT * FROM turf_reviews
WHERE turf_id = $turf_id 
");


?>
<?php
$name = isset($_SESSION['username']) ? $_SESSION['username'] : "";
$aboutItems = preg_split('/\r\n|\r|\n/', trim((string) $turf['description']));
$aboutItems = array_values(array_filter(array_map('trim', $aboutItems), function ($item) {
    return $item !== '';
}));

if (count($aboutItems) <= 1 && !empty($aboutItems)) {
    $aboutItems = preg_split('/(?<=[.!?])\s+/', $aboutItems[0]);
    $aboutItems = array_values(array_filter(array_map('trim', $aboutItems), function ($item) {
        return $item !== '';
    }));
}
?>
<!DOCTYPE html>
<html>
<head>
<title><?= htmlspecialchars($turf['turf_name']) ?></title>

<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
<link href="../whole.css" rel="stylesheet">

<style>
:root {
  --bg-dark: #121212;
  --card-bg: #1a1a1a;
  --highlight: #9526F3;
  --accent: #b44cff;
  --text-light: #f2f2f2;
  --muted-text: #b5b5b5;
  --border-soft: #9526f38c;
}
/* STICKY TOP BAR */
.top-bar {
  position: sticky;
  top: 0;
  z-index: 50;
  background: linear-gradient(
    to bottom,
    rgba(18,18,18,0.95),
    rgba(18,18,18,0.7),
    transparent
  );
  padding: 14px 0;
  backdrop-filter: blur(6px);
}
.top-bar-row {
  display: flex;
  align-items: center;
  gap: 14px;
}
.top-title {
  flex: 1;
  text-align: center;
  margin: 0;
  color: var(--text-light);
  font-weight: 800;
  font-size: 1.15rem;
  letter-spacing: 0.4px;
}
/* BACK BUTTON (SHARED THEME) */
.back-btn {
  display: inline-flex;
  align-items: center;
  gap: 6px;
  padding: 6px 16px;
  border-radius: 999px;
  border: 1.5px solid var(--highlight);
  background: transparent;
  color: var(--highlight);
  font-size: 14px;
  font-weight: 600;
  cursor: pointer;
  transition: all 0.18s ease;
}

.back-btn:hover {
  background: #9526f38c;
}

.back-btn:active {
  transform: scale(0.96);
}


/* =======================
   GLOBAL
======================= */
body {
  background: var(--bg-dark);
  color: var(--text-light);
  font-family: 'Segoe UI', system-ui, sans-serif;
  overflow-x: hidden;
  margin-left: 2%;
}

.container-xl {
  max-width: 1200px;
}

/* =======================
   HERO
======================= */
.hero {
  position: relative;
  border-radius: 24px;
  overflow: hidden;
  box-shadow: 0 25px 60px rgba(0,0,0,.65);
}

.hero-img {
  height: 480px;
  object-fit: cover;
  transition: transform 0.6s ease;
}

.carousel-item.active .hero-img {
  transform: scale(1.05);
}

.hero-overlay {
  position: absolute;
  inset: 0;
  background: linear-gradient(
    to top,
    rgba(0,0,0,.9),
    rgba(0,0,0,.35)
  );
}

.hero-info {
  position: absolute;
  bottom: 40px;
  left: 40px;
  z-index: 2;
}

.hero-info h1 {
  color: var(--highlight);
  font-weight: 900;
  font-size: 3rem;
  letter-spacing: 1px;
  text-shadow: 0 6px 15px rgba(0,0,0,.7);
}

.hero-info p {
  color: #ddd;
  font-size: 1.1rem;
  margin-top: 8px;
  display: flex;
  align-items: center;
  gap: 6px;
}

.directions-btn {
  background: #9526F3;
  border: 1px solid #9526F3;
  color: #fff;
}

.directions-btn:hover,
.directions-btn:focus {
  background: #7f1fe0;
  border-color: #7f1fe0;
  color: #fff;
}

/* =======================
   SECTION TITLES
======================= */
.section {
  margin-top: 80px;
  position: relative;
}

.section h3 {
  font-weight: 700;
  margin-bottom: 28px;
  font-size: 1.9rem;
  color: #fff;
  position: relative;
}

.section h3::after {
  content: '';
  position: absolute;
  bottom: -8px;
  left: 0;
  width: 50px;
  height: 4px;
  background: var(--highlight);
  border-radius: 4px;
}

/* =======================
   SPORTS
======================= */
.sport-card {
  background: #1a1a1a;
  border: 1px solid var(--border-soft);
  border-radius: 18px;
  padding: 28px;
  text-align: center;
  transition: all 0.4s ease;
  cursor: pointer;
  position: relative;
  overflow: hidden;
}

.sport-card::before {
  content: '';
  position: absolute;
  inset: 0;
  background: none;
}


.sport-card:hover::before {
  opacity: 1;
}

.sport-card:hover {
  transform: translateY(-4px);
  box-shadow:
    0 0 0 1px #9526f38c,
    0 0 18px #9526f38c;
}


.sport-card h5 {
  color: var(--highlight);
  font-size: 1.3rem;
  margin-bottom: 16px;
}

.courts {
  display: flex;
  justify-content: center;
  gap: 12px;
  flex-wrap: wrap;
  background: transparent;   
  border: none;              
  padding: 4px 0;
}


.court {
  width: 64px;
  padding: 12px 0;
  border-radius: 14px;
  background: #1f1f1f;
  color: var(--highlight);
  font-weight: 700;
  border: 1px solid #2c2c2c;
  transition: all 0.3s ease;
  box-shadow: inset 0 0 0 1px rgba(255,255,255,0.06);
}

.court:hover {
  background: var(--highlight);
  color: #111;
  transform: translateY(-2px) scale(1.05);
  box-shadow: 0 6px 14px #9526f38c;
}
.sport-card h5 {
  margin-bottom: 20px;
}


/* =======================
   AMENITIES
======================= */
.amenities {
  display: flex;
  flex-wrap: wrap;
  gap: 14px;
}

.amenity {
  padding: 12px 20px;
  border-radius: 28px;
    background: #1f1f1f;
  border: 1px solid var(--border-soft);
  font-weight: 500;
  transition: all 0.3s ease;
  position: relative;
}

.amenity::before {
  content: "✓";
  color: var(--highlight);
  margin-right: 6px;
}

.amenity:hover {
  background: #1a1a1a;
  color: var(--highlight);
  box-shadow:
    0 0 0 1px #9526f38c,
    0 0 14px #9526f38c;
}


/* =======================
   DESCRIPTION
======================= */
.description {
  max-width: 850px;
}

.about-card {
  background: linear-gradient(180deg, rgba(26,26,26,.98), rgba(18,18,18,.98));
  color: var(--text-light);
  border-radius: 18px;
  padding: 26px 30px;
  border: 1px solid var(--border-soft);
  box-shadow: 0 18px 45px rgba(0,0,0,.32);
}

.about-list {
  margin: 0;
  padding-left: 22px;
}

.about-list li {
  margin-bottom: 14px;
  line-height: 1.7;
  font-size: 1.04rem;
  color: #dddddd;
}

.about-list li:last-child {
  margin-bottom: 0;
}

.about-empty {
  margin: 0;
  color: var(--muted-text);
  font-size: 1rem;
}

/* =======================
   CTA BAR
======================= */
.booking-bar {
  position: sticky;
  bottom: 0;
  z-index: 40;
  margin-top: 80px;
  background: linear-gradient(135deg, #9526F3, #b44cff);
  color: #ffffff;
  padding: 16px 22px;
  border-radius: 28px;
  display: flex;
  justify-content: space-between;
  align-items: center;
  box-shadow: 0 -14px 30px rgba(0,0,0,.45);
  transition: all 0.3s ease;
}

.booking-bar:hover {
  transform: scale(1.01);
}

.booking-bar button {
  background: #111;
  color: var(--highlight);
  border: none;
  padding: 14px 40px;
  border-radius: 30px;
  font-size: 1.15rem;
  transition: all 0.3s ease;
  box-shadow: 0 6px 25px rgba(0,0,0,0.35);
}

.booking-bar button:hover {
  transform: scale(1.08);
  box-shadow: 0 10px 35px rgba(0,0,0,0.55);
}
.add-review-btn {
    background: rgba(149, 38, 243, 0.2);
    backdrop-filter: blur(10px);
    border: 1px solid #9526F3;

    color: white;
    padding: 10px 22px;
    border-radius: 30px;
    cursor: pointer;
    font-weight: 600;
    transform: scale(0.95);
    transition: 0.3s ease;
}

.add-review-btn:hover {
    background: #9526F3;
    box-shadow: 0 0 15px #9526F3;
}
/* =======================
   ANIMATIONS
======================= */
.popup-overlay {
    position: fixed;
    inset: 0;
    background: rgba(0,0,0,0.7);
    backdrop-filter: blur(6px);
    display: none;
    justify-content: center;
    align-items: center;

    z-index: 9999; /* important */
}
.fade-up {
  animation: fadeUp 0.7s ease both;
}

@keyframes fadeUp {
  0% { opacity: 0; transform: translateY(18px); }
  100% { opacity: 1; transform: translateY(0); }
}

/* OVERLAY */


/* POPUP BOX */
.popup-box {
    background: linear-gradient(145deg, #121212, #1c1c1c);
    color: white;
    padding: 30px;
    width: 380px;
    border-radius: 18px;

    box-shadow: 0 20px 50px rgba(0,0,0,0.8);

    animation: popupAnimation 0.3s ease;
}

/* TITLE */
.popup-box h3 {
    margin-bottom: 15px;
    font-weight: 700;
}

/* INPUTS */
.popup-box input,
.popup-box textarea {
    width: 100%;
    padding: 12px;
    margin: 10px 0;
    border-radius: 10px;
    border: none;
    background: #2a2a2a;
    color: white;
}

/* STARS */
.stars {
    display: flex;
    flex-direction: row-reverse;
    justify-content: center;
    margin: 15px 0;
}

.stars input {
    display: none;
}

.stars label {
    font-size: 30px;
    color: #666;
    cursor: pointer;
    transition: 0.2s;
}

.stars label:hover,
.stars label:hover ~ label,
.stars input:checked ~ label {
    color: gold;
    transform: scale(1.2);
}
body.popup-open {
    overflow: hidden;
}
/* BUTTONS */
.popup-buttons {
    display: flex;
    justify-content: space-between;
    margin-top: 15px;
}

.btn-submit {
    background: linear-gradient(45deg, #9526F3, #b44cff);
    color: white;
    padding: 10px 20px;
    border: none;
    border-radius: 10px;
}

.btn-cancel {
    background: #333;
    color: white;
    padding: 10px 20px;
    border: none;
    border-radius: 10px;
}
.review-btn {
    position: relative;
    overflow: hidden;
}

.review-btn::before {
    content: "";
    position: absolute;
    width: 100%;
    height: 100%;
    background: linear-gradient(120deg, transparent, rgba(255,255,255,0.3), transparent);
    top: 0;
    left: -100%;
    transition: 0.5s;
}

.review-btn:hover::before {
    left: 100%;
}
/* ANIMATION */
@keyframes popupAnimation {
    from {
        transform: scale(0.8);
        opacity: 0;
    }
    to {
        transform: scale(1);
        opacity: 1;
    }
}
.review-header {
    display: flex;
    justify-content: space-between;
    align-items: center;
}
/* REVIEW SECTION */
.review-section {
    margin-top: 60px;
}

/* REVIEW CARD */
.review-card {
    background: #1a1a1a;
    border: 1px solid #9526f38c;
    border-radius: 15px;
    padding: 18px;
    margin-bottom: 15px;

    transition: 0.3s;
}

.review-card:hover {
    transform: translateY(-3px);
    box-shadow: 0 0 15px #9526f38c;
}

/* NAME */
.review-name {
    font-weight: 700;
    color: #fff;
}

/* STARS */
.review-stars {
    color: gold;
    margin: 5px 0;
}

/* TEXT */
.review-text {
    color: #ccc;
    font-size: 14px;
}
/* GRID CONTAINER */
.review-grid {
    display: grid;
    grid-template-columns: repeat(3, 1fr); /* 3 cards per row */
    gap: 20px;
    margin-top: 20px;
}
/* Tablet */
@media (max-width: 992px) {
    .review-grid {
        grid-template-columns: repeat(2, 1fr);
    }
}

/* Mobile */
@media (max-width: 576px) {
    .review-grid {
        grid-template-columns: 1fr;
    }

    .about-card {
        padding: 22px 18px;
    }
}

.review-card {
    background: #1a1a1a;
    border: 1px solid #9526f38c;
    border-radius: 12px;
    padding: 20px;

    height: 180px;  /* square feel */
    display: flex;
    flex-direction: column;
    justify-content: space-between;

    transition: 0.3s ease;
}
.profile-img {
    width: 45px;
    height: 45px;
    border-radius: 50%;
    object-fit: cover;
    border: 2px solid #9526F3;
}
.review-user {
    display: flex;
    align-items: center;
    gap: 10px;
}
.review-card:hover {
    transform: translateY(-5px);
    box-shadow: 0 0 15px #9526f38c;
}
.review-card {
    opacity: 0;
    animation: slideRight 0.5s ease forwards;
}

@keyframes slideRight {
    from {
        transform: translateX(60px);
        opacity: 0;
    }
    to {
        transform: translateX(0);
        opacity: 1;
    }
}


</style>
</head>

<body>
<div class="top-bar">
  <div class="container-xl">
    <div class="top-bar-row">
      <button class="back-btn" onclick="history.back()">← Back</button>
      <h1 class="top-title"><?= htmlspecialchars($turf['turf_name']) ?></h1>
    </div>
  </div>
</div>

<div class="container-xl mt-4 fade-up">

<!-- HERO -->
<div class="hero mb-5">
  <div id="slider" class="carousel slide" data-bs-ride="carousel" data-bs-interval="4000">
    <div class="carousel-inner">
      <?php mysqli_data_seek($imgRes,0); $active="active"; while($img=mysqli_fetch_assoc($imgRes)){ ?>
      <div class="carousel-item <?= $active ?>">
        <img src="../owner/turf_images/<?= $img['image_path'] ?>" class="d-block w-100 hero-img">
      </div>
      <?php $active=""; } ?>
    </div>

    <!-- Controls -->
    <button class="carousel-control-prev" type="button" data-bs-target="#slider" data-bs-slide="prev">
      <span class="carousel-control-prev-icon"></span>
    </button>
    <button class="carousel-control-next" type="button" data-bs-target="#slider" data-bs-slide="next">
      <span class="carousel-control-next-icon"></span>
    </button>

    <!-- Indicators -->
    <div class="carousel-indicators">
      <?php mysqli_data_seek($imgRes,0); $i=0; $active="active"; while(mysqli_fetch_assoc($imgRes)){ ?>
      <button type="button" data-bs-target="#slider" data-bs-slide-to="<?= $i ?>" class="<?= $active ?>"></button>
      <?php $i++; $active=""; } ?>
    </div>
  </div>

  <div class="hero-overlay"></div>
  <div class="hero-info">
    <h1><?= htmlspecialchars($turf['turf_name']) ?></h1>
    <p>📍 <?= $turf['location'] ?>, <?= $turf['city_name'] ?></p>
    <a href="https://www.google.com/maps?q=<?= $turf['latitude'] ?>,<?= $turf['longitude'] ?>" target="_blank" class="btn btn-sm mt-2 directions-btn">
  🧭 Get Directions
</a>

  </div>
</div>

<!-- SPORTS -->
<div class="section">
  <h3>Available Sports</h3>
  <div class="row g-4">
    <?php mysqli_data_seek($sportRes,0); while($s=mysqli_fetch_assoc($sportRes)){
      $prefix=strtoupper($s['sport_name'][0]); ?>
    <div class="col-md-6 col-lg-4">
      <div class="sport-card fade-up">
        <h5><?= $s['sport_name'] ?></h5>
        <div class="courts">
          <?php for($i=1;$i<=$s['no_of_courts'];$i++){ ?>
          <div class="court"><?= $prefix.$i ?></div>
          <?php } ?>
        </div>
      </div>
    </div>
    <?php } ?>  
  </div>
</div>

<!-- AMENITIES -->
<div class="section">
  <h3>Amenities</h3>
  <div class="amenities fade-up">
    <?php mysqli_data_seek($amenRes,0); while($a=mysqli_fetch_assoc($amenRes)){ ?>
    <div class="amenity"><?= $a['amenity_name'] ?></div>
    <?php } ?>
  </div>
</div>

<!-- DESCRIPTION -->
<div class="section">
  <h3>About Turf</h3>
  <div class="description fade-up">
    <div class="about-card">
      <?php if (!empty($aboutItems)) { ?>
        <ul class="about-list">
          <?php foreach ($aboutItems as $item) { ?>
            <li><?= htmlspecialchars($item) ?></li>
          <?php } ?>
        </ul>
      <?php } else { ?>
        <p class="about-empty">Details about this turf will be updated soon.</p>
      <?php } ?>
    </div>
  </div>
</div>

<!-- CTA -->
 <?php if (!$fromVendor): ?>
<div class="booking-bar fade-up">
  <div>
    <h4 class="mb-1">Ready to Play?</h4>
    <small>Check availability & book your slot</small>
  </div>
  <a 
  href="bookingpage.php?turf_id=<?= $turf_id ?>" 
  class="btn btn-dark px-5 py-3 rounded-pill fw-semibold"
>
  Book Now
</a>
</div>
  <!-- ✅ VERY IMPORTANT -->


<?php endif; ?>
<br><br>
<br><br>
</div>
  <div class="review-header">

    <h3>Customer Reviews</h3>

    <?php if(isset($_SESSION['user_id'])) { ?>

        <button onclick="openPopup()" class="add-review-btn">
            ⭐ Add Review
        </button>

    <?php }?>

</div>
<br>
           <?php if(mysqli_num_rows($reviewRes) > 0) { ?>
           <?php while($r = mysqli_fetch_assoc($reviewRes)) { 
              $uid =$r['user_id'];
              $name = mysqli_query($conn,"select name,profile_image from user where id =$uid");
              $n = mysqli_fetch_assoc($name);              
          ?>
          
            <div class="review-card">
              <div class="review-user">

    <?php if(!empty($n['profile_image'])) { ?>
        <img src="../<?= $n['profile_image'] ?>" class="profile-img">
    <?php } else { ?>
        <img src="../user/profile/default_avatar.png" class="profile-img">
    <?php } ?>

    <span class="review-name">
        <?= htmlspecialchars($n['name']) ?>
    </span>

</div>
                <div class="review-stars">
                    <?php
                    for($i=1; $i<=5; $i++){
                        if($i <= $r['rating']){
                            echo "★";
                        } else {
                            echo "☆";
                        }
                    }
                    ?>
                </div>

                <div class="review-text">
                    <?= htmlspecialchars($r['review_text']) ?>
                </div>

            </div>

        <?php }  ?>

    <?php } else { ?>

        <p style="color:#aaa;">No reviews yet. Be the first to review!</p>

    <?php } ?>
</div>

</form>
    </div>
    <div id="popup" class="popup-overlay">

    <div class="popup-box">

        <h3>Leave a Review</h3>

        <form method="post" action="save_review.php">

            <input type="text" name="name" value="<?php echo $_SESSION['name']; ?>" readonly>
            <input type="hidden" name= "turf_id" value="<?php echo $turf_id ?>">
            <div class="stars">
                <input type="radio" name="rating" id="star5" value="5" required><label for="star5">★</label>
                <input type="radio" name="rating" id="star4" value="4"><label for="star4">★</label>
                <input type="radio" name="rating" id="star3" value="3"><label for="star3">★</label>
                <input type="radio" name="rating" id="star2" value="2"><label for="star2">★</label>
                <input type="radio" name="rating" id="star1" value="1"><label for="star1">★</label>
            </div>

            <textarea name="review" placeholder="Write review" required></textarea>

            <div class="popup-buttons">
                <button type="submit" class="btn-submit">Submit</button>
                <button type="button" onclick="closePopup()" class="btn-cancel">Cancel</button>
            </div>

<br><br>
</div>

<script>
function openPopup(){
    document.getElementById("popup").style.display = "flex";
    document.body.classList.add("popup-open");
}

function closePopup(){
    document.getElementById("popup").style.display = "none";
    document.body.classList.remove("popup-open");
}
</script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>

</body>
</html>



