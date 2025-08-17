<!DOCTYPE html>
<html>
<head>
  <link rel="stylesheet" href="whole.css">
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css">
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.css">
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
  <div class="container my-5">      
    <div class="card shadow-lg p-4 rounded-4">
      <div class="card-body">
        <div class="text-center ">
          <img src="https://images.pexels.com/photos/1222271/pexels-photo-1222271.jpeg?auto=compress&cs=tinysrgb&w=100" class="rounded-circle mb-2" style="width: 150px; height: 120px; " alt="Profile Image"><br>
          <button class="btn-success" style="border-radius:8px">Edit</button>
        </div>   
      <form method="POST"  onsubmit=" return formvalid()">
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
          <input type="password" class="form-control" name="password" id="password" required>
        </div>
    
        <div class="mb-3">
          <label for="" class="form-label">Confirm Password:</label>
          <input type="password" class="form-control" name="cpassword" id="cpassword" required>
        </div>
   
        <div class="text-center">
          <button type="submit" class="btn-success" style="width: 50%; border-radius:20px;">Save Changes</button>
        </div>
      </form>  
      </div>
    </div>
  </div>
  <?php include("footer.php"); ?>
</body>
</html>
