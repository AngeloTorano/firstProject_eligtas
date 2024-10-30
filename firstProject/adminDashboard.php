<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
    <link href='https://fonts.googleapis.com/css?family=League Spartan' rel='stylesheet'>
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <title>Document</title>

    <style>
html, body {
    margin: 0;
    height: 100%;
}

body {
    margin: 0;
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

.monitor{
    display: flex;
    justify-content: center;
    align-items: center;
    height: 70vh;
}

.chart{
    height: 90%;
    width: 80%;
    background-color: #ffffff;
}

.containerInfo {
    margin: 70px;
    gap: 100px;
    font-family: 'League Spartan';
    display: flex; 
    justify-content: center; 
    align-items: center;
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
    font-size: x-large;
}
.mvo p{
    text-align: justify;    
    font-size: x-large;
    color: #000000b6;
}
#myChart {
    max-width: 400px;
    margin: auto;
    display: flex;
    justify-content: center;
    align-items: center;
}


.officers h2{
    display: flex; 
    justify-content: center; 
    align-items: center; 
    color: white;
    font-size: xx-large;
    font-family: 'League Spartan';
}
.officers{
    color: #ffffff;
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
    </style>
</head>
<body>
    <nav class="navbar">
        <div class="navbar-brand-container" style="gap: 1rem;">  
            <a class="navbar-brand" style="font-size: xx-large;" href="#">E-Ligtas</a>
        </div>
    
        <ul class="navbar-nav">
            <li class="nav-item">
                <a class="nav-link active"  href="adminDashboard.html">Home</a>
            </li>
            <li class="nav-item">
                <a class="nav-link"  href="adminProfile.html">Profile</a>
            </li>
            <li class="nav-item">
                <a class="nav-link"  aria-current="page" href="studentAccounts.php">Management</a>
            </li>
            <li class="nav-item">
                <a class="nav-link" href="announcement.html">Announcement</a>
            </li>
            <li class="nav-item">
                <a class="nav-link" href="adminLog.html">Activity Log</a>
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
    <section>
        <div>
            <div class="monitor">
                <div class="chart">
                    <canvas id="myChart"></canvas>
                </div>
            </div>
        </div>
        <div style="height: 50vh;">
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
    <section>
        <div class="officers">
            <div style="height: 60vh; background-color: rgba(0, 0, 0, 0);">
                <h2>OUR TEAM</h2>
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
    <center>
        <footer style="text-align: center; padding: 1rem 0;">
            <hr style="height: 0.2rem; background-color: rgb(253, 253, 253); width: 100%; border: none; margin: auto;"/>
            <p style="color: rgb(255, 255, 255); margin: 10px 0; font-size: small;">
                Copyright &copy; 2024 All rights reserved E-ligtas
            </p>
        </footer>
    </center>

    <script>
        function confirmLogout() {
        return confirm("Are you sure you want to log out?");
        
        }
    </script>
    <script>
        const ctx = document.getElementById('myChart').getContext('2d');
        const myChart = new Chart(ctx, {
            type: 'pie',
            data: {
                labels: ['Safe', 'Unsafe', 'Abstain'],
                datasets: [{
                    label: 'Safety Ratings',
                    data: [60, 25, 15], // Example data
                    backgroundColor: [
                        'rgba(75, 192, 192, 0.6)',
                        'rgba(255, 99, 132, 0.6)',
                        'rgba(255, 206, 86, 0.6)'
                    ],
                    borderColor: [
                        'rgba(75, 192, 192, 1)',
                        'rgba(255, 99, 132, 1)',
                        'rgba(255, 206, 86, 1)'
                    ],
                    borderWidth: 1
                }]
            },
            options: {
                responsive: true,
                plugins: {
                    legend: {
                        position: 'top',
                    },
                    tooltip: {
                        callbacks: {
                            label: function(tooltipItem) {
                                return tooltipItem.label + ': ' + tooltipItem.raw + '%';
                            }
                        }
                    }
                }
            }
        });
    </script>
</body>
</html>