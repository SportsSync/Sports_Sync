<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1">
<title>Elite Grounds</title>

<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css">
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.css">
<link href="../whole.css" rel="stylesheet">
<link rel="shortcut icon" href="../favicon.png" type="image/png">
<style>

/* ================= BODY ================= */
/* =======================
   GLOBAL
======================= */
body {
  margin: 0;
  padding: 0;
  background: var(--bg-dark);
  color: var(--text-light);
  font-family: 'Segoe UI', system-ui, sans-serif;
  overflow-x: hidden;
}

/* =======================
   LAYOUT
======================= */
.layout {
  display: flex;
  height: 100vh;
  width: 100vw;
}

/* =======================
   SIDEBAR
======================= */
.sidebar {
  width: 96px;
  height: 100vh;
  position: fixed;
  top: 0;
  left: 0;
  background: linear-gradient(
    180deg,
    rgba(18,18,18,0.98),
    rgba(18,18,18,0.9)
  );
  display: flex;
  flex-direction: column;
  align-items: center;
  padding-top: 1.6rem;
  z-index: 1000;
  box-shadow: 6px 0 28px rgba(202,255,51,0.25);
  border-right: 1px solid var(--border-soft);
}

/* =======================
   LOGO
======================= */
.logo {
  text-align: center;
  margin-bottom: 2.2rem;
  color: var(--text-light);
  opacity: 0.95;
}

.logo i {
  font-size: 2.1rem;
  color: var(--highlight);
}

.logo small {
  display: block;
  font-size: 0.7rem;
  letter-spacing: 0.6px;
  color: var(--muted-text);
  margin-top: 4px;
}

/* =======================
   SIDEBAR LINKS
======================= */
.sidebar a {
  width: 56px;
  height: 56px;
  margin: 0.55rem 0;
  border-radius: 16px;
  display: flex;
  align-items: center;
  justify-content: center;
  color: var(--muted-text);
  font-size: 1.6rem;
  text-decoration: none;
  transition: 
    background 0.25s ease,
    color 0.25s ease,
    transform 0.2s ease,
    box-shadow 0.25s ease;
}

.sidebar a:hover {
  background: rgba(202,255,51,0.15);
  color: var(--highlight);
  transform: scale(1.08);
  box-shadow: 0 0 14px rgba(202,255,51,0.35);
}

.sidebar a.active {
  background: var(--highlight);
  color: #111;
  box-shadow: 0 0 18px rgba(202,255,51,0.55);
}

/* =======================
   MAIN FRAME
======================= */
#mainFrame {
  margin-left: 96px;
  width: calc(100% - 96px);
  height: 100vh;
  border: none;
  overflow-y: auto;
  background: var(--bg-dark);
}


</style>
</head>

<body>

<div class="layout">

    <div class="sidebar">
        <div class="logo">
            <i class="bi bi-dribbble"></i><br>
            <small>SportSync</small>
        </div>

        <a href="user_home.php" class="active" target="mainFrame" title="Explore">
            <i class="bi bi-search"></i>
        </a>

        <a href="user_settings.php" class="active" title="User Settings">
            <i class="bi bi-gear-fill"></i>
        </a>

        <a href="userbooking.php" class="active" target="mainFrame" title="Previous Bookings">
            <i class="bi bi-clock-history"></i>
        </a>

        <a href="../index.php" class="active" title="Home">
            <i class="bi bi-house-fill"></i>
        </a>
    </div>

    <iframe name="mainFrame" id="mainFrame" src="user_home.php"></iframe>

</div>

<?php include("../footer.php"); ?>

</body>
</html>
