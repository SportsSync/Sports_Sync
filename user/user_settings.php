<?php
include("../db.php");
session_start();

/* ===== LOGIN CHECK ===== */
if (!isset($_SESSION['user_id'])) {
?>
<!DOCTYPE html>
<html>
<head>
    <title>Login Required</title>
    <link rel="shortcut icon" href="../favicon.png" type="image/png">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css">

    <style>
        body {
            background-color: #121212;
            font-family: 'Segoe UI', sans-serif;
            color: #eaeaea;
        }

        .wrapper {
            min-height: 100vh;
            display: flex;
            align-items: center;
            justify-content: center;
        }

        .login-box {
            background: #1c1c1c;
            padding: 35px;
            border-radius: 20px;
            border: 1px solid rgba(199, 255, 94, 0.3);
            box-shadow: 0 0 35px rgba(199, 255, 94, 0.25);
            text-align: center;
            max-width: 500px;
            width: 100%;
        }

        .login-box h4 {
            font-weight: 600;
            margin-bottom: 10px;
        }

        .login-box p {
            color: #bdbdbd;
            margin-bottom: 25px;
        }

        .btn-login {
            background: #c7ff5e;
            color: #000;
            font-weight: 600;
            border-radius: 25px;
            padding: 10px 30px;
            border: none;
        }

        .btn-login:hover {
            background: #b5eb55;
            box-shadow: 0 0 15px rgba(199, 255, 94, 0.6);
        }

        .btn-back {
            border: 2px solid #c7ff5e;
            color: #c7ff5e;
            background: transparent;
            border-radius: 25px;
            padding: 6px 20px;
            text-decoration: none;
            display: inline-block;
            margin-bottom: 20px;
        }

        .btn-back:hover {
            background: #c7ff5e;
            color: #000;
        }
        .login-box {
    position: relative;
}

.back-wrapper {
    position: absolute;
    top: 20px;
    left: 20px;
}

    </style>
</head>

<body>

<div class="wrapper">
    <div class="login-box">

        <!-- BACK BUTTON -->
        <div class="back-wrapper">
    <a href="javascript:history.back()" class="btn-back">
        ← Back
    </a>
</div>
<br><br>
        <h4>🔒 Login Required</h4>
        <p>You must be logged in to access this page.</p>

        <a href="../signin.php" class="btn btn-login">
            Go to Login
        </a>

    </div>
</div>

</body>
</html>
<?php
exit;
}


$userid = $_SESSION['user_id'];

/* ===== FETCH CURRENT USER DATA ===== */
$stmt = $conn->prepare("SELECT name, email, mobile FROM user WHERE id=?");
$stmt->bind_param("i", $userid);
$stmt->execute();
$result = $stmt->get_result();
$user = $result->fetch_assoc();
$stmt->close();

/* ===== UPDATE PROFILE ===== */
if ($_SERVER["REQUEST_METHOD"] === "POST") {

    $name    = trim($_POST['name']);
    $email   = trim($_POST['email']);
    $mobile = trim($_POST['contact']);
    $password  = $_POST['password'];
    $cpassword = $_POST['cpassword'];

    // If password fields are empty → update without password
    if (empty($password) && empty($cpassword)) {

        $stmt = $conn->prepare(
            "UPDATE user SET name=?, email=?, mobile=? WHERE id=?"
        );
        $stmt->bind_param("sssi", $name, $email, $mobile, $userid);

    } else {

        if ($password !== $cpassword) {
            echo "<script>alert('Passwords do not match');</script>";
            exit;
        } else {
            $hashedPassword = password_hash($password, PASSWORD_DEFAULT);

            $stmt = $conn->prepare(
                "UPDATE user SET name=?, email=?, mobile=?, password=? WHERE id=?"
            );
            $stmt->bind_param("ssssi", $name, $email, $mobile, $hashedPassword, $userid);
        }
    }

    if (isset($stmt) && $stmt->execute()) {
        echo "<script>alert('Profile updated successfully'); window.location.href='sidebar.php';</script>";
    } elseif (isset($stmt)) {
        echo "<script>alert('Profile update failed');</script>";
    }

    if (isset($stmt)) $stmt->close();
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Update Profile</title>
    <link rel="stylesheet" href="../whole.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.1/font/bootstrap-icons.css">
    <style>

body {
    background-color: #121212;
    font-family: 'Segoe UI', sans-serif;
    color: #eaeaea;
}

/* CARD */
.settings-card {
    background: #1c1c1c;
    border-radius: 20px;
    padding: 35px;
    border: 1px solid rgba(199, 255, 94, 0.3);
    box-shadow: 0 0 35px rgba(199, 255, 94, 0.25);
}

/* PROFILE IMAGE */
.profile-img {
    width: 130px;
    height: 130px;
    border-radius: 50%;
    background: #222;
    border: 4px solid #c7ff5e;
    box-shadow: 0 0 25px rgba(199, 255, 94, 0.7);
    padding: 18px;
}

/* LABELS */
.form-label {
    color: #cfcfcf;
    font-weight: 500;
}

/* INPUTS */
.form-control {
    background: #2a2a2a;
    border: 1px solid #444;
    color: #fff;
    border-radius: 14px;
    padding: 12px 16px;
}

.form-control:focus {
    background: #2a2a2a;
    color: #fff;
    border-color: #c7ff5e;
    box-shadow: 0 0 0 0.2rem rgba(199, 255, 94, 0.25);
}

/* SAVE BUTTON */
.btn-save {
    background: #c7ff5e;
    color: #000;
    font-weight: 600;
    padding: 10px 40px;
    border-radius: 25px;
}

.btn-save:hover {
    background: #b5eb55;
    box-shadow: 0 0 15px rgba(199, 255, 94, 0.6);
}

/* BACK BUTTON */
.btn-back {
    border: 2px solid #c7ff5e;
    color: #c7ff5e;
    background: transparent;
    border-radius: 25px;
    padding: 6px 20px;
}

.btn-back:hover {
    background: #c7ff5e;
    color: #000;
}

/* CENTER CARD */
.settings-wrapper {
    min-height: 100vh;
    display: flex;
    align-items: center;
}
/* CENTER PROFILE CIRCLE */
.profile-img-wrapper {
    display: flex;
    justify-content: center;
}
input.form-control {
    color: #ffffff !important;
    caret-color: #c7ff5e;
}

/* PLACEHOLDER VISIBILITY */
input.form-control::placeholder {
    color: #9a9a9a !important;
    opacity: 1;
}

/* PASSWORD INPUT FIX */
input[type="password"] {
    color: #ffffff !important;
    background-color: #2a2a2a !important;
}

/* ON FOCUS */
input.form-control:focus {
    color: #ffffff !important;
}
    </style>
    <script>
        function validateForm() {
            const contact = document.getElementById("contact").value;
            const mobilePattern = /^[0-9]{10}$/;

            if (!mobilePattern.test(contact)) {
                alert("Please enter a valid 10-digit mobile number");
                return false;
            }
            return true;
        }
    </script>
</head>

<body>
<div class="container my-5 settings-wrapper">
    <div class="card settings-card mx-auto col-md-7 shadow-lg p-4 rounded-4">
        <div class="card-body">

            <!-- BACK BUTTON -->
            <div class="mb-3">
                <a href="sidebar.php" class="btn btn-back mb-3 btn-outline-secondary rounded-pill">
                    ← Back
                </a>
            </div>

      <div class="profile-img-wrapper mb-4">
    <div class="profile-img d-flex align-items-center justify-content-center">
        <i class="bi bi-person-fill" style="font-size:70px; color:#c7ff5e;"></i>
    </div>
</div>


            <form method="POST" onsubmit="return validateForm()">

                <div class="mb-3">
                    <label class="form-label">Name</label>
                    <input type="text" class="form-control" name="name"
                           value="<?= htmlspecialchars($user['name']) ?>" required>
                </div>

                <div class="mb-3">
                    <label class="form-label">Email</label>
                    <input type="email" class="form-control" name="email"
                           value="<?= htmlspecialchars($user['email']) ?>" required>
                </div>

                <div class="mb-3">
                    <label class="form-label">Contact</label>
                    <input type="text" class="form-control" name="contact" id="contact"
                           value="<?= htmlspecialchars($user['mobile']) ?>" required>
                </div>

                <div class="mb-3">
                    <label class="form-label">New Password</label>
                    <input type="password" class="form-control" name="password"
                           placeholder="Leave blank to keep current password">
                </div>

                <div class="mb-3">
                    <label class="form-label">Confirm New Password</label>
                    <input type="password" class="form-control" name="cpassword"
                           placeholder="Leave blank to keep current password">
                </div>

                <div class="text-center">
                    <button type="submit" class="btn btn-save btn-success px-5 rounded-pill">
                        Save Changes
                    </button>
                </div>

            </form>

        </div>
    </div>
</div>

<?php include("../footer.php"); ?>
</body>
</html>
