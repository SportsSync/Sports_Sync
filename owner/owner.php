<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>SportSync Dashboard</title>

<!-- Bootstrap Icons CDN -->
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.1/font/bootstrap-icons.css">

<style>
/* ===== Global Styles ===== */
body {
  margin: 0;
  font-family: Arial, sans-serif;
  background-color: #111;
  color: white;
}

/* ===== Sidebar ===== */
.sidebar {
  position: fixed;
  top: 0;
  left: 0;
  width: 100px;
  height: 100vh;
  background: #a06a4a;
  display: flex;
  flex-direction: column;
  align-items: center;
  padding-top: 30px;
}

.sidebar-menu {
  list-style: none;
  padding: 0;
  width: 100%;
}

.sidebar-menu li {
  width: 100%;
  text-align: center;
  margin: 20px 0;
}

.sidebar-menu a {
  color: #d2ff52;
  text-decoration: none;
  font-size: 18px;
  display: block;
  padding: 10px;
}

.sidebar-menu a:hover {
  background: #8b5a3c;
}

/* Bootstrap Icons */
.icon {
  font-size: 20px;
  display: block;
  margin-bottom: 8px;
}

/* ===== Content Area ===== */
.content {
  margin-left: 150px;
  padding: 0;
}

iframe {
  width: 100%;
  height: 100vh;
  border: none;
  background: #111;
}
</style>
</head>

<body>

<!-- ===== Sidebar ===== -->
<div class="sidebar">
  <ul class="sidebar-menu">

    <li>
      <a href="#" onclick="loadPage('vendor_confirm.php')">
        <i class="bi bi-people-fill icon"></i>
        Users
      </a>
    </li>
    <li>
      <a href="#" onclick="loadPage('vendor.php')">
        <i class="bi bi-person-badge-fill icon"></i>
        Owners
      </a>
    </li>

    <li>
      <a href="#" onclick="loadPage('vendor_settings.php')">
        <i class="bi bi-gear-fill icon"></i>
        Settings
      </a>
    </li>
    <li>
      <a href="../index.php" onclick="">
        <i class="bi bi-house-fill icon"></i>
        Home
      </a>
    </li>
  </ul>
</div>

<div class="content">
  <iframe id="mainFrame" src="vendor_confirm.php"></iframe>
</div>

<script>
function loadPage(page) {
  document.getElementById("mainFrame").src = page;
}
</script>

</body>
</html>