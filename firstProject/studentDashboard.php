<?php
session_start();

$welcomeMessage = "";
if (isset($_SESSION['welcomeMessage'])) {
    $welcomeMessage = $_SESSION['welcomeMessage'];
    unset($_SESSION['welcomeMessage']);
} elseif (isset($_SESSION['firstName'])) { 
    $welcomeMessage = "Welcome back, " . htmlspecialchars($_SESSION['firstName']) . "!";
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="style/studentDashboard.css">
    <link href='https://fonts.googleapis.com/css?family=League Spartan' rel='stylesheet'>
    <title>E-Ligtas</title>
<style>
    html, body {
    margin: 0;
    height: 100%;
    color: #ffffff;
    }

    body {
        background: linear-gradient(to bottom, red, black);
        background-size: cover;
        background-position: center; 
        background-repeat: no-repeat;
        background-attachment: fixed;
        font-family: Arial, Helvetica, sans-serif;
    }
    .navbar {
        font-size: .2rem;
        color: #ffffff;
        height: 5rem;
        display: flex;
        justify-content: space-between;
        align-items: center;
        background-color: #e63a34;
        padding: 10px 20px;
        box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
    }

    .navbar-brand-container {
        display: flex;
        align-items: center;
    }

    .navbar-brand {
        font-weight: bold;
        font-size: .5rem; 
        color: #ffffff; 
        text-decoration: none; 
    }

    .navbar-divider {
        color: #ffffff; 
        margin-left: 10px;
    }

    .navbar-nav {
        list-style: none;
        margin: 0; 
        padding: 0; 
        display: flex;
    }

    .nav-item {
        margin-left: 20px;
    }

    .nav-link {
        font-size: large;
        color: #ffffff; 
        position: relative; 
        text-decoration: none;
        color: inherit;
        transition: background-color 0.3s ease, color 0.3s ease;
    }
    .nav-link::after {
        content: '';
        display: block;
        height: 2px;
        background-color: currentColor;
        position: absolute;
        left: 0;
        bottom: -5px;
        width: 0;
        transition: width 0.3s ease;
    }

    .nav-link:hover::after {
        width: 100%; 
    }

    .nav-link.active {
        color: black;
        font-weight: bold;
        border-radius: 5px; 
    }
    .container-fluid {
        height: auto;
        object-fit: cover;
    }
    .banner{
        height: 90vh;
        width: 100%;
        object-fit: cover;
    }
    .banner > img{
        height: 100%;
        width: 100%;
    }
    p {
        align-items: center;
    }

    .carouselSection {
        display: flex;
        justify-content: center;
        align-items: center;
        height: 100vh;
        background-color: transparent;
    }

    .carousel {
        position: relative;
        height: 60%;
        width: 90%;
        text-align: center;
        background-color: black;
        overflow: hidden;
    }

    .slides {
        display: flex;
        transition: transform 0.5s ease-in-out;
        object-fit: cover;
    }

    .slide {
        min-width: 100%;
        height: 100%;
        display: flex;
        justify-content: center;
        align-items: center;
    }

    .slides img {
        width: 100%;
        height: auto;
    }

    .prev, .next {
        cursor: pointer;
        position: absolute;
        top: 50%;
        transform: translateY(-50%);
        color: white;
        font-weight: bold;
        font-size: 24px;
        padding: 10px;
        background-color: rgba(0, 0, 0, 0.5);
        border: none;
        border-radius: 5px;
        transition: background-color 0.3s;
    }

    .prev:hover, .next:hover {
        background-color: rgba(0, 0, 0, 0.8);
    }

    .prev {
        left: 10px;
    }

    .next {
        right: 10px;
    }

    .caption {
        position: absolute;
        bottom: 20px;
        left: 50%;
        transform: translateX(-50%);
        color: white;
        font-size: 18px;
        background-color: rgba(0, 0, 0, 0.5);
        padding: 10px;
        border-radius: 5px;
    }

    .schoolLogo {
        padding-top: 1rem;
        display: flex;
        align-content: center;
        justify-content: center;
        gap: 1rem;
    }

    .cics, .bsu, .jpcs {
        height: 60px;
        width: 60px;
    }

    .announcementSection {
        height: 100vh;
        display: flex;
        flex-direction: column;
        justify-content: center;
        align-items: center;
        background-color: black;
        color: white;
        text-align: center;
    }

    .schoolLogo {
        display: flex;
        justify-content: center;
        margin-bottom: 20px;
    }

    .schoolLogo img {
        max-height: 70px;
        margin: 0 10px;
    }

    h1 {
        font-size: 2.5em;
        margin: 0;
    }

    .announcement {
        height: 60%;
        width: 80%;
        background-color: black;
        padding: 20px;
        margin-top: 20px;
        border: 1px solid white;
        margin-bottom: 10px;
    }

    .announcement p {
        margin: 0;
        font-size: 1.5em;
        text-align: center;
    }

    .containerInfo {
        margin: 80px;
        gap: 100px;
        padding: 1rem;
        font-family: 'League Spartan';
        display: flex; 
        justify-content: center; 
        align-items: center;
    }

    .info, .mvo {
        color: #000000;
    }

    .rButton {
        justify-content: center;
        align-items: center;
        padding: 10px 20px;
        font-size: 16px;
        font-family: 'League Spartan';
        color: rgb(37, 37, 37);
        background-color: #ffffff;
        border: none;
        border-radius: 5px;
        text-decoration: none;
        transition: background-color 0.3s ease;
        cursor: pointer;
        margin: 0 auto; 
        display: block;
    }
    .officers h2{
        display: flex; 
        justify-content: center; 
        align-items: center; 
        padding-top: 5%; 
        color: white;
        font-size: xx-large;
        font-family: 'League Spartan';
    }
    .officers a{
        color: #ffffff;
        display: flex; 
        justify-content: center; 
        align-items: center; 
        font-size: large;
        font-family: 'League Spartan';
    }
    .officers{
        padding-bottom: 6rem;
    }
    .head{
        height: 320px;
        width: 320px;
        display: flex;
        flex-direction: column;
        justify-content: center;
        align-items: center;
    }
    .head img{
        height: 100%; 
        width: 100%; 
        object-fit: cover; 
        border-radius: 50%;
        transition: all ease-in-out 0.3s;
    }
    .head h4{
        font-size: large;
    }
    .member{
        height: 250px; 
        width: 250px;
        display: flex;
        flex-direction: column;
        justify-content: center;
        align-items: center;
    }
    .member h5{
        font-size: large;
    }
    .member img{
        height: 100%; 
        width: 100%; 
        object-fit: cover; 
        border-radius: 50%;
        transition: all ease-in-out 0.3s;
    }

    .officers img:hover{
        transform: scale(1.1);
    }
    .info p, h5{
        text-align: justify; 
        font-size: x-large; 
    }
    .info{
        padding: 2rem;
        background-color: rgb(180, 164, 164);
        border-radius: 10px;
    }
    .mvo{
        font-family: 'League Spartan';
        font-size: large;
        color: rgba(255, 255, 255, 0.904);
        padding: 2rem;
        background-color: rgb(180, 164, 164);
        border-radius: 10px;
        
    }
    .mvo h5{
        text-align: center;
        color: #000000dc;
    }
    .mvo p{
        text-align: justify; 
        max-width: 600px; 
        font-size: x-large;
        color: #000000b6;
    }


    </style>
 
</head>
<body>
    <nav class="navbar">
        <div class="navbar-brand-container" style="gap: 1rem;">  
            <a class="navbar-brand" style="font-size: xx-large;" href="#">E-Ligtas</a>
        </div>
    
        <ul class="navbar-nav">
            <li class="nav-item">
                <a class="nav-link active"  href="studentDashboard.html">Home</a>
            </li>
            <li class="nav-item">
                <a class="nav-link"  href="studentProfile.php">Profile</a>
            </li>
            <li class="nav-item">
                <a class="nav-link"  aria-current="page" href="disaster.html">Disaster</a>
            </li>
            <li class="nav-item">
                <a class="nav-link" href="hotline.html">Emergency Hotlines</a>
            </li>
            <li class="nav-item">
                <a class="nav-link" href="report.html">Report</a>
            </li>
            <li class="nav-item">
                <a class="nav-link" href="index.php" onclick="return confirmLogout()">Log out</a>
            </li>
        </ul>
    </nav>
<section>
    <center>
        <div class="container-fluid">
            <div class="banner">
                <img src="style/img/banner.png" alt="">
            </div>
        </div>
    </center>
</section>
<section class="carouselSection">
    <div class="carousel" style="height: 70%; width: 80%; text-align: center; background-color: black;">
        <div class="slides">
            <div class="slide">
                <img src="style/img/1.jpg" alt="Slide 1">
            </div>
            <div class="slide">
                <img src="style/img/2.jpg" alt="Slide 2">
            </div>
            <div class="slide">
                <img src="style/img/3.jpg" alt="Slide 3">
            </div>
            <div class="slide">
                <img src="style/img/4.jpeg" alt="Slide 4">
            </div>
        </div>
        <button class="prev" onclick="moveSlide(-1)">&#10094;</button>
        <button class="next" onclick="moveSlide(1)">&#10095;</button>
    </div>      
</section>
<section class="announcementSection">
    <div class="schoolLogo">
        <div><img class="cics" src="style/img/accLogo.png" alt="CICS"></div>
        <div><img class="bsu" src="style/img/accLogo.png" alt="BSU"></div>
        <div><img class="jpcs" src="style/img/accLogo.png" alt="JPCS"></div>
    </div>
    <h1>ANNOUNCEMENT</h1>
    <div class="announcement">
        <p>dhas</p>
    </div>
</section>
<section>
    <div style="height: 40vh;">
        <div  class="containerInfo" >
            <div class="info" style="text-align: left;">
                <h5>What is Disaster Risk Management?</h5>
                <p>Disaster Risk Management (DRM) is a systematic approach aimed at reducing the risk and impact of disasters, which can be natural (like earthquakes, floods, and hurricanes) or human-made (such as industrial accidents or terrorism). The goal of DRM is to enhance the resilience of communities and ensure their preparedness for disasters.</p>
                <button class="rButton">Read more</button> 
            </div>
            <div class="info" style="text-align: left;">
                <h5>What is E-Ligtas?</h5>
                <p>Disaster Risk Management (DRM) is a systematic approach aimed at reducing the risk and impact of disasters, which can be natural (like earthquakes, floods, and hurricanes) or human-made (such as industrial accidents or terrorism). The goal of DRM is to enhance the resilience of communities and ensure their preparedness for disasters.</p>
                <button class="rButton">Read more</button>
            </div>
        </div>
        </div>
    </div>
</section>
<section>
    <div class="officers">
        <div style="height: 60vh; background-color: rgba(0, 0, 0, 0);">
            <h2>JPCS DRRM TEAM</h2>
            <a href="">Contact Us!</a>
            <div style="display: flex; justify-content: center; align-items: center; padding-top: 100px; gap: 9%;">
                <div class="head">
                    <img src="style/img/head.jpg" alt="">
                    <h4>Josh Alexandrei C. Sayat</h4>
                </div>
                <div class="member">
                    <img src="style/img/member1.jpg" alt="" style="height: 100%; width: 100%; object-fit: cover; border-radius: 50%;">
                    <h5>Shayne Ayesa G. Perez</h5>
                </div>
                <div class="member">
                    <img src="style/img/member2.jpg" alt="">
                    <h5>Karol Fernando II C. Bersuto</h5>
                </div>
                <div class="member">
                    <img src="style/img/member3.jpg" alt="">
                    <h5>Nathaniel H. Macalinao</h5>
                </div>
            </div>
        </div>
    </div>
</section>

<section>
    <div style="height: 60vh;">
        <div  class="containerInfo" >
            <div class="mvo">
                <h5>JPCS Mission</h5>
                <p style="text-align: justify; max-width: 800px; font-size: x-large;">Disaster Risk Management (DRM) is a systematic approach aimed at reducing the risk and impact of disasters, which can be natural (like earthquakes, floods, and hurricanes) or human-made (such as industrial accidents or terrorism). The goal of DRM is to enhance the resilience of communities and ensure their preparedness for disasters.</p>
            </div>
            <div class="mvo" style="text-align: center;">
                <h5>JPCS Vision</h5>
                <p style="text-align: justify; max-width: 800px; font-size: x-large;">Disaster Risk Management (DRM) is a systematic approach aimed at reducing the risk and impact of disasters, which can be natural (like earthquakes, floods, and hurricanes) or human-made (such as industrial accidents or terrorism). The goal of DRM is to enhance the resilience of communities and ensure their preparedness for disasters.</p>
            </div>
            <div class="mvo" style="text-align: center;">
                <h5>JPCS Objectives</h5>
                <p style="text-align: justify; max-width: 800px; font-size: x-large;">Disaster Risk Management (DRM) is a systematic approach aimed at reducing the risk and impact of disasters, which can be natural (like earthquakes, floods, and hurricanes) or human-made (such as industrial accidents or terrorism). The goal of DRM is to enhance the resilience of communities and ensure their preparedness for disasters.</p>  
            </div>
        </div>
        </div>
    </div>
</section>

<script>
    let currentIndex = 0;

    function moveSlide(n) {
        const slides = document.querySelector('.slides');
        const totalSlides = document.querySelectorAll('.slide').length;

        currentIndex += n;

        if (currentIndex >= totalSlides) {
            currentIndex = 0;
        } else if (currentIndex < 0) {
            currentIndex = totalSlides - 1;
        }

        slides.style.transform = `translateX(-${currentIndex * 100}%)`;
    }
</script>
<script>
        window.onload = function() {
            <?php if (!empty($welcomeMessage)): ?>
                alert("<?php echo addslashes($welcomeMessage); ?>");
            <?php endif; ?>
        };
</script>
<script>
function confirmLogout() {
    return confirm("Are you sure you want to log out?");
}
</script>
    <center>
        <footer style="text-align: center; padding: 1rem 0;">
            <hr style="height: 0.2rem; background-color: rgb(253, 253, 253); width: 100%; border: none; margin: auto;"/>
            <p style="color: rgb(255, 255, 255); margin: 10px 0; font-size: small;">
                Copyright &copy; 2024 All rights reserved E-ligtas
            </p>
        </footer>  
    </center>
</body>
</html>
