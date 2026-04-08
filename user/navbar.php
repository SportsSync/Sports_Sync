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
  background-color: #0e0f11; 
  background-image: linear-gradient(45deg, #1f1f1f 25%, transparent 25%), 
                    linear-gradient(-45deg, #1f1f1f 25%, transparent 25%), 
                    linear-gradient(45deg, transparent 75%, #1f1f1f 75%),
                    linear-gradient(-45deg, transparent 75%, #1f1f1f 75%); 
   background-size: 6px 6px; 
   background-position: 0 0, 0 3px, 3px -3px, -3px 0px; 
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
            border-bottom: 1px solid var(--border-soft);
            flex-wrap: wrap;
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

        .logoname {
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

        .menu-toggle {
            display: none;
            border: none;
            background: transparent;
            color: #ffffff;
            font-size: 1.8rem;
            padding: 0.25rem 0.4rem;
            line-height: 1;
        }

        .menu-toggle:focus {
            outline: none;
            box-shadow: none;
        }

        .navbar-top a {
            padding: 10px 26px;
            border-radius: 25px;
            display: inline-flex;
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
            transition:
                color 0.35s ease,
                box-shadow 0.35s ease;
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
            border-radius: 25px;
            color: #ffffff;
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

        @media (max-width: 991px) {
            .navbar-top {
                padding: 0.9rem 1rem;
                align-items: center;
            }

            .menu-toggle {
                display: inline-flex;
                align-items: center;
                justify-content: center;
            }

            .nav-links {
                display: none;
                width: 100%;
                flex-direction: column;
                align-items: stretch;
                gap: 0.75rem;
                padding: 1rem 0 0.25rem;
            }

            .navbar-top.menu-open .nav-links {
                display: flex;
            }

            .navbar-top a {
                width: 100%;
                justify-content: center;
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
                    <small>Elite Grounds</small>
                </div>
            </div>

            <button class="menu-toggle" type="button" id="menuToggle" aria-label="Toggle navigation" aria-expanded="false">
                <i class="bi bi-list"></i>
            </button>

            <div class="nav-links">
                <a href="user_home.php" class="active" target="mainFrame" title="Explore">
                    <span><i class="bi bi-search"></i>Explore</span>
                </a>

                <a href="user_settings.php" class="active" title="User Settings">
                    <span><i class="bi bi-gear-fill"></i>Settings</span>
                </a>

                <a href="userbooking.php" class="active" target="mainFrame" title="Previous Bookings">
                    <span><i class="bi bi-clock-history"></i>Bookings</span>
                </a>

                <a href="../index.php" class="active" title="Home">
                    <span><i class="bi bi-house-fill"></i>Home</span>
                </a>
            </div>
        </div>

        <iframe name="mainFrame" id="mainFrame" src="user_home.php"></iframe>

    </div>

    <?php include("../footer.php"); ?>

    <script>
        const menuToggle = document.getElementById("menuToggle");
        const navbarTop = document.querySelector(".navbar-top");
        const navLinks = document.querySelectorAll(".nav-links a");

        if (menuToggle && navbarTop) {
            menuToggle.addEventListener("click", function () {
                const isOpen = navbarTop.classList.toggle("menu-open");
                menuToggle.setAttribute("aria-expanded", isOpen ? "true" : "false");
            });

            navLinks.forEach(function (link) {
                link.addEventListener("click", function () {
                    if (window.innerWidth <= 991) {
                        navbarTop.classList.remove("menu-open");
                        menuToggle.setAttribute("aria-expanded", "false");
                    }
                });
            });
        }
    </script>

</body>

</html>
