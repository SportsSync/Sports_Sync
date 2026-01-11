<?php
include('../db.php');

echo '<option value="all">All Sports</option>';

$q = mysqli_query($conn, "SELECT sport_id, sport_name FROM sportstb ORDER BY sport_name");

while ($row = mysqli_fetch_assoc($q)) {
    echo '<option value="'.$row['sport_id'].'">'.$row['sport_name'].'</option>';
}
