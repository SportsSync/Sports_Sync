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
    :root {
      --bg-dark: #1C1C1C;
      --highlight: #D1FF71;
      --card-bg: #F7F6F2;
      --divider: #A9745B;
      --border: #BDBDBD;
    }
    body {
      background-color: var(--bg-dark);
      color: var(--card-bg);
    }

    .sidebar {
      background-color:var(--divider);
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
    }

    .sidebar a:hover {
      background-color: var(--highlight);
      color: var(--bg-dark);
      transform: scale(1.2);
    }

    .main {
      margin-left: 5%;
      padding: 2rem;
      background-color: var(--bg-dark);
    }

 .logo {
  color: var(--highlight);
  font-size: 1.2rem;
  margin-bottom: 2rem;
  line-height: 1.2;
}
    iframe {
      border: none;
      background-color: var(--bg-dark);
    }
  </style>
</head>
<body onload="loadpage('home.php')">
  <div class="d-flex">
      <div class="sidebar">
        <div class="logo text-center">
          <i class="bi bi-dribbble"></i>
          <small>SportSync</small>
        </div>
        <a href="#" onclick="loadPage('home.php')"><i class="bi bi-house-fill"></i></a>
        <a href="#" onclick="loadPage('review.php')"><i class="bi bi-star-fill"></i></a>
      </div>
      <div class="main flex-grow-1">
        <iframe id="main-frame" src="user.php" width="100%" height="1000px"></iframe>
      </div>
  </div>
<script>
    function loadPage(page) {
      document.getElementById("main-frame").src = page;
    }
</script>
</body>
</html>
