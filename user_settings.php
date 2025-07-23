<!DOCTYPE html>
<html>
<head>
  <link href="whole.css" rel="stylesheet">
  <script>
    function passtoggle(id)
    {
      const see=document.getElementById(id);
      see.type=see.type==="password"?"text":"password";
    }

    function formvalid()
    {
      const name=document.getElementById('name').value;
      const email=document.getElementById('email').value;
      const cnumber=document.getElementById('cnumber').value;
      const password=document.getElementById('password').value;
      const cpassword=document.getElementById('cpassword').value;
      const mobilePattern=/^[0-9]{10}$/;

      if(password!=cpassword)
      {
        alert("Password do not match");
        return false;
      }
       if (!mobilePattern.test(cnumber)) {
        alert("Please enter a valid 10-digit mobile number.");
        return false;
    }
    return true;
    }
  </script>
</head>
<body>
  <div class="form-container">
     <h3 class="text-center mb-4">User Settings</h3>
  <form method="POST"  onsubmit=" return formvalid()">
    <label for="">Name:</label>
    <input type="text" name="name" id="name" required>
    <br><br>
    <label for="">Email:</label>
    <input type="email" name="email" id="email" required>
    <br><br>
    <label for="">Contact No:</label>
    <input type="text" name="contact" id="cnumber" required>
    <br><br>
    <label for="">password:</label>
    <input type="password" name="password" id="password" required><button type="button" onclick="passtoggle('password')">👁️</button>
    <br><br>
    <label for="">Confirm Password:</label>
    <input type="password" name="cpassword" id="cpassword" required><button type="button" onclick="passtoggle('cpassword')">👁️</button>
    <br><br>
    <button type="submit">Save Changes</button>
  </form>
  </div>
  <?php
    session_start();
    include 'db.php';
  ?>
</body>
</html>
