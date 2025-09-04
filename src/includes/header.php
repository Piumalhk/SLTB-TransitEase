
<style>
.header {
    background-color: #020260;
    color: white;
    padding: 15px 23px;
    display: flex;
    justify-content: space-between;
    align-items: center;
    flex-wrap: wrap;
}

.header-left, .header-right {
    display: flex;
    align-items: center;
}

.header-left {
    margin-right: auto;
}

.header-right {
    margin-left: auto;
}

.header-logo {
    height: 50px;
    margin: 0 10px;
}

.language {
    height: 35px;
    border-radius: 100px;
    border: 2px solid #fff;
    background-color: transparent;
    color: white;
    padding: 0 15px;
    cursor: pointer;
    font-family: 'Signika Negative', sans-serif;
    font-size: 1rem;
}

.admin-button {
    height: 35px;
    padding: 0 20px;
    background-color: white;
    color: black;
    cursor: pointer;
    transition: background-color 0.3s ease;
    border-radius: 100px;
    border: 3px solid #000000;
    font-family: 'Signika Negative', sans-serif;
    font-size: 1rem;
}

.admin-button:hover {
    background-color: #84C1FF;
}

.navbar {
    background-color: #84C1FF;
    color: black;
    display: flex;
    justify-content: space-between;
    align-items: center;
    padding: 10px 5%;
    flex-wrap: wrap;
}

.logo {
    display: flex;
    align-items: center;
    margin-bottom: 10px;
}

.logo img {
    height: 60px;
    margin-right: 10px;
}

.logo-text {
    font-family: 'Righteous', sans-serif;
    color: #002597;
    font-weight: 200;
    font-size: 22px;
}

.logo span {
    color: #F40404;
}

.nav-links {
    list-style-type: none;
    margin: 0;
    padding: 0;
    display: flex;
    font-family: 'Signika Negative', sans-serif;
    font-size: 23px;
    flex-wrap: wrap;
    justify-content: center;
}

.nav-links li {
    margin: 5px 15px;
}

.nav-links li a {
    text-decoration: none;
    color: black;
    transition: color 0.3s ease;
}

.nav-links li a:hover {
    color: white;
}

@media (max-width: 768px) {
    .header-main {
        flex-direction: column;
        text-align: center;
    }
    .logo {
        padding-right: 0;
        margin-bottom: 10px;
    }
    .nav-links {
        flex-direction: column;
        align-items: center;
    }
    .nav-links li {
        margin: 5px 0;
    }
}
</style>


<?php
// /includes/header.php
?>
<div class="header">
    <div class="header-left">
        <select name="language" id="language" class="language">
            <option value="sinhala">Sinhala</option>
            <option value="english">English</option>
        </select>
    </div>
    <img src="../assest/nee.png" alt="SLTB Logo" class="header-logo">
    <div class="header-right">
        <img src="../assest/kisspng-computer-icons-login-management-user-5ae155f3386149.6695613615247170432309-removebg-preview.png" alt="Admin Logo" width="100">
        <button class="admin-button" onclick="window.location.href='../admin/login.php'">ADMIN LOGIN</button>
    </div>
</div>

<nav class="navbar">
    <div class="logo">
        <img src="../assest/Bus-logo-temokate-on-transparent-background-PNG-removebg-preview.png" alt="Bus Logo">
        <div class="logo-text">SLTB-Transit<span>Ease</span></div>
    </div>
    <ul class="nav-links">
        <li><a href="index.php">Home</a></li>
        <li><a href="aboutus.php">About Us</a></li>
        <li><a href="#">Schedule</a></li>
        <li><a href="hotline.php">Hotline</a></li>
    </ul>
</nav>
