<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>Elite Grounds</title>

  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css">
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.css">
  <link href="whole.css" rel="stylesheet">
</head>
<body onload="loadPage('user_home.php')">
  <div class="d-flex">

    <div class="sidebar">
      <div class="logo">
        <i class="bi bi-dribbble"></i><br>
        <small>SportSync</small>
      </div>
      <a href="#" onclick="loadPage('user_home.php')" title="Explore">
        <i class="bi bi-search"></i>
      </a>
      <a href="#" onclick="loadPage('bookingpage.php')" title="Bookings">
        <i class="bi bi-calendar-check-fill"></i>
      </a>
      <a href="#" onclick="loadPage('user_settings.php')" title="Settings">
        <i class="bi bi-gear-fill"></i>
      </a>
      <a href="#" onclick="loadPage('review.php')" title="Reviews">
        <i class="bi bi-star-fill"></i>
      </a>
      <a href="index.php" title="Home">
        <i class="bi bi-house-fill"></i>
      </a>
    </div>

    <div class="main flex-grow-1">
      <iframe id="main-frame"></iframe>
    </div>
  </div>

  <script>
    function loadPage(page) {
      document.getElementById("main-frame").src = page;
    }
  </script>
</body>
</html>
