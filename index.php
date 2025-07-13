<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>Bootstrap Sidebar Layout</title>

  <!-- Bootstrap CSS -->
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">

  <!-- Bootstrap Icons -->
  <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.5/font/bootstrap-icons.css" rel="stylesheet">

  <style>
    body {
      background-color: #1A2730;
      color: #B0CEE2;
    }

    .sidebar {
      background-color: #424048;
      height: 100vh;
      position: fixed;
      width: 5%;
      display: flex;
      flex-direction: column;
      align-items: center;
      padding-top: 5rem;

    }

    .sidebar a {
      color: #E95D2C;
      margin: 1.5rem 0;
      font-size: 1.6rem;
      transition: transform 0.3s, background-color 0.3s;
      padding: 0.5rem;
      border-radius: 10px;
    }

    .sidebar a:hover {
      background-color: #A63E1B;
      transform: scale(1.2);
    }

    .main {
      margin-left: 5%;
      padding: 2rem;
    }

 .logo {
  color: #E95D2C;
  font-size: 1.2rem;
  margin-bottom: 2rem;
  line-height: 1.2;
}
   
  </style>
</head>
<body onload="loadpage();">

  <div class="d-flex">

      <div class="sidebar">

        <div class="logo text-center">
          <i class="bi bi-dribbble">
          </i>
          <small>SportSync</small>
        </div>


        <a href="#" onclick="loadPage('home.php')"><i class="bi bi-house-fill"></i></a>
        <a href="#" onclick="loadPage('user.php')"><i class="bi bi-people-fill"></i></a>
        <a href="#" onclick="loadPage('owner.php')"><i class="bi bi-person-vcard-fill"></i></a>
        <a href="#" onclick="loadPage('review.php')"><i class="bi bi-star-fill"></i></a>
      </div>
  
  

      <div class="main flex-grow-1">

        <iframe id="main-frame" src="home.php" frameborder="0" width="100%" height="1000px" style="background-color:#1A2730;"></iframe>
      </div>
  </div>


  <script>

    function loadPage(page) {
      document.getElementById("main-frame").src = page;
    }
  </script>
</body>
</html>
