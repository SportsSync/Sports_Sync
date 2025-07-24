<!DOCTYPE html>
<html>
<head>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css">
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.css">
  <link rel="stylesheet" href="whole.css">
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
<body style="background-color: #f1f3f6; font-family: 'Segoe UI', sans-serif;">
 <div class="container d-flex justify-content-center align-items-center min-vh-100">
  <div class="card shadow-lg p-4" style="width: 100%; max-width: 450px;">  
  <div class="text-center">
    <img src="https://images.pexels.com/photos/1222271/pexels-photo-1222271.jpeg?auto=compress&cs=tinysrgb&w=100" class="rounded-circle profile-img mb-2" alt="Profile Image">
    <br>
    <button class="btn btn-outline-primary btn-sm">Edit</button>
  </div>   
  <form class="mt-4" method="POST"  onsubmit=" return formvalid()">
    <div class="mb-3">
      <label for="" class="form-label">Name:</label>
      <input type="text" class="form-control" name="name" id="name" required>
    </div>
    
    <div class="mb-3">
      <label for="" class="form-label">Email:</label>
      <input type="email" class="form-control" name="email" id="email" required>
    </div>
    
    <div class="mb-3">
      <label for="" class="form-label">Contact No:</label>
      <input type="text" class="form-control" name="contact" id="cnumber" required>
    </div>
    
    <div class="mb-3">
      <label for="" class="form-label">password:</label>
      <input type="password" class="form-control" name="password" id="password" required><button type="button" onclick="passtoggle('password')">👁️</button>
    </div>
    
    <div class="mb-3">
      <label for="" class="form-label">Confirm Password:</label>
      <input type="password" class="form-control" name="cpassword" id="cpassword" required><button type="button" onclick="passtoggle('cpassword')">👁️</button>
    </div>
   
    <button type="submit" style="width: 100%; background-color: #ccff66; border: none; padding: 10px;">Save Changes</button>
  </form>   
  </div>
 </div>
   <?php
         include("footer.php");
      ?>
</body>
</html>
