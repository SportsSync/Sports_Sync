<?php
session_start();
?>
<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>SportSync Dashboard</title>

<!-- Bootstrap Icons CDN -->
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.1/font/bootstrap-icons.css">
<link rel="stylesheet" href="https://unpkg.com/aos@2.3.4/dist/aos.css">
<link href="../whole.css" rel="stylesheet">
<link rel="shortcut icon" href="../favicon.png" type="image/png">
<style>
 body { 
  background-color: #0e0f11; 
  background-image: linear-gradient(45deg, #1f1f1f 25%, transparent 25%), 
                    linear-gradient(-45deg, #1f1f1f 25%, transparent 25%), 
                    linear-gradient(45deg, transparent 75%, #1f1f1f 75%),
                    linear-gradient(-45deg, transparent 75%, #1f1f1f 75%); 
   background-size: 6px 6px; 
   background-position: 0 0, 0 3px, 3px -3px, -3px 0px; 
  } 

.layout {
  height: 100vh;
  width: 100vw;
}

.navbar-top {
  min-height: 72px;
  position: fixed;
  top: 0;
  left: 0;
  right: 0;
  background: linear-gradient(90deg,
      rgba(18, 18, 18, 0.98),
      rgba(18, 18, 18, 0.9));
  display: flex;
  align-items: center;
  justify-content: space-between;
  padding: 0 1.6rem;
  z-index: 1000;
  border-bottom: 1px solid rgba(149, 38, 243, 0.25);
  flex-wrap: nowrap;
}

.logo {
  color: #ffffff;
  opacity: 0.95;
  display: flex;
  align-items: center;
  gap: 0.65rem;
}

.logo i {
  font-size: 2rem;
  color: #ffffff;
}

.logo small {
  display: block;
  font-size: 0.7rem;
  letter-spacing: 0.6px;
  color: #bdbdbd;
}

.logoname {
  color: #ffffff;
}

.nav-links {
  position: absolute;
  top: calc(100% + 12px);
  right: 1.6rem;
  min-width: 240px;
  display: none;
  flex-direction: column;
  align-items: stretch;
  gap: 0.75rem;
  padding: 1rem;
  border-radius: 22px;
  background: rgba(18, 18, 18, 0.96);
  border: 1px solid rgba(149, 38, 243, 0.3);
  box-shadow: 0 20px 45px rgba(0, 0, 0, 0.35);
  backdrop-filter: blur(12px);
}

.menu-toggle {
  display: inline-flex;
  align-items: center;
  justify-content: center;
  width: 48px;
  height: 48px;
  border: 1px solid rgba(149, 38, 243, 0.45);
  border-radius: 14px;
  background: rgba(149, 38, 243, 0.12);
  color: #ffffff;
  font-size: 1.6rem;
  padding: 0;
  line-height: 1;
  transition: background 0.25s ease, border-color 0.25s ease, transform 0.25s ease;
}

.menu-toggle:hover {
  background: rgba(149, 38, 243, 0.22);
  border-color: rgba(180, 76, 255, 0.7);
  transform: translateY(-1px);
}

.menu-toggle:focus {
  outline: none;
  box-shadow: none;
}

.navbar-top.menu-open .nav-links {
  display: flex;
}

.navbar-top.menu-open .menu-toggle {
  background: rgba(149, 38, 243, 0.28);
  border-color: rgba(180, 76, 255, 0.8);
}

.navbar-top a {
  width: 100%;
  justify-content: flex-start;
  padding: 12px 16px;
  border-radius: 16px;
  display: flex;
  align-items: center;
  gap: 0.5rem;
  color: #9526F3;
  font-size: 1rem;
  text-decoration: none;
  border: 2px solid #9526F3;
  background: transparent;
  position: relative;
  overflow: hidden;
  cursor: pointer;
  transition: color 0.35s ease, box-shadow 0.35s ease;
}

.navbar-top a::before {
  content: "";
  position: absolute;
  inset: 0;
  background: linear-gradient(135deg, #9526F3, #7a1fd6, #b44cff);
  transform: scaleX(0);
  transform-origin: left;
  transition: transform 0.4s ease;
  z-index: 0;
}

.navbar-top a span {
  position: relative;
  z-index: 1;
  display: inline-flex;
  align-items: center;
  gap: 0.5rem;
}

.navbar-top a:hover {
  color: #ffffff;
  box-shadow: 0 0 18px rgba(149, 38, 243, 0.55);
}

.navbar-top a:hover::before {
  transform: scaleX(1);
}

.navbar-top a:focus,
.navbar-top a:active {
  outline: none;
  box-shadow: none;
}

.navbar-top a.active {
  background-color: transparent;
  border: 2px solid #9526F3;
  color: #ffffff;
}

#mainFrame {
  margin-top: 72px;
  width: 100%;
  height: calc(100vh - 72px);
  border: none;
  overflow-y: auto;
  background: var(--bg-dark);
}

#chatBadge {
  position: absolute;
  top: -6px;
  right: -10px;
  background: red;
  color: white;
  font-size: 10px;
  padding: 2px 6px;
  border-radius: 50%;
  display: none;
  z-index: 2;
}



@media (max-width: 991px) {
  .navbar-top {
    padding: 0.9rem 1rem;
    align-items: center;
  }

  .nav-links {
    width: 100%;
    right: 1rem;
    left: 1rem;
    min-width: 0;
  }

  #mainFrame {
    margin-top: 88px;
    height: calc(100vh - 88px);
  }
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
        <small>Owner Console</small>
      </div>
    </div>

    <button class="menu-toggle" type="button" id="menuToggle" aria-label="Toggle navigation" aria-expanded="false">
      <i class="bi bi-list"></i>
    </button>

    <div class="nav-links" id="ownerNavMenu">
      <a href="#" class="nav-menu-link active" data-page="vendor_confirm.php" onclick="loadPage('vendor_confirm.php'); return false;" title="Requests">
        <span><i class="bi bi-people-fill"></i>Requests</span>
      </a>

      <a href="#" class="nav-menu-link" data-page="my_turfs.php" onclick="loadPage('my_turfs.php'); return false;" title="My Turfs">
        <span><i class="bi bi-person-badge-fill"></i>My Turfs</span>
      </a>

      <a href="#" class="nav-menu-link" data-page="chat.php" onclick="loadPage('chat.php'); return false;" id="chatMenu" title="Chat">
        <span><i class="bi bi-chat-dots-fill"></i>Chat</span>
        <span id="chatBadge">0</span>
      </a>


      <a href="#" class="nav-menu-link" data-page="maintenance mode/maintenance.php" onclick="loadPage('maintenance mode/maintenance.php'); return false;" id="maintenace" title="Maintenance">
        <span><i class="bi bi-tools"></i>Maintenance</span>
      </a>

      <a href="#" class="nav-menu-link" data-page="reports/index.php" onclick="loadPage('reports/index.php'); return false;" title="Reports">
        <span><i class="bi bi-bar-chart-fill"></i>Reports</span>
      </a>

      <a href="../index.php" class="nav-menu-link" title="Home">
        <span><i class="bi bi-house-fill"></i>Home</span>
      </a>
    </div>
  </div>

  <iframe name="mainFrame" id="mainFrame" src="vendor_confirm.php"></iframe>
</div>



<script>
function loadPage(page) {
  document.getElementById("mainFrame").src = page;
}
function updateChatBadge() {
  fetch('../chat/get_unread_count.php')
  .then(res => res.json())
  .then(data => {
    let badge = document.getElementById("chatBadge");

    if(data.count > 0){
      badge.style.display = "inline-block";
      badge.innerText = data.count;
    } else {
      badge.style.display = "none";
    }
  });
}

// refresh every 5 sec
setInterval(updateChatBadge, 5000);
updateChatBadge();

const menuToggle = document.getElementById("menuToggle");
const navbarTop = document.querySelector(".navbar-top");
const navMenu = document.getElementById("ownerNavMenu");
const navLinks = document.querySelectorAll(".nav-menu-link");

if (menuToggle && navbarTop) {
  menuToggle.addEventListener("click", function () {
    const isOpen = navbarTop.classList.toggle("menu-open");
    menuToggle.setAttribute("aria-expanded", isOpen ? "true" : "false");
  });

  navLinks.forEach(function (link) {
    link.addEventListener("click", function () {
      const page = link.getAttribute("data-page");

      if (page) {
        navLinks.forEach(function (item) {
          item.classList.remove("active");
        });
        link.classList.add("active");
      }

      if (navMenu && navMenu.contains(link)) {
        navbarTop.classList.remove("menu-open");
        menuToggle.setAttribute("aria-expanded", "false");
      }
    });
  });
}

document.addEventListener("click", function (event) {
  if (!navbarTop || !navbarTop.classList.contains("menu-open")) {
    return;
  }

  if (!navbarTop.contains(event.target)) {
    navbarTop.classList.remove("menu-open");
    menuToggle.setAttribute("aria-expanded", "false");
  }
});
</script>

</body>
</html>
