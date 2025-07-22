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
  </style>
</head>
<body>
  <div class="form-container">
    <h1>Sign Up</h1>
    <form>
      <div class="mb-3">
        <label for="name" class="form-label">Name</label>
        <input type="text" class="form-control" id="name" placeholder="Your Name">
      </div>

      <div class="mb-3">
        <label for="email" class="form-label">E-Mail</label>
        <input type="email" class="form-control" id="email" placeholder="Your Email">
      </div>

      <div class="mb-3">
        <label for="number" class="form-label">Mobile Number</label>
        <input type="text" class="form-control" id="number" placeholder="Your Mobile Number">
      </div>

      <div class="mb-3">
        <label for="password" class="form-label">Password</label>
        <input type="password" class="form-control" id="password" placeholder="Your Password">
      </div><br>

      <button type="button" class="btn btn-custom w-100">Sign Up</button>
    </form>
  </div>
</body>
</html>
