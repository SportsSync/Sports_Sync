<?php
include("../../db.php");

$res = mysqli_query($conn, "SELECT city_id, city_name FROM citytb ORDER BY city_name");

echo '<option value="all">All Locations</option>';

while ($row = mysqli_fetch_assoc($res)) {
    echo '<option value="'.$row['city_id'].'">'.$row['city_name'].'</option>';
}
