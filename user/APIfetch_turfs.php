<?php
include("../db.php");

$search = $_POST['search'] ?? '';
$city = $_POST['city'] ?? 'all';

$where = [];

// search
if (!empty($_POST['search'])) {
    $search = mysqli_real_escape_string($conn, $_POST['search']);
    $where[] = "t.turf_name LIKE '%$search%'";
}

// city
if (!empty($_POST['city']) && $_POST['city'] != 'all') {
    $city = (int) $_POST['city'];
    $where[] = "t.city_id = $city";
}

// sport
if (!empty($_POST['sport']) && $_POST['sport'] != 'all') {
    $sport = (int) $_POST['sport'];
    $where[] = "ts.sport_id = $sport";
}

/* 🔥 THIS LINE FIXES YOUR ERROR */
$whereSql = count($where) ? 'WHERE ' . implode(' AND ', $where) : '';


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
  ) AS image,
  GROUP_CONCAT(s.sport_name SEPARATOR ', ') AS sports
FROM turftb t
LEFT JOIN citytb c ON c.city_id = t.city_id
LEFT JOIN turf_sportstb ts ON ts.turf_id = t.turf_id
LEFT JOIN sportstb s ON s.sport_id = ts.sport_id
$whereSql
GROUP BY t.turf_id
ORDER BY t.turf_id DESC
";

$res = mysqli_query($conn, $sql);

$html = '';

while ($row = mysqli_fetch_assoc($res)) {
    $img = $row['image']
        ? "../owner/turf_images/" . $row['image']
        : "../images/default_turf.jpg";

$html .= '
<div class="col-md-4 mb-4">
  <div class="card h-100">
    <img src="'.$img.'" class="card-img-top" style="height:220px;object-fit:cover;">
    <div class="card-body">
      <h5 class="card-title">'.$row['turf_name'].'</h5>
      <p class="card-text">
        <strong>City:</strong> '.$row['city_name'].'<br>
        <strong>Location:</strong> '.$row['location'].'<br>
        <strong>Sports:</strong> '.$row['sports'].'
      </p>
      <div class="text-center">
        <a href="../user/turf_view.php?turf_id='.$row['turf_id'].'" class="btn btn-success">
          View
        </a>
      </div>
    </div>
  </div>
</div>';

}

echo $html ?: '<p class="text-center text-muted">No turfs found</p>';
