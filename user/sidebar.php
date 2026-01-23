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
    margin:0;
    padding:0;
    overflow:hidden; /* Prevent page scroll */
    background-color: var(--bg-dark);
    color: var(--card-bg);
    font-family: Arial, sans-serif;
}

.layout {
    display:flex;
    height:100vh;
    width:100vw;
}

.sidebar {
    background-color: rgb(73, 73, 73);
    color: #ffffff;
    width:10%;
    height:100vh;
    position:fixed;
    top:0;
    left:0;
    display:flex;
    flex-direction:column;
    align-items:center;
    padding-top:2rem;
}

.sidebar a {
    color: var(--highlight);
    margin:1rem 0;
    font-size:1.5rem;
    padding:0.5rem;
    border-radius:10px;
    text-decoration:none;
    transition:transform .3s, background-color .3s;
}

.sidebar a:hover {
    background-color:var(--bg-dark);
    color: var(--highlight);
    transform:scale(1.2);
}

.logo {
    color: #ffffff;
    font-size:1.2rem;
    margin-bottom:1rem;
    text-align:center;
}

#mainFrame {
    margin-left:10%;
    width:90%;
    height:100vh;
    border:none;
    overflow:auto; /* scroll ONLY inside iframe */
    background:var(--bg-dark);
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

        <a href="user_home.php" target="mainFrame" title="Explore">
            <i class="bi bi-search"></i>
        </a>

        <a href="user_settings.php" title="User Settings">
            <i class="bi bi-gear-fill"></i>
        </a>

        <a href="userbooking.php" target="mainFrame" title="Previous Bookings">
            <i class="bi bi-clock-history"></i>
        </a>

        <a href="../index.php" title="Home">
            <i class="bi bi-house-fill"></i>
        </a>
    </div>

    <iframe name="mainFrame" id="mainFrame" src="user_home.php"></iframe>

</div>

<?php include("../footer.php"); ?>

</body>
</html>
