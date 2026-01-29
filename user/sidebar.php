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

body {
    margin: 0;
    padding: 0;
    background-color:#000000;
    color: var(--card-bg);
    font-family: Arial, sans-serif;
    overflow-x: hidden; /* allow vertical scroll */
}

.layout {
    display:flex;
    height:100vh;
    width:100vw;
}

.sidebar {
     background: linear-gradient(
        180deg,
        #000000 0%,
        #000000 100%
    );
    color: #ffffff;
    width: 96px;              
    height: 100vh;
    position: fixed;
    top: 0;
    left: 0;
    display: flex;
    flex-direction: column;
    align-items: center;
    padding-top: 1.5rem;
    z-index: 1000;
    box-shadow: 4px 0 20px #9526F3;
}

.sidebar a {
    display: flex;
    align-items: center;
    justify-content: center;
    width: 56px;
    height: 56px;
    margin: 0.5rem 0;
    border-radius: 14px;
    color: #ffffff; /* neutral default */
    font-size: 1.6rem;
    text-decoration: none;
    transition: 
        background-color 0.25s ease,
        color 0.25s ease,
        transform 0.2s ease;
}

.sidebar a:hover {
    background-color: #9526F3;
    color: #9526F3; /* brand purple */
    transform: scale(1.08);
}
.sidebar a.active {
    background-color: #000000;
    color: #ffffff;
}

.logo {
    color: #ffffff;
    font-size:1.2rem;
    margin-bottom:2rem;
    text-align:center;
    opacity: 0.9;
}

.logo i {
    font-size: 2rem;
    color: #ffffff;
}

.logo small {
    color: #e0e0e0;
    letter-spacing: 0.5px;
}   
#mainFrame {
    margin-left: 96px;
    width: calc(100% - 96px);
    height: 100vh;
    border: none;
    overflow: auto;
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
