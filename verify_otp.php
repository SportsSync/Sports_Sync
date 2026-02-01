<?php
session_start();

if(!isset($_SESSION['role']) || $_SESSION['role']!=='admin'){
  header("Location: signin.php");
  exit;
}

if(isset($_POST['otp'])){
  if($_POST['otp']==$_SESSION['admin_otp']){
    $_SESSION['admin_logged_in']=true;
    header("Location: admin/dashboard.php");
    exit;
  }
  $error="Invalid OTP";
}
?>

<form method="post" style="max-width:300px;margin:100px auto">
  <h3>Admin OTP</h3>
  <?php if(isset($error)) echo "<p style='color:red'>$error</p>"; ?>
  <input name="otp" class="form-control mb-2" placeholder="Enter OTP">
  <button class="btn btn-warning w-100">Verify</button>
</form>
