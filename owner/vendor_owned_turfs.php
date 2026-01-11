<?php
include('../db.php');
session_start();

$owner_id = $_SESSION['user_id'];

$sql = "
SELECT 
  t.turf_id,
  t.turf_name,
  t.location,
  c.city_name,
  (
    SELECT image_path 
    FROM turf_imagestb ti 
    WHERE ti.turf_id = t.turf_id 
    LIMIT 1
  ) AS image
FROM turftb t
LEFT JOIN citytb c ON c.city_id = t.city_id
WHERE t.owner_id = $owner_id
ORDER BY t.turf_id DESC
";

$res = mysqli_query($conn, $sql);
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <title>My Turfs</title>

    <!-- Bootstrap -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">

    <!-- Bootstrap Icons -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons/font/bootstrap-icons.css" rel="stylesheet">
    <link href="../whole.css" rel="stylesheet">
    <style>
/* ===============================
   GLOBAL THEME (MATCH VIEW PAGE)
================================*/
body {
  background: var(--bg-dark);
  color: #eaeaea;
  font-family: 'Segoe UI', system-ui, sans-serif;
}

/* ===============================
   PAGE HEADER
================================*/
.page-title {
  font-weight: 700;
  color: var(--highlight);
  letter-spacing: 0.4px;
}

/* ===============================
   TURF CARD
================================*/
.turf-card {
  background: linear-gradient(145deg, #181818, #101010);
  border-radius: 18px;
  overflow: hidden;
  height: 100%;
  border: 1px solid rgba(180, 255, 90, 0.25);
  transition: all 0.35s ease;
}

.turf-card:hover {
  transform: translateY(-6px);
  box-shadow: 0 18px 40px rgba(0, 0, 0, 0.6);
}

/* ===============================
   IMAGE
================================*/
.turf-img {
  position: relative;
  height: 190px;
  overflow: hidden;
}

.turf-img img {
  width: 100%;
  height: 100%;
  object-fit: cover;
  transition: transform 0.5s ease;
}

.turf-card:hover img {
  transform: scale(1.08);
}

/* ===============================
   CITY BADGE
================================*/
.city-badge {
  position: absolute;
  top: 12px;
  left: 12px;
  background: rgba(0, 0, 0, 0.7);
  color: var(--highlight);
  padding: 6px 14px;
  font-size: 12px;
  border-radius: 20px;
  font-weight: 500;
}

/* ===============================
   BODY
================================*/
.turf-body {
  padding: 18px;
}

.turf-title {
  font-size: 18px;
  font-weight: 600;
  color: #fff;
}

.turf-location {
  font-size: 14px;
  color: #aaa;
  margin-bottom: 16px;
  display: flex;
  align-items: center;
  gap: 6px;
}

.turf-location i {
  color: var(--highlight);
}

/* ===============================
   ACTION BUTTON
================================*/
.actions {
  display: flex;
}

.actions .btn {
  width: 100%;
  border-radius: 30px;
  font-size: 14px;
  font-weight: 500;
  background: linear-gradient(135deg, var(--highlight), #ffd166);
  color: #111;
  border: none;
  transition: 0.3s;
}

.actions .btn:hover {
  transform: scale(1.05);
  box-shadow: 0 10px 30px rgba(180,255,90,0.4);
}

/* ===============================
   ADD TURF BUTTON
================================*/
.go-vendor-btn {
  border-radius: 30px;
  padding: 10px 22px;
  font-size: 14px;
  font-weight: 600;
  background: linear-gradient(135deg, var(--highlight), #ffd166);
  color: #111;
  border: none;
  transition: 0.3s;
}

.go-vendor-btn:hover {
  transform: translateY(-2px) scale(1.05);
  box-shadow: 0 10px 30px rgba(180,255,90,0.45);
}

/* ===============================
   EMPTY STATE
================================*/
.empty-state {
  margin-top: 80px;
  text-align: center;
  color: #aaa;
}

/* ===============================
   SUBTLE LOAD ANIMATION
================================*/
.turf-card {
  animation: fadeUp .5s ease both;
}

@keyframes fadeUp {
  from {
    opacity: 0;
    transform: translateY(10px);
  }
  to {
    opacity: 1;
    transform: translateY(0);
  }
}

    </style>
</head>

<body>

    <div class="container mt-5">
        <div class="d-flex justify-content-between align-items-center mb-4">
            <h3 class="page-title">My Turfs</h3>

            <a href="vendor.php" class="btn btn-primary go-vendor-btn">
                <i class="bi bi-arrow-right-circle"></i> Add Turfs
            </a>
        </div>


        <div class="row g-4">

            <?php if (mysqli_num_rows($res) > 0) { ?>
                <?php while ($row = mysqli_fetch_assoc($res)) {

                    $img = $row['image']
                        ? "../owner/turf_images/" . $row['image']
                        : "../images/default_turf.jpg";
                    ?>

                    <div class="col-xl-3 col-lg-4 col-md-6">
                        <div class="turf-card">

                            <div class="turf-img">
                                <img src="<?= $img ?>" alt="Turf Image">
                                <span class="city-badge"><?= htmlspecialchars($row['city_name']) ?></span>
                            </div>

                            <div class="turf-body">
                                <h5 class="turf-title"><?= htmlspecialchars($row['turf_name']) ?></h5>

                                <p class="turf-location">
                                    <i class="bi bi-geo-alt-fill"></i>
                                    <?= htmlspecialchars($row['location']) ?>
                                </p>

                                <div class="actions">
                                    <a href="../user/turf_view.php?turf_id=<?= $row['turf_id'] ?>&from=vendor" class="btn btn-success">
                                        <i class="bi bi-eye"></i> View Turf
                                    </a>
                                </div>

                            </div>

                        </div>
                    </div>

                <?php } ?>
            <?php } else { ?>

                <div class="empty-state">
                    <h5>No turfs added yet</h5>
                    <p>Click <strong>Add Turf</strong> to create your first turf</p>
                </div>

            <?php } ?>

        </div>
    </div>

</body>

</html>