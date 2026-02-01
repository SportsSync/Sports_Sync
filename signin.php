<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Sign In</title>

  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.5/font/bootstrap-icons.css">
  <link rel="shortcut icon" href="favicon.png" type="image/png">
  <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>

  <!-- 🔹 YOUR FULL CSS (UNCHANGED) -->
  <style>
    body {
      background-image: url('images/bg4.jpeg');
      background-size: cover;
      background-position: center;
      background-attachment: fixed;
      background-repeat: no-repeat;
      color: #F1F1F1;
      font-family: 'Segoe UI', sans-serif;
    }
    .signin-box {
      background-color: rgba(0, 0, 0, 0.85);
      padding: 40px;
      border-radius: 16px;
      max-width: 450px;
      margin: 60px auto;
      box-shadow: 0 8px 16px rgba(0, 0, 0, 0.6);
    }
    h1 {
      text-align: center;
      color: #eb7e25;
      margin-bottom: 30px;
    }
    .btn-custom {
      background-color: #eb7e25;
      color: #000;
      font-weight: 600;
    }
    #error-msg{ color:red; }

    #success-overlay, #error-overlay{
      position: fixed;
      inset: 0;
      display: none;
      align-items: center;
      justify-content: center;
      z-index: 9999;
      backdrop-filter: blur(6px);
    }
    #success-overlay{ background: rgba(0,0,0,0.75); }
    #error-overlay{ background: rgba(0,0,0,0.7); }
  </style>
</head>

<body>
<div class="container">
 <div class="row align-items-center min-vh-100">
  <div class="col-md-6"></div>

  <div class="col-md-6 d-flex justify-content-center">
   <div class="signin-box">
    <h1>Sign In</h1>

    <form id="signinpage">
      <div class="mb-3">
        <label>Email</label>
        <input type="email" class="form-control" name="email" required>
      </div>

      <div class="mb-3">
        <label>Password</label>
        <input type="password" class="form-control" name="password" required>
      </div>

      <div id="error-msg"></div>
      <button class="btn btn-custom w-100">Sign In</button>
    </form>
   </div>
  </div>
 </div>
</div>

<!-- SUCCESS -->
<div id="success-overlay">
  <div class="bg-dark text-light p-4 rounded">
    <h4>Login Successful</h4>
    <p>Redirecting…</p>
  </div>
</div>

<!-- ERROR -->
<div id="error-overlay">
  <div class="bg-dark text-danger p-4 rounded">
    <h4>Invalid Login</h4>
  </div>
</div>

<script>
$(document).ready(function(){
  $("#signinpage").submit(function(e){
    e.preventDefault();

    $.ajax({
      type: "POST",
      url: "signin_process.php",
      data: $(this).serialize(),
      success: function(response){
        response = response.trim();

        if(response === "success"){
          $("#success-overlay").fadeIn();
          setTimeout(()=>{ window.location="index.php"; },2000);
        }
        else if(response === "admin_otp"){
          window.location = "verify_otp.php";
        }
        else{
          $("#error-overlay").fadeIn();
          setTimeout(()=>{ $("#error-overlay").fadeOut(); },2000);
        }
      }
    });
  });
});
</script>

</body>
</html>
