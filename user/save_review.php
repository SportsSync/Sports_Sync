<?php
session_start();
$conn = new mysqli("localhost:3306","root","","turf_booking_system");

// check login
if(!isset($_SESSION['user_id'])){
    echo "Login required!";
    exit();
}

// get values
$turf_id = $_POST['turf_id'];
$user_id = $_SESSION['user_id'];   // ✅ from session
$rating = $_POST['rating'];
$review_text = $_POST['review'];   // form field name = review

// insert query
$sql = "INSERT INTO turf_reviews (turf_id, user_id, rating, review_text, status)
        VALUES ('$turf_id', '$user_id', '$rating', '$review_text', 1)";

mysqli_query($conn, $sql);

// redirect back
header("Location: turf_view.php?turf_id=".$turf_id);
?>