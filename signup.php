<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Sign Up</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.5/font/bootstrap-icons.css">
    <link rel="shortcut icon" href="favicon.png" type="image/png">
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

        .signup-box {
            width: 100%;
            max-width: 430px;
        }

        .signup-icon {
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

        .intro-text{
            font-size: 1.02rem;
            line-height: 1.7;
            color: #5f6280;
            text-align: center;
            margin: 0 0 26px;
        }

        .social-btn {
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

        .social-btn i {
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

        .note {
            font-size: 11px;
            color: #7f8298;
        }

        .warning {
            color: #d7263d;
            font-size: 13px;
        }

        .avatar-block {
            margin-bottom: 24px;
        }

        .signup-footer {
            text-align: center;
            color: #8a87a6;
            font-size: 0.93rem;
            margin-top: 24px;
        }

        .signup-footer a {
            color: #7265aa;
        }

        .auth-visual {
            width: 32%;
            min-height: 100vh;
            background:
                url('images/bg4.jpeg') center/cover no-repeat;
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
        /* Loader overlay */
.loader-overlay {
    position: fixed;
    top: 0;
    left: 0;
    width: 100%;
    height: 100%;
    background: rgba(0,0,0,0.7);
    display: none;
    align-items: center;
    justify-content: center;
    z-index: 9999;
}

.loader-box {
    background: #000;
    padding: 30px 40px;
    border-radius: 12px;
    text-align: center;
    color: #fff;
    box-shadow: 0 0 20px rgba(255,122,24,0.6);
}

.loader-spinner {
    width: 40px;
    height: 40px;
    border: 4px solid #fff;
    border-top: 4px solid #ff7a18;
    border-radius: 50%;
    margin: 0 auto 15px;
    animation: spin 1s linear infinite;
}

@keyframes spin {
    100% { transform: rotate(360deg); }
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
        }
    </style>
    <script>
        function validation() {
            let name = document.getElementById("name").value;
            let email = document.getElementById("email").value;
            let number = document.getElementById("number").value;
            let password = document.getElementById("password").value;

            let name_pattern = /^[a-zA-Z ]{2,}$/;
            let email_pattern = /^[a-z0-9._-]+@[a-z0-9-]+(\.[a-z]{2,})+$/;
            let number_pattern = /^[6789]{1}[0-9]{9}$/;
            let password_pattern = /^(?=.*[a-z])(?=.*[A-Z])(?=.*\d)(?=.*[@.#$!%*?&])[A-Za-z\d@.#$!%*?&]{8,15}$/;

            let is_name = true;
            let is_email = true;
            let is_number = true;
            let is_password = true;

            if (name === "") {
                document.getElementById("name_warning").innerText = "Your name is required."; is_name = false;
            } else if (name_pattern.test(name) == false) {
                document.getElementById("name_warning").innerText = "Please give appropriate name."; is_name = false;
            } else {
                document.getElementById("name_warning").innerText = ""; is_name = true;
            }

            if (email === "") {
                document.getElementById("email_warning").innerText = "Your email is required."; is_email = false;
            } else if (email_pattern.test(email) == false) {
                document.getElementById("email_warning").innerText = "Please give valid email."; is_email = false;
            } else {
                document.getElementById("email_warning").innerText = ""; is_email = true;
            }

            if (number === "") {
                document.getElementById("number_warning").innerText = "Your mobile number is required."; is_number = false;
            } else if (number_pattern.test(number) == false) {
                document.getElementById("number_warning").innerText = "Please give valid mobile number."; is_number = false;
            } else {
                document.getElementById("number_warning").innerText = ""; is_number = true;
            }

            if (password === "") {
                document.getElementById("password_warning").innerText = "Your password is required."; is_password = false;
            } else if (password_pattern.test(password) == false) {
                document.getElementById("password_warning").innerText = "Please give valid password."; is_password = false;
            } else {
                document.getElementById("password_warning").innerText = ""; is_password = true;
            }

            return is_name && is_number && is_email && is_password;

        }
        function showLoader() {
    if (validation()) {
        document.getElementById("loader").style.display = "flex";
        return true; // allow form submit
    }
    return false; // stop submit if validation fails
}
    </script>
</head>

<body>
    <div class="auth-shell">
      <div class="auth-panel">
        <div class="brand">Sportsync</div>
        <div class="auth-content">
        <div class="signup-box">
        <div class="signup-icon">
            <i class="bi bi-dribbble"></i>
        </div>
        <h1>Welcome to Sportsync</h1>
        <p class="intro-text">
            Create your account and discover world-class design talent.
        </p>
        <button type="button" class="social-btn">
            <i class="bi bi-google"></i>
            Continue with Google
        </button>
        <div class="divider">or</div>
        <form method="post" action="registerVerify.php" enctype="multipart/form-data" onsubmit="return showLoader()">
        <div class="avatar-block">
        <label for="profile" class="form-label">Profile photo :</label>
        <div class="mb-4 text-center">

    <div id="avatarWrapper" style="position:relative; display:inline-block; cursor:pointer;">
        <img id="preview"
             src="https://static.vecteezy.com/system/resources/previews/024/983/914/non_2x/simple-user-default-icon-free-png.png"
             style="width:130px;height:130px;border-radius:50%;object-fit:cover;border:3px solid #ff7a18;">
        
        <div style="
            position:absolute;
            bottom:0;
            right:0;
            background:#ff7a18;
            width:35px;
            height:35px;
            border-radius:50%;
            display:flex;
            align-items:center;
            justify-content:center;
            color:black;
            font-weight:bold;">
            +
        </div>
    </div>

    <input type="file"
           id="cameraInput"
           name="profile_photo"
           accept="image/*"
           capture="environment"
           style="display:none;">

    <input type="file"
           id="fileInput"
           accept="image/*"
           style="display:none;">
</div>
            </div>
            <div class="mb-3">
                <span class="warning">* </span><label for="name" class="form-label">Name :</label>
                <input type="text" class="form-control" id="name" name="name" placeholder="Your Full Name">
                <span class="warning" id="name_warning"></span>
            </div>

            <div class="mb-3">
                <span class="warning">* </span><label for="email" class="form-label">E-Mail :</label>
                <input type="email" class="form-control" id="email" name="email" placeholder="Your Email Address">
                <span class="warning" id="email_warning"></span>

            </div>

            <div class="mb-3">
                <span class="warning">* </span><label for="number" class="form-label">Mobile Number :</label>
                <input type="text" class="form-control" id="number" name="number" placeholder="Your Mobile Number">
                <span class="warning" id="number_warning"></span>

            </div>

            <div class="mb-3">
                <span class="warning">* </span><label for="password" class="form-label">Password :</label>
                <input type="password" class="form-control" name="password" id="password" placeholder="Your Password">
                <div class="warning" id="password_warning"></div>
                <span class="note">Note :  Use 8–15 characters with a mix of capital & small letters(A-Z)(a-z), a number, and a special symbol(#,$,!,%,*,?,&).</span>
            </div>
            <div class="warning" id="warning"></div><br>
            <button type="submit" class="btn btn-custom w-100" name="send">Sign Up</button>
        </form>
        <div class="signup-footer">
            By continuing, you agree to our <a href="#">Terms</a> and <a href="#">Privacy Policy</a>.<br>
            Already have an account? <a href="signin.php">Sign in</a>
        </div>
        <div class="loader-overlay" id="loader">
    <div class="loader-box">
        <div class="loader-spinner"></div>
        <p>Verification code is being sent to your email…</p>
    </div>
</div>
    
    </div>
        </div>
      </div>
     <div class="auth-visual">
      </div>
      </div>
    <div id="imageOptionsModal" style="
    display:none;
    position:fixed;
    inset:0;
    background:rgba(0,0,0,0.7);
    justify-content:center;
    align-items:center;
    z-index:9999;">

    <div style="
        background:#000;
        padding:25px;
        border-radius:12px;
        width:260px;
        text-align:center;">

        <button id="useCamera"
            style="width:100%;padding:12px;margin-bottom:10px;
            background:#ff7a18;border:none;border-radius:8px;font-weight:600;">
            📷 Use Camera
        </button>

        <button id="chooseFile"
            style="width:100%;padding:12px;margin-bottom:10px;
            background:#333;color:white;border:none;border-radius:8px;">
            📁 Choose from Device
        </button>

        <button id="cancelModal"
            style="width:100%;padding:10px;background:none;color:#aaa;border:none;">
            Cancel
        </button>
    </div>
</div>
<script>
document.addEventListener("DOMContentLoaded", function () {

    const avatarWrapper = document.getElementById("avatarWrapper");
    const modal = document.getElementById("imageOptionsModal");
    const cameraInput = document.getElementById("cameraInput");
    const fileInput = document.getElementById("fileInput");
    const preview = document.getElementById("preview");

    avatarWrapper.addEventListener("click", () => {
        modal.style.display = "flex";
    });

    document.getElementById("cancelModal").addEventListener("click", () => {
        modal.style.display = "none";
    });

    document.getElementById("useCamera").addEventListener("click", () => {
        modal.style.display = "none";
        cameraInput.click();
    });

    document.getElementById("chooseFile").addEventListener("click", () => {
        modal.style.display = "none";
        fileInput.click();
    });

    function handleImage(file){
        if(!file) return;

        if(file.size > 5 * 1024 * 1024){
            alert("Max 5MB allowed.");
            return;
        }

        const reader = new FileReader();
        reader.onload = function(e){
            preview.src = e.target.result;
        }
        reader.readAsDataURL(file);
    }

    cameraInput.addEventListener("change", e => {
        handleImage(e.target.files[0]);
    });

    fileInput.addEventListener("change", e => {
        cameraInput.files = e.target.files;
        handleImage(e.target.files[0]);
    });

});
</script>
</body>

</html>
