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
            background-image: url('images/bg4.jpeg');
            background-size: cover;
            background-position: center;
            background-attachment: fixed;
            background-repeat: no-repeat;
            color: #F1F1F1;
            font-family: 'Segoe UI', sans-serif;
        }

        .signup-box {
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
            font-weight: 600;
            font-size: 2.2rem;
        }

        .form-control {
            border-radius: 8px;
        }

        .btn-custom {
            background-color: #eb7e25;
            color: #fff;
            font-weight: 600;
            transition: all 0.3s;
        }

        .btn-custom:hover {
            background-color: #f49a51;
            color: #000;
        }

        .note {
            font-size: 10px;
        }

        .warning {
            color: red;
            font-size: 13px;
        }

        .intro-text{
            font-size: 1.5rem;
            line-height: 1.7;
            color: #ffffffff;
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
            color: #000;
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
    <div class="container">
      <div class="row align-items-center min-vh-100">
         <div class="col-md-6">
            <h2>Create Your Account</h2>
            <p class="intro-text">
                Join us to get access to exclusive features, updates, and personalized content.
                Your data is secure and never shared.
            </p>

            <button class="btn filled-btn mt-3">
                Learn More  
            </button>
        </div>
        <div class="col-md-6 d-flex justify-content-center">
        <div class="signup-box p-4 rounded">
        <h1 class="mb-4 text-white">Sign Up</h1>
        <form method="post" action="registerVerify.php" enctype="multipart/form-data" onsubmit="return showLoader()">
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
        <div class="loader-overlay" id="loader">
    <div class="loader-box">
        <div class="loader-spinner"></div>
        <p>Verification code is being sent to your email…</p>
    </div>
</div>
    
    </div>
        </div>
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