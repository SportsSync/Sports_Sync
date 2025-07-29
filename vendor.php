<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
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
    </style>
</head>
<body>
    <div class="form-container">
     <form>
        <h2>Personal Details</h2>
      <div class="mb-3">
        <label for="fname" class="form-label">First Name</label>
        <input type="text" class="form-control" id="fname" placeholder="Enter Your First Name">
      </div><br>

       <div class="mb-3">
        <label for="lname" class="form-label">Last Name</label>
        <input type="text" class="form-control" id="lname" placeholder="Enter Your Last Name">
      </div><br>

      <div class="mb-3">
        <label for="pno" class="form-label">Phone Number</label>
        <input type="text" class="form-control" id="pno" placeholder="Enter Your Number">
      </div><br>

       <div class="mb-3">
        <label for="email" class="form-label">Email</label>
        <input type="email" class="form-control" id="email" placeholder="Enter Your Email">
      </div><br>

       <div class="mb-3">
        <label for="dob" class="form-label">Date Of Birth</label>
        <input type="Date" class="form-control" id="dob">
      </div><br>

       <div class="mb-3">
        <label for="address" class="form-label" style="display: block; margin-bottom: 5px;">Address</label>
       <textarea id="address" name="address" rows="4" cols="40" placeholder="Enter your Address"></textarea>
      </div><br>

      <h2>Turf Details</h2>

       <div class="mb-3">
        <label for="fname" class="form-label">Turf Name</label>
        <input type="text" class="form-control" id="fname" placeholder="Enter Your Turf Name">
      </div><br>

      <div class="mb-3">
        <label for="address" class="form-label" style="display: block; margin-bottom: 5px;">Turf Address</label>
        <textarea id="address" name="address" rows="4" cols="40" placeholder="Enter your full address"></textarea>
      </div><br>

      <div class="mb-3">
       <label for="imageUpload">Upload an Image:</label>
       <input type="file" id="imageUpload" name="image" multiple accept="image/*">
      </div>

      <button type="button" class="btn btn-custom w-100">Sign In</button>
    </form>
    </div>
</body>
</html>