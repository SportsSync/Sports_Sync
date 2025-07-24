<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Sign Up</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.5/font/bootstrap-icons.css">
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
            color: #000;
            font-weight: 600;
            transition: all 0.3s;
        }

        .btn-custom:hover {
            background-color: #eb7e25;
            color: #fff;
        }

        .note {
            font-size: 10px;
        }

        .warning {
            color: red;
            font-size: 13px;
        }
    </style>
    <script>

        function validation() {
            let name = document.getElementById("name").value;
            let email = document.getElementById("email").value;
            let number = document.getElementById("number").value;
            let password = document.getElementById("password").value;

            let name_pattern = /^[a-zA-Z ]{2,}$/;
            let email_pattern = /^[a-z0-9._-]+@[a-z]+\.[a-z]{2,4}$/;
            let number_pattern = /^[789]{1}[0-9]{9}$/;
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
                document.getElementById("password_warning").innerText = "Your password is mandatory."; is_password = false;
            } else if (password_pattern.test(password) == false) {
                document.getElementById("password_warning").innerText = "Please give valid password."; is_password = false;
            } else {
                document.getElementById("password_warning").innerText = ""; is_password = true;
            }

            if (is_name && is_number && is_email && is_password) {
                window.location.href = "bookingpage.php"
            }

        }
    </script>
</head>

<body>
    <div class="form-container">
        <h1>Sign Up</h1>
        <form>
            <div class="mb-3">
                <label for="name" class="form-label">Name <span class="warning"> *</span></label>
                <input type="text" class="form-control" id="name" placeholder="Your Name">
                <span class="warning" id="name_warning"></span>
            </div>

            <div class="mb-3">
                <label for="email" class="form-label">E-Mail<span class="warning"> *</span></label>
                <input type="email" class="form-control" id="email" placeholder="Your Email">
                <span class="warning" id="email_warning"></span>

            </div>

            <div class="mb-3">
                <label for="number" class="form-label">Mobile Number<span class="warning"> *</span></label>
                <input type="text" class="form-control" id="number" placeholder="Your Mobile Number">
                <span class="warning" id="number_warning"></span>

            </div>

            <div class="mb-3">
                <label for="password" class="form-label">Password<span class="warning"> *</span></label>
                <input type="password" class="form-control" id="password" placeholder="Your Password">
                <div class="warning" id="password_warning"></div>
                <span class="note">Note : Your password must contains atleast one uppercase letter, one lowercase, one
                    digit, one special character and length must between 8 to 15 charcters.</span>
            </div>
            <div class="warning" id="warning"></div><br>
            <button type="button" class="btn btn-custom w-100" onclick="validation()">Sign Up</button>
        </form>
    </div>
</body>

</html>