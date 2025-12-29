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
    .signin-box {
      background-color: rgba(0, 0, 0, 0.85);
      padding: 40px;
      border-radius: 16px;
      max-width: 450px;
      margin: 60px auto;
      box-shadow: 0 8px 16px rgba(0, 0, 0, 0.6);
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
    .intro-text{
      font-size: 1.5rem;
      line-height: 1.7;
      color: #ffffffff;
    }
    .reveal{
      opacity: 0;
    }
    .reveal.show{
      opacity: 1;
    }
    .filled-btn{
      background-color:  #ff7a18;
      color: #000;
      border: none;
      padding: 12px 28px;
      font-size: 1rem;
      border-radius: 30px;
    }
    .filled-btn:hover {
      background-color: #ff7a18; /* same color */
      color: #fffefeff;
    }
  </style>
</head>
<body>
  <div class="container">
   <div class="row align-items-center min-vh-100">
      <div class="col-md-6">
          <h2 id="typing-text">Create Your Account Now</h2>
            <p class="intro-text reveal">
                Join us to get access to exclusive features, updates, and personalized content.
                Your data is secure and never shared.
            </p>
            <button class="btn filled-btn mt-3">
                Learn More  
            </button>
      </div>
      <div class="col-md-6 d-flex justify-content-center">
       <div class="signin-box p-4 rounded">
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
      </div>
    </div>
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

  <script>
const text = "Create Your Account Now";
let i = 0;

window.onload = () => {
    const heading = document.getElementById("typing-text");
    const para = document.querySelector(".reveal");

    heading.innerHTML = "";

    (function type() {
        if (i < text.length) {
            heading.innerHTML += text[i++];
            setTimeout(type, 80);
        }
    })();

    // reveal paragraph after delay
    setTimeout(() => {
        para.classList.add("show");
    }, 2000);
};
</script>
</body>
</html>
