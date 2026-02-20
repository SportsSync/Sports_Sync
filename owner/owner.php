<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>SportSync Dashboard</title>

<!-- Bootstrap Icons CDN -->
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.1/font/bootstrap-icons.css">
<link rel="stylesheet" href="https://unpkg.com/aos@2.3.4/dist/aos.css">
<link rel="shortcut icon" href="../favicon.png" type="image/png">
<style>
/* ===== Global Styles ===== */
body {
  background-color: #0e0f11; 
  background-image: linear-gradient(45deg, #1f1f1f 25%, transparent 25%), 
                    linear-gradient(-45deg, #1f1f1f 25%, transparent 25%), 
                    linear-gradient(45deg, transparent 75%, #1f1f1f 75%),
                    linear-gradient(-45deg, transparent 75%, #1f1f1f 75%); 
   background-size: 6px 6px; 
   background-position: 0 0, 0 3px, 3px -3px, -3px 0px; 
}

/* ===== Sidebar ===== */
.sidebar {
  position: fixed;
  top: 0;
  left: 0;
  width: 100px;
  height: 100vh;
  background: linear-gradient(180deg, #0b1220, #020617);
  display: flex;
  flex-direction: column;
  align-items: center;
  padding-top: 30px;
  box-shadow: 4px 0 25px rgba(0,0,0,0.6);
  border-right: 1px solid rgba(59,130,246,0.15);
}

.sidebar-menu {
  list-style: none;
  padding: 0;
  width: 100%;
}

/* MENU ITEMS */
.sidebar-menu li {
  width: 100%;
  text-align: center;
  margin: 18px 0;
}

.sidebar-menu a {
  color: #94a3b8;
  text-decoration: none;
  font-size: 18px;
  display: block;
  padding: 12px 0;
  transition: all .25s ease;
  position: relative;
}

/* ICON */
.icon {
  font-size: 20px;
  display: block;
  margin-bottom: 6px;
}

/* HOVER + ACTIVE FEEL */
.sidebar-menu a:hover {
  color: #3b82f6;
  background: rgba(59,130,246,0.08);
}

.sidebar-menu a:hover::before {
  content: '';
  position: absolute;
  left: 0;
  top: 0;
  width: 3px;
  height: 100%;
  background: #3b82f6;
  border-radius: 0 4px 4px 0;
}

/* ===== Content Area ===== */
.content {
  margin-left: 100px;
  padding: 0;
}

iframe {
  width: 100%;
  height: 100vh;
  border: none;
  background: transparent;
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
        Requests
      </a>
    </li>
    <li>
      <a href="#" onclick="loadPage('my_turfs.php')">
        <i class="bi bi-person-badge-fill icon"></i>
        My Turfs
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
