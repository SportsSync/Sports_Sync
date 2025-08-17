<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Sign In</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.5/font/bootstrap-icons.css">
  <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
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
    .form-container {
      background-color: rgba(0, 0, 0, 0.85);
      padding: 40px;
      border-radius: 16px;
      max-width: 400px;
      margin: 80px auto;
      box-shadow: 0 8px 16px rgba(0, 0, 0, 0.6);
    }
    h1 {
      text-align: center;
      color: #eb7e25;
      margin-bottom: 30px;
      font-weight: 600;
      font-size: 2rem;
    }
    .form-control {
      border-radius: 8px;
    }
    .btn-custom {
      background-color: #eb7e25;
      color: #000;
      font-weight: 600;
      transition: all 0.3s;
    }
    .btn-custom:hover {
      background-color: #eb7e25;
      color: #fff;
    }
    .signup-link {
      text-align: center;
      margin-top: 15px;
    }
    .signup-link a {
      color: #eb7e25;
      text-decoration: none;
      font-weight: 500;
    }
    .signup-link a:hover {
      text-decoration: underline;
    }
    #error-msg{
      color: red;
    }
  </style>
</head>
<body>
  <div class="form-container">
    <h1>Sign In</h1>
    <form action="" method="post" id="signinpage">
      <div class="mb-3">
        <label for="email" class="form-label">E-Mail :</label>
        <input type="email" class="form-control" id="email" name="email" placeholder="Enter Your Email">
      </div>

      <div class="mb-3">
        <label for="password" class="form-label">Password :</label>
        <input type="password" class="form-control" id="password" name="password" placeholder="Enter Your Password">
      </div><br>
      <div id="error-msg"></div>

      <button type="submit" class="btn btn-custom w-100">Sign In</button>

      <div class="signup">
        If you Don't have Account? <a href="signup.php">Sign Up</a>
      </div>
    </form>
  </div>

  <script>
    $(document).ready(function(){
      $("#signinpage").on("submit",function(e){
        e.preventDefault();

       $.ajax({
        type:"post",
        url:"signin_process.php",
        data:$(this).serialize(),
        success:function(response){
          if(response.trim()==="success")
          {
            window.location.href="index.php";
          }
          else
          {
            $("#error-msg").text(response);
          }
        }
       });
      });
    });
  </script>
</body>
</html>
