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
/* Overlay */
#success-overlay {
  position: fixed;
  inset: 0;
  background: rgba(0, 0, 0, 0.75);
  backdrop-filter: blur(8px);
  display: none;
  align-items: center;
  justify-content: center;
  z-index: 9999;
}

/* Modal Box */
.success-modal {
  background: rgba(15, 15, 15, 0.95);
  padding: 45px 60px;
  border-radius: 20px;
  text-align: center;
  box-shadow:
    0 0 30px rgba(235, 126, 37, 0.35),
    inset 0 0 0 1px rgba(255,255,255,0.05);
  animation: successPop 0.45s ease;
}

/* Icon */
.success-icon {
  font-size: 3.5rem;
  color: #eb7e25;
  margin-bottom: 15px;
}

/* Text */
.success-modal h3 {
  color: #eb7e25;
  font-weight: 600;
  margin-bottom: 8px;
}

.success-modal p {
  color: #ccc;
  font-size: 0.95rem;
}

/* Animation */
@keyframes successPop {
  from {
    transform: scale(0.85);
    opacity: 0;
  }
  to {
    transform: scale(1);
    opacity: 1;
  }
}
/* Sports Loader Container */
.sports-loader {
  margin-top: 25px;
  display: flex;
  justify-content: center;
  gap: 18px;
}

/* Common Ball Style */
.ball {
  width: 18px;
  height: 18px;
  border-radius: 50%;
  animation: bounce 1.2s infinite ease-in-out;
}

/* Cricket Ball */
.ball.cricket {
  background: #b11226;
  animation-delay: 0s;
}

/* Football */
.ball.football {
  background: linear-gradient(45deg, #fff, #000);
  animation-delay: 0.15s;
}

/* Tennis Ball */
.ball.tennis {
  background: #9acd32;
  animation-delay: 0.3s;
}

/* Bounce Animation */
@keyframes bounce {
  0%, 80%, 100% {
    transform: translateY(0);
    opacity: 0.5;
  }
  40% {
    transform: translateY(-14px);
    opacity: 1;
  }
}

/* Error Overlay */
#error-overlay {
  position: fixed;
  inset: 0;
  background: rgba(0, 0, 0, 0.7);
  backdrop-filter: blur(6px);
  display: none;
  align-items: center;
  justify-content: center;
  z-index: 9999;
}

/* Error Box */
.error-modal {
  background: rgba(20, 20, 20, 0.95);
  padding: 45px 55px;
  border-radius: 20px;
  text-align: center;
  box-shadow:
    0 0 30px rgba(220, 53, 69, 0.4),
    inset 0 0 0 1px rgba(255,255,255,0.05);
  animation: errorPop 0.4s ease;
}

/* Icon */
.error-icon {
  font-size: 3.2rem;
  color: #dc3545;
  margin-bottom: 15px;
}

/* Text */
.error-modal h3 {
  color: #dc3545;
  font-weight: 600;
  margin-bottom: 8px;
}

.error-modal p {
  color: #ccc;
  font-size: 0.95rem;
}

/* Animation */
@keyframes errorPop {
  from {
    transform: scale(0.85);
    opacity: 0;
  }
  to {
    transform: scale(1);
    opacity: 1;
  }
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
<!-- Premium Login Success Overlay -->
<div id="success-overlay">
  <div class="success-modal">
    <div class="success-icon">
      <i class="bi bi-check-circle-fill"></i>
    </div>

    <h3>Login Successful</h3>
    <p>Getting the game ready for you…</p>

    <!-- Sports Loader -->
    <div class="sports-loader">
      <span class="ball cricket"></span>
      <span class="ball football"></span>
      <span class="ball tennis"></span>
    </div>
  </div>
</div>

<div id="error-overlay">
  <div class="error-modal">
    <div class="error-icon">
      <i class="bi bi-x-circle-fill"></i>
    </div>
    <h3>Invalid Login</h3>
    <p>Email or password is incorrect. Please try again.</p>
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
            $("#error-msg").text("");
  $("#success-overlay").fadeIn();

  setTimeout(function(){
    window.location.href = "index.php";
  }, 2300);
          }
          else
          {
           $("#error-overlay").fadeIn();

    setTimeout(function(){
      $("#error-overlay").fadeOut();
      $("#email").focus(); // focus back on input
    }, 2000);
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
