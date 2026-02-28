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
  height: 100vh;
  width: 100vw;
}

/* =======================
   NAVBAR
======================= */
.navbar-top {
  height: 72px;
  position: fixed;
  top: 0;
  left: 0;
  right: 0;
  background: linear-gradient(
    90deg,
    rgba(18,18,18,0.98),
    rgba(18,18,18,0.9)
  );
  display: flex;
  align-items: center;
  justify-content: space-between;
  padding: 0 1.6rem;
  z-index: 1000;
  border-bottom: 1px solid var(--border-soft);
}
.navbar-top:hover{
  box-shadow: 0 6px 28px rgba(149, 38, 243, 0.25);
}

/* =======================
   LOGO
======================= */
.logo {
  color: var(--text-light);
  opacity: 0.95;
  display: flex;
  align-items: center;
  gap: 0.65rem;
}

.logo i {
  font-size: 2rem;
  color: #ffff;
}

.logo small {
  font-size: 0.7rem;
  letter-spacing: 0.6px;
  color: var(--muted-text);
}
.logoname{
  color: #ffff;
}


/* =======================
   NAV LINKS
======================= */
.nav-links {
  display: flex;
  align-items: center;
  gap: 0.9rem;
}

.navbar-top a {
  padding: 0.55rem 0.85rem;
  border-radius: 12px;
  display: inline-flex;
  align-items: center;
  gap: 0.5rem;
  color: var(--muted-text);
  font-size: 1rem;
  text-decoration: none;
  transition:
    background 0.25s ease,
    color 0.25s ease,
    transform 0.2s ease,
    box-shadow 0.25s ease;
}

.navbar-top a:hover {
  background: rgba(149, 38, 243, 0.55);
  color: #9526F3;
  transform: scale(1.04);
  box-shadow: 0 0 14px rgba(149, 38, 243, 0.25);
}

.navbar-top a.active {
  background-color: transparent; 
  border: 2px solid #9526F3; 
  border-radius: 25px; 
  color: #ffffff;
  /*box-shadow: 0 0 18px rgba(149, 38, 243, 0.55);*/
}

/* =======================
   MAIN FRAME
======================= */
#mainFrame {
  margin-top: 72px;
  width: 100%;
  height: calc(100vh - 72px);
  border: none;
  overflow-y: auto;
  background: var(--bg-dark);
}


</style>
</head>

<body>

<div class="layout">

    <div class="navbar-top">
        <div class="logo">
            <i class="bi bi-dribbble"></i>
            <div class="logoname">
                SportSync
                <small>Elite Grounds</small>
            </div>
        </div>

        <div class="nav-links">
            <a href="user_home.php" class="active" target="mainFrame" title="Explore">
                <i class="bi bi-search"></i>
                Explore
            </a>

            <a href="user_settings.php" class="active" title="User Settings">
                <i class="bi bi-gear-fill"></i>
                Settings
            </a>

            <a href="userbooking.php" class="active" target="mainFrame" title="Previous Bookings">
                <i class="bi bi-clock-history"></i>
                Bookings
            </a>

            <a href="../index.php" class="active" title="Home">
                <i class="bi bi-house-fill"></i>
                Home
            </a>
        </div>
    </div>

    <iframe name="mainFrame" id="mainFrame" src="user_home.php"></iframe>

</div>

<?php include("../footer.php"); ?>

</body>
</html>
