session_start();
include("../db.php");

if (!isset($_SESSION['admin']) || $_SESSION['role'] !== 'admin') {
    header("Location: ../signin.php");
    exit;
}

$id = (int)$_GET['id'];

/* Fetch user */
$res = mysqli_query($conn, "SELECT user_id FROM vendorrequesttb WHERE id=$id");
$data = mysqli_fetch_assoc($res);

if ($data) {
    /* Make user vendor */
    mysqli_query($conn, "UPDATE user SET role='Vendor' WHERE id=".$data['user_id']);

    /* Update request */
    mysqli_query($conn, "UPDATE vendorrequesttb SET status='A' WHERE id=$id");
}

header("Location: vendor_requests.php");
exit;
