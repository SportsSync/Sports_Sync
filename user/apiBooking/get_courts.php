<?php
include('../../db.php');

$turf_id = (int)$_GET['turf_id'];
$sport_id = (int)$_GET['sport_id'];

$sql = "
    SELECT court_id, court_name, status
    FROM turf_courtstb
    WHERE turf_id = $turf_id 
      AND sport_id = $sport_id
";

$res = mysqli_query($conn, $sql);

$courts = [];

while ($row = mysqli_fetch_assoc($res)) {

    // Only show ACTIVE courts for booking
    if ($row['status'] === 'A') {
        $courts[] = [
            "court_id"   => $row['court_id'],
            "court_name" => $row['court_name']
        ];
    }
}

// Return array of courts
echo json_encode($courts);
?>
