<?php
include("../../db.php");

$search = $_POST['search'] ?? '';
$city = $_POST['city'] ?? 'all';
$userLat = $_POST['lat'] ?? null;
$userLng = $_POST['lng'] ?? null;

$where = [];

/* ================= SEARCH ================= */
if (!empty($search)) {
  $search = mysqli_real_escape_string($conn, $search);
  $where[] = "(t.turf_name LIKE '%$search%' OR t.location LIKE '%$search%')";
}

/* ================= CITY ================= */
if (!empty($city) && $city != 'all') {
  $city = (int)$city;
  $where[] = "t.city_id = $city";
}

/* ================= SPORT ================= */
if (!empty($_POST['sport']) && $_POST['sport'] != 'all') {
  $sport = (int)$_POST['sport'];
  $where[] = "ts.sport_id = $sport";
}

/* ================= WHERE ================= */
$whereSql = "WHERE 1=1";
if (!empty($where)) {
  $whereSql .= " AND " . implode(" AND ", $where);
}

/* ================= DISTANCE ================= */
$distanceSql = "";
$distanceOrder = "";

if (!empty($userLat) && !empty($userLng)) {
  $userLat = (float)$userLat;
  $userLng = (float)$userLng;

  $distanceSql = ",
    (
      6371 * acos(
        cos(radians($userLat)) *
        cos(radians(t.latitude)) *
        cos(radians(t.longitude) - radians($userLng)) +
        sin(radians($userLat)) *
        sin(radians(t.latitude))
      )
    ) AS distance";

  $distanceOrder = "distance ASC,";
}

/* ================= HAVING ================= */
$havingSql = "";
if (!empty($_POST['distance']) && !empty($userLat) && !empty($userLng)) {
  $radius = (int)$_POST['distance'];
  $havingSql = "HAVING distance <= $radius";
}

/* ================= MAIN SQL ================= */
$sql = "
SELECT 
    t.*, 
    ti.image
    $distanceSql,

    CASE 
        WHEN ta.id IS NOT NULL 
        THEN 1 ELSE 0
    END AS is_boosted,

    ta.plan_id,
    ta.start_date

FROM turftb t

/* ✅ latest active boost only */
LEFT JOIN (
    SELECT ta1.*
    FROM turf_ads ta1
    INNER JOIN (
        SELECT turf_id, MAX(start_date) AS latest_start
        FROM turf_ads
        WHERE is_active = 1
          AND NOW() BETWEEN start_date AND end_date
        GROUP BY turf_id
    ) ta2 
    ON ta1.turf_id = ta2.turf_id 
    AND ta1.start_date = ta2.latest_start
) ta 
ON ta.turf_id = t.turf_id

/* ✅ sport filter */
LEFT JOIN turf_sportstb ts 
ON ts.turf_id = t.turf_id

/* ✅ single image per turf */
LEFT JOIN (
    SELECT turf_id, MIN(image_path) AS image
    FROM turf_imagestb
    GROUP BY turf_id
) ti 
ON ti.turf_id = t.turf_id

$whereSql

$havingSql

/* ✅ FINAL SORTING */
ORDER BY 
    is_boosted DESC,
    ta.plan_id DESC,
    ta.start_date DESC,
    $distanceOrder
    t.turf_id DESC
";

/* ================= EXECUTION ================= */
$res = mysqli_query($conn, $sql);

if (!$res) {
  die("SQL ERROR: " . mysqli_error($conn));
}

/* ================= OUTPUT ================= */
$html = '';

while ($row = mysqli_fetch_assoc($res)) {

  $img = $row['image']
    ? "../owner/turf_images/" . $row['image']
    : "../images/default_turf.jpg";

  $html .= '
<div class="col-md-4 mb-4">
  <div class="card h-100 position-relative">';

  /* 🔥 HOT BADGE */
  if ($row['is_boosted']) {
    $html .= '
    <span style="
      position:absolute;
      top:10px;
      left:10px;
      background:#ff3b3b;
      color:#fff;
      padding:5px 10px;
      font-size:12px;
      border-radius:20px;
      z-index:10;
      box-shadow:0 0 10px rgba(255,0,0,0.6);
    ">🔥 HOT</span>';
  }

  $html .= '
    <img src="' . $img . '" class="card-img-top" style="height:220px;object-fit:cover;">
    <div class="card-body">
      <h5 class="card-title">' . $row['turf_name'] . '</h5>
      <p class="card-text">
        <strong>City:</strong> ' . ($row['city_name'] ?? 'N/A') . '<br>
        <strong>Location:</strong> ' . $row['location'] . '<br>';

  if (isset($row['distance'])) {
    $html .= '<small class="text-muted">' . round($row['distance'], 2) . ' km away</small><br>';
  } else {
    $html .= '<small class="text-muted">Location not enabled</small><br>';
  }

  $html .= '
        <strong>Sports:</strong> ' . ($row['sports'] ?? 'N/A') . '
      </p>
      <div class="text-center">
        <a href="../user/turf_view.php?turf_id=' . $row['turf_id'] . '" class="btn btn-success">
          View
        </a>
      </div>
    </div>
  </div>
</div>';
}

echo $html ?: '<p class="text-center text-light">No turfs found</p>';