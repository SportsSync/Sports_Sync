<?php
session_start();

if ($_SERVER['REQUEST_METHOD'] === "POST") {
    $email = $_POST['email'];
    $password = $_POST['password'];

    if ($email === "admin@gmail.com" && $password === "admin123") {
        $_SESSION['admin'] = true;
        $_SESSION['role'] = 'Admin';
        header("Location: dashboard.php");
        exit;
    }

    $error = "Invalid Admin Credentials";
}
?>
<!DOCTYPE html>
<html>
<head>
<title>Admin Login</title>
<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body class="bg-dark">

<div class="container mt-5">
<div class="card col-md-4 mx-auto">
<div class="card-body">
<h4>Admin Login</h4>

<?php if(isset($error)) echo "<p class='text-danger'>$error</p>"; ?>

<form method="post">
<input type="email" name="email" class="form-control mb-2" required>
<input type="password" name="password" class="form-control mb-2" required>
<button class="btn btn-primary w-100">Login</button>
</form>

</div>
</div>
</div>
</body>
</html>
