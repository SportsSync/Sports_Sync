<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>Elite Grounds</title>

  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css">
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.css">
  <link href="whole.css" rel="stylesheet">

  <style>
    body {
      background-color: var(--bg-dark);
      color: var(--card-bg);
      margin: 0;
      font-family: Arial, sans-serif;
    }

    .sidebar {
      background-color: var(--divider);
      height: 100vh;
      position: fixed;
      width: 5%;
      display: flex;
      flex-direction: column;
      align-items: center;
      padding-top: 5rem;
    }

    .sidebar a {
      color: var(--highlight);
      margin: 1.5rem 0;
      font-size: 1.6rem;
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
      margin-bottom: 2rem;
      line-height: 1.2;
      text-align: center;
    }

    .main {
      margin-left: 5%;
      padding: 0;
      height: 100vh;
      background-color: var(--bg-dark);
    }

    iframe {
      border: none;
      width: 100%;
      height: 100%;
      background-color: var(--bg-dark);
    }
  </style>
</head>
<?php
  $cityParam = isset($_GET['city']) ? $_GET['city'] : '';

  $iframeSrc = 'user_home.php' . ($cityParam ? '?city=' . urlencode($cityParam) : '');
?>
<body>
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
      <a href="#" onclick="loadPage('Review.php')" title="Reviews">
        <i class="bi bi-star-fill"></i>
      </a>
      <a href="index.php" title="Home">
        <i class="bi bi-house-fill"></i>
      </a>
    </div>

    <div class="main flex-grow-1">
      <iframe id="content-frame" src="<?php echo $iframeSrc; ?>"></iframe>
    </div>
  </div>
  <script>
    function loadPage(page) {
      const urlParams = new URLSearchParams(window.location.search);
      const city = urlParams.get('city');
      const fullUrl = city ? `${page}?city=${city}` : page;
      document.getElementById('content-frame').src = fullUrl;
    }
  </script>
</body>
</html>
