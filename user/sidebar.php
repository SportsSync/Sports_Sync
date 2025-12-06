<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>Elite Grounds</title>

  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css">
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.css">
  <link href="../whole.css" rel="stylesheet">
  <script src="../jquery-3.7.1.min.js"></script>
  <script src="loaddata.js"></script>
  <style>
    body {
      background-color: var(--bg-dark);
      color: var(--card-bg);
      margin: 0;
      font-family: Arial, sans-serif;
    }

    .sidebar {
      background-color: var(--divider);
      height: 100%;
      position: fixed;
      width: 10%;
      display: flex;
      flex-direction: column;
      align-items: center;
      padding-top: 2rem;
    }

    .sidebar a {
      color: var(--highlight);
      margin: 1.0rem 0;
      font-size: 1.5rem;
      transition: transform 0.3s, background-color 0.3s;
      padding: 0.5rem;
      border-radius: 10px;
      text-decoration: none;
    }

    .sidebar a:hover {
      background-color: var(--highlight);
      color: var(--bg-dark);
      transform: scale(1.2);
    }

    .logo {
      color: var(--highlight);
      font-size: 1.2rem;
      margin-bottom: 1rem;
      line-height: 1.2;
      text-align: center;
    }

    .main {
      margin-left: 15%;
      padding: 0;
      height: 100%;
      width: 100%;
      border: none;
      background-color: var(--bg-dark);
    }
    
    h2 {
      text-align: center;
      color: var(--highlight);
      margin-top: 20px;
      border-bottom: 2px solid var(--divider);
      padding-bottom: 10px;
    }
     .form-select {
      background-color: var(--card-bg);
      color: var(--bg-dark);
      border: 1px solid var(--border);
    }

    .form-select:focus {
      border-color: var(--highlight);
      box-shadow: 0 0 5px var(--highlight);
    }
    .card {
       background-color: var(--card-bg);
      color: var(--bg-dark);
      border: 1px solid var(--divider);
      transition: transform 0.3s, box-shadow 0.3s;
    }
    .card-title {
      color:  #c8581fff;
      text-align: center;
    }
    .card-text {
      color: #0e0d0dff;
    }
    .card:hover {
      transform: scale(1.03);
      transition: 0.3s;
      box-shadow: 0 0 15px  var(--highlight);
    }
    .btn-success {
       background-color: var(--highlight);
      color: var(--bg-dark);
      border: none;
    }
    .btn-success:hover {
      background-color: var(--highlight);
      box-shadow: 0 0 8px var(--highlight);
      color: var(--bg-dark);
    }
    .footer {
  background-color: #A9745B;
  color: #F7F6F2;
  margin-left: 10%;
  margin-top: 25px;
}
  </style>
</head>
<body>
  <div class="d-flex">
    <div class="sidebar">
      <div class="logo">
        <i class="bi bi-dribbble"></i><br>
        <small>SportSync</small>
      </div>
      <a href="#" id='user_home' title="Explore">
        <i class="bi bi-search"></i>
      </a>
      <a href="user_settings.php" id='user_settings' title="User Settings">
        <i class="bi bi-gear-fill"></i>
      </a>
       <a href="#" id='user_booking' title="Previous Bookings">
        <i class="bi bi-clock-history"></i></a>
      <a href="../index.php" title="Home">
        <i class="bi bi-house-fill"></i>
      </a>
    </div>
    <div class="main flex-grow-1">
    </div>
  </div>
  
<?php
    include("../footer.php");
  ?>
</body>
</html>
