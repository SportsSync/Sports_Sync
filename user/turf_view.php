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
  --highlight: #caff33;
  --accent: #ffe066;
  --text-light: #f2f2f2;
  --muted-text: #b5b5b5;
  --border-soft: rgba(202,255,51,0.25);
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
  background: rgba(202,255,51,0.15);
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
    0 0 0 1px rgba(202,255,51,0.35),
    0 0 18px rgba(202,255,51,0.25);
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
  box-shadow: 0 6px 14px rgba(202,255,51,0.35);
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
    0 0 0 1px rgba(202,255,51,0.4),
    0 0 14px rgba(202,255,51,0.3);
}


/* =======================
   DESCRIPTION
======================= */
.description {
  max-width: 850px;
  line-height: 1.8;
  color: #cfcfcf;
  font-size: 1.05rem;
  position: relative;
  padding-left: 20px;
}

.description::before {
  content: '“';
  position: absolute;
  top: -12px;
  left: 0;
  font-size: 3rem;
  color: var(--highlight);
  font-weight: 900;
}

.description p span {
  color: var(--highlight);
  font-weight: 700;
}

/* =======================
   CTA BAR
======================= */
.booking-bar {
  position: sticky;
  bottom: 0;
  z-index: 40;
  margin-top: 80px;
  background: linear-gradient(135deg, #caff33, #ffe066);
  color: #111;
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

/* =======================
   ANIMATIONS
======================= */
.fade-up {
  animation: fadeUp 0.7s ease both;
}

@keyframes fadeUp {
  0% { opacity: 0; transform: translateY(18px); }
  100% { opacity: 1; transform: translateY(0); }
}

/* =======================
   CAROUSEL CONTROLS
======================= */
.carousel-control-prev-icon,
.carousel-control-next-icon {
  background-color: var(--highlight);
  border-radius: 50%;
  width: 48px;
  height: 48px;
}

.carousel-indicators [data-bs-target] {
  background-color: var(--highlight);
  width: 12px;
  height: 12px;
  border-radius: 50%;
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
    <a href="https://www.google.com/maps?q=<?= $turf['latitude'] ?>,<?= $turf['longitude'] ?>" target="_blank" class="btn btn-outline-warning btn-sm mt-2">
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
  <p class="description fade-up"><?= nl2br(htmlspecialchars($turf['description'])) ?></p>
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
<?php endif; ?>
<br><br>
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>



