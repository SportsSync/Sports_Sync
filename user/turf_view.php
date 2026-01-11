<?php
include('../db.php');

if (!isset($_GET['turf_id'])) {
    die('Invalid request');
}

$turf_id = (int) $_GET['turf_id'];

/* TURF BASIC INFO */
$sql = "
SELECT 
  t.turf_name,
  t.location,
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
        /* GLOBAL */
        body {
            background: var(--bg-dark);
            color: #eaeaea;
            font-family: 'Segoe UI', system-ui, sans-serif;
            margin: 0;
        }

        /* HERO SLIDER */
        .hero-img {
            height: 420px;
            object-fit: cover;
            border-radius: 16px;
        }

        .carousel-inner {
            box-shadow: 0 20px 40px rgba(0, 0, 0, .6);
            border-radius: 16px;
        }

        /* TITLE */
        .turf-title {
            font-size: 2.2rem;
            font-weight: 700;
            color: var(--highlight);
        }

        .turf-location {
            color: #aaa;
            font-size: .95rem;
        }

        /* SECTION DIVIDER */
        .section {
            margin-top: 40px;
        }

        .section h4 {
            font-weight: 600;
            color: #fff;
            margin-bottom: 15px;
        }

        /* SPORTS CARD */
        .sport-card {
            background: linear-gradient(145deg, #181818, #101010);
            border: 1px solid rgba(180, 255, 90, 0.35);
            border-radius: 18px;
            padding: 28px;
            max-width: 420px;
            /* 🔥 CONTROL SIZE */
            margin: 0 auto;
            /* 🔥 CENTER CARD */
            text-align: center;
        }


        .sport-card:hover {
            transform: translateY(-5px);
            box-shadow: 0 10px 25px rgba(0, 0, 0, .6);
        }

        .sport-card strong {
            color: var(--highlight);
            font-size: 1.1rem;
        }

        /* AMENITIES */
       .amenities-container {
  display: flex;
  flex-wrap: wrap;
  gap: 14px;
  margin-top: 14px;
}

/* Amenity Chip */
.amenity-chip {
  padding: 10px 18px;
  border-radius: 22px;
  background: #1c1c1c;
  color: #eaeaea;
  font-size: 0.95rem;
  border: 1px solid #2c2c2c;
  cursor: default;
  transition: all 0.25s ease;
}

/* 🔥 Hover Effect */
.amenity-chip:hover {
  background: var(--highlight);
  color: #111;
  border-color: var(--highlight);
  transform: translateY(-2px);
  box-shadow: 0 6px 18px rgba(180,255,90,0.35);
}

        /* DESCRIPTION */
        .description {
            color: #cfcfcf;
            line-height: 1.7;
        }

        /* CTA */
        .cta-box {
            background: linear-gradient(135deg, var(--highlight), #ffd166);
            color: #111;
            border-radius: 16px;
            padding: 28px;
            margin-top: 40px;
        }

        .cta-box h5 {
            font-weight: 700;
        }

        .btn-book {
            background: #111;
            color: var(--highlight);
            border: none;
            padding: 12px 28px;
            font-size: 1.05rem;
            border-radius: 30px;
            transition: .3s;
        }

        .btn-book:hover {
            background: #000;
            transform: scale(1.05);
        }

        .court-container {
            margin-top: 18px;
            display: flex;
            justify-content: center;
            /* 🔥 CENTER COURTS */
            gap: 16px;
        }

        .court-box {
            min-width: 72px;
            /* 🔥 BIGGER */
            padding: 12px 0;
            border-radius: 14px;
            background: #1f1f1f;
            border: 1px solid #2d2d2d;
            color: var(--highlight);
            font-weight: 600;
            cursor: pointer;
            transition: .25s;
        }

        .court-box:hover {
            background: var(--highlight);
            color: #111;
            transform: translateY(-2px) scale(1.05);
        }
    </style>
</head>

<body class="container mt-4">

    <!-- IMAGE SLIDER -->
    <!-- IMAGE SLIDER -->
    <div id="slider" class="carousel slide mb-4" data-bs-ride="carousel" data-bs-interval="2000">

        <!-- Indicators (dots) -->
        <div class="carousel-indicators">
            <?php
            mysqli_data_seek($imgRes, 0);
            $i = 0;
            $active = "active";
            while ($tmp = mysqli_fetch_assoc($imgRes)) {
                ?>
                <button type="button" data-bs-target="#slider" data-bs-slide-to="<?= $i ?>" class="<?= $active ?>"></button>
                <?php $active = "";
                $i++;
            } ?>
        </div>

        <div class="carousel-inner">
            <?php
            mysqli_data_seek($imgRes, 0);
            $active = "active";
            while ($r = mysqli_fetch_assoc($imgRes)) {
                ?>
                <div class="carousel-item <?= $active ?>">
                    <img src="../owner/turf_images/<?= $r['image_path'] ?>" class="d-block w-100 hero-img">
                </div>
                <?php $active = "";
            } ?>
        </div>

        <!-- Controls -->
        <button class="carousel-control-prev" type="button" data-bs-target="#slider" data-bs-slide="prev">
            <span class="carousel-control-prev-icon"></span>
        </button>
        <button class="carousel-control-next" type="button" data-bs-target="#slider" data-bs-slide="next">
            <span class="carousel-control-next-icon"></span>
        </button>

    </div>


    <!-- TITLE -->
    <h2 class="turf-title"><?= htmlspecialchars($turf['turf_name']) ?></h2>
    <p class="turf-location">
        📍 <?= $turf['location'] ?>, <?= $turf['city_name'] ?>
    </p>


    <hr>

    <!-- SPORTS -->
    <div class="section">
        <h4>Available Sports</h4>
        <div class="row g-4">

            <?php while ($s = mysqli_fetch_assoc($sportRes)) {

                $sportName = $s['sport_name'];
                $courts = (int) $s['no_of_courts'];

                // Prefix letter (Cricket=C, Football=F, Tennis=T, PickleBall=P)
                $prefix = strtoupper(substr($sportName, 0, 1));
                ?>

                <div class="col-md-6">
                    <div class="sport-card">
                        <strong style="font-size:1.25rem;color:var(--highlight);">
                            <?= htmlspecialchars($sportName) ?>
                        </strong>


                        <div class="court-container">
                            <?php for ($i = 1; $i <= $courts; $i++) { ?>
                                <div class="court-box">
                                    <?= $prefix . $i ?>
                                </div>
                            <?php } ?>
                        </div>

                    </div>
                </div>

            <?php } ?>

        </div>
    </div>



    <hr>

    <!-- AMENITIES -->
    <div class="section">
        <h4>Amenities</h4>
        <div class="amenities-container d-flex flex-wrap gap-2">
            <?php while ($a = mysqli_fetch_assoc($amenRes)) { ?>
                <span class="amenity-chip"><?= $a['amenity_name'] ?></span>
            <?php } ?>
        </div>
    </div>


    <hr>

    <!-- DESCRIPTION -->
    <div class="section">
        <h4>About Turf</h4>
        <p class="description">
            <?= nl2br(htmlspecialchars($turf['description'])) ?>
        </p>
    </div>


    <!-- CTA -->
    <div class="cta-box d-flex justify-content-between align-items-center">
        <div>
            <h5>Ready to Play?</h5>
            <small>Check availability & book your slot</small>
        </div>
        <button class="btn-book">Book Now</button>
    </div>

    <br><br>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>

</html>