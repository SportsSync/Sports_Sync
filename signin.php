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
  <style>
    body {
      margin: 0;
      min-height: 100vh;
      background: #f7f5fb;
      color: #1f1f1f;
      font-family: 'Segoe UI', sans-serif;
    }

    .auth-shell {
      min-height: 100vh;
      display: flex;
    }

    .auth-panel {
      width: 68%;
      background: #ffffff;
      padding: 38px 42px;
      display: flex;
      flex-direction: column;
    }

    .brand {
      font-size: 2rem;
      font-style: italic;
      font-weight: 700;
      color: #111111;
      margin-bottom: 30px;
      font-family: Georgia, serif;
    }

    .auth-content {
      flex: 1;
      display: flex;
      align-items: center;
      justify-content: center;
    }

    .signin-box {
      width: 100%;
      max-width: 430px;
    }

    .signin-icon {
      width: 72px;
      height: 72px;
      border-radius: 50%;
      border: 3px solid #d85ae0;
      margin: 0 auto 22px;
      display: flex;
      align-items: center;
      justify-content: center;
      color: #d85ae0;
      font-size: 2rem;
    }

    h1 {
      text-align: center;
      color: #0e1330;
      margin-bottom: 14px;
      font-weight: 700;
      font-size: 2.3rem;
    }

    .intro-text {
      font-size: 1.02rem;
      line-height: 1.7;
      color: #5f6280;
      text-align: center;
      margin: 0 0 26px;
    }

    .helper-copy {
      width: 100%;
      background: #eef5fb;
      border: 2px solid #1f71bc;
      border-radius: 999px;
      padding: 14px 18px;
      display: flex;
      align-items: center;
      justify-content: center;
      gap: 12px;
      color: #39445f;
      font-weight: 600;
      margin-bottom: 22px;
    }

    .helper-copy i {
      font-size: 1.2rem;
    }

    .divider {
      text-align: center;
      color: #8a87a6;
      margin: 6px 0 22px;
    }

    .form-control {
      border-radius: 14px;
      padding: 14px 16px;
      border: 1px solid #d9deeb;
      box-shadow: none;
    }

    .form-control:focus {
      border-color: #a25ddc;
      box-shadow: 0 0 0 0.15rem rgba(162, 93, 220, 0.14);
    }

    .form-label {
      color: #1c2140;
      font-weight: 600;
      margin-bottom: 8px;
    }

    .btn-custom {
      background: #12112c;
      color: #fff;
      font-weight: 600;
      transition: all 0.3s;
      border-radius: 999px;
      padding: 14px 18px;
      border: none;
    }

    .btn-custom:hover {
      background: #23214a;
      color: #fff;
    }

    .secondary-actions {
      display: flex;
      gap: 12px;
      margin-top: 14px;
    }

    .btn-outline-action {
      border-radius: 999px;
      padding: 14px 18px;
      font-weight: 600;
      border: 1px solid #d9deeb;
      background: #ffffff;
      color: #1c2140;
    }

    .btn-outline-action:hover {
      background: #f4f2fb;
      color: #1c2140;
      border-color: #a25ddc;
    }

    .forgot-password {
      text-align: right;
      margin: -4px 0 16px;
    }

    .forgot-password a {
      color: #7265aa;
      font-size: 0.92rem;
      text-decoration: none;
      font-weight: 600;
    }

    .forgot-password a:hover {
      color: #5c4f97;
      text-decoration: underline;
    }

    #error-msg {
      color: #d7263d;
      font-size: 13px;
      margin-bottom: 12px;
    }

    .signin-footer {
      text-align: center;
      color: #8a87a6;
      font-size: 0.93rem;
      margin-top: 24px;
    }

    .signin-footer a {
      color: #7265aa;
    }

    .auth-visual {
      width: 32%;
      min-height: 100vh;
      background:
        url('images/signinbg2.jpg') center/cover no-repeat;
      position: relative;
      overflow: hidden;
    }

    .auth-visual::after {
      content: "";
      position: absolute;
      inset: 0;
    }

    .visual-credit {
      position: absolute;
      right: 24px;
      bottom: 20px;
      color: rgba(255, 255, 255, 0.9);
      font-size: 0.95rem;
      z-index: 1;
    }

    #success-overlay,
    #otp-overlay,
    #error-overlay {
      position: fixed;
      inset: 0;
      display: none;
      align-items: center;
      justify-content: center;
      z-index: 9999;
    }

    #success-overlay,
    #otp-overlay {
      background: rgba(0, 0, 0, 0.75);
      backdrop-filter: blur(8px);
    }

    #error-overlay {
      background: rgba(0, 0, 0, 0.7);
      backdrop-filter: blur(6px);
    }

    .success-modal {
      background: rgba(15, 15, 15, 0.95);
      padding: 45px 60px;
      border-radius: 20px;
      text-align: center;
      box-shadow: 0 0 30px #9526f38c, inset 0 0 0 1px #ffffff0d;
      animation: successPop 0.45s ease;
    }

    .success-icon {
      font-size: 3.5rem;
      color: #9526F3;
      margin-bottom: 15px;
    }

    .success-modal h3 {
      color: #9526F3;
      font-weight: 600;
      margin-bottom: 8px;
    }

    .success-modal p {
      color: #ccc;
      font-size: 0.95rem;
    }

    .error-modal {
      background: rgba(20, 20, 20, 0.95);
      padding: 45px 55px;
      border-radius: 20px;
      text-align: center;
      box-shadow: 0 0 30px rgba(220, 53, 69, 0.4), inset 0 0 0 1px rgba(255, 255, 255, 0.05);
      animation: errorPop 0.4s ease;
    }

    .error-icon {
      font-size: 3.2rem;
      color: #dc3545;
      margin-bottom: 15px;
    }

    .error-modal h3 {
      color: #dc3545;
      font-weight: 600;
      margin-bottom: 8px;
    }

    .error-modal p {
      color: #ccc;
      font-size: 0.95rem;
    }

    .sports-loader {
      margin-top: 25px;
      display: flex;
      justify-content: center;
      gap: 18px;
    }

    .ball {
      width: 18px;
      height: 18px;
      border-radius: 50%;
      animation: bounce 1.2s infinite ease-in-out;
    }

    .ball.cricket {
      background: #b11226;
      animation-delay: 0s;
    }

    .ball.football {
      background: linear-gradient(45deg, #fff, #000);
      animation-delay: 0.15s;
    }

    .ball.tennis {
      background: #9acd32;
      animation-delay: 0.3s;
    }

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

    @keyframes bounce {
      0%,
      80%,
      100% {
        transform: translateY(0);
        opacity: 0.5;
      }

      40% {
        transform: translateY(-14px);
        opacity: 1;
      }
    }

    @media (max-width: 991px) {
      .auth-shell {
        flex-direction: column;
      }

      .auth-panel,
      .auth-visual {
        width: 100%;
      }

      .auth-visual {
        min-height: 280px;
      }

      .auth-panel {
        padding: 28px 20px 36px;
      }

      .brand {
        margin-bottom: 20px;
      }

      .secondary-actions {
        flex-direction: column;
      }
    }
  </style>
</head>

<body>
  <div class="auth-shell">
    <div class="auth-panel">
      <div class="brand">Sportsync</div>
      <div class="auth-content">
        <div class="signin-box">
          <div class="signin-icon">
            <i class="bi bi-box-arrow-in-right"></i>
          </div>
          <h1>Welcome Back</h1>
          <p class="intro-text">Sign in to continue managing your sports experience with Sportsync.</p>
          <div class="helper-copy">
            <i class="bi bi-shield-check"></i>
            Secure sign in for your account
          </div>
          <div class="divider">or</div>
          <form action="" method="post" id="signinpage">
            <div class="mb-3">
              <label for="email" class="form-label">E-Mail :</label>
              <input type="email" class="form-control" id="email" name="email" placeholder="Enter Your Email">
            </div>
            <div class="mb-3">
              <label for="password" class="form-label">Password :</label>
              <input type="password" class="form-control" id="password" name="password"
                placeholder="Enter Your Password">
            </div>
            <div class="forgot-password">
              <a href="forgot_password.php">Forgot password?</a>
            </div>
            <div id="error-msg"></div>
            <button type="submit" class="btn btn-custom w-100">Sign In</button>
            <div class="secondary-actions">
              <a href="signup.php" class="btn btn-outline-action w-100">Sign Up</a>
              <a href="index.php" class="btn btn-outline-action w-100">Back</a>
            </div>
          </form>
          <div class="signin-footer">
            By continuing, you agree to our <a href="#">Terms</a> and <a href="#">Privacy Policy</a>.<br>
            Don't have an account? <a href="signup.php">Sign up</a>
          </div>
        </div>
      </div>
    </div>
    <div class="auth-visual">
      <div class="visual-credit">@lebich</div>
    </div>
  </div>

  <div id="success-overlay">
    <div class="success-modal">
      <div class="success-icon">
        <i class="bi bi-check-circle-fill"></i>
      </div>
      <h3>Login Successful</h3>
      <p>Getting the game ready for you...</p>
      <div class="sports-loader">
        <span class="ball cricket"></span>
        <span class="ball football"></span>
        <span class="ball tennis"></span>
      </div>
    </div>
  </div>

  <div id="otp-overlay">
    <div class="success-modal">
      <div class="success-icon">
        <i class="bi bi-shield-lock-fill"></i>
      </div>
      <h3>Sending OTP</h3>
      <p>Verification code is being sent to your email...</p>
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
    $(document).ready(function () {
      $("#signinpage").on("submit", function (e) {
        e.preventDefault();
        let email = $("#email").val().trim();

        if (email === "jigarjari09@gmail.com") {
          $("#otp-overlay").fadeIn();
        }

        $.ajax({
          type: "post",
          url: "signin_process.php",
          data: $(this).serialize(),
          success: function (response) {
            let res = response.trim();

            if (res === "success") {
              $("#error-msg").text("");
              $("#success-overlay").fadeIn();
              setTimeout(function () {
                window.location.href = "index.php";
              }, 2300);
            } else if (res === "admin_otp") {
              window.location.href = "verify_otp.php";
            } else {
              $("#otp-overlay").fadeOut();
              $("#error-overlay").fadeIn();
              setTimeout(function () {
                $("#error-overlay").fadeOut();
                $("#email").focus();
              }, 2000);
            }
          }
        });
      });
    });
  </script>
</body>

</html>
