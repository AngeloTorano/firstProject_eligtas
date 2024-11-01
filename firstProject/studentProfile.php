<?php
session_start();
include 'db.php';

$errorMessage = "";
$srCode = isset($_SESSION['srCode']) ? $_SESSION['srCode'] : "";
$firstName = "";
$lastName = "";
$age = 0;
$gender = "";
$address = "";  
$contactNumber = "";

if (!empty($srCode)) {
    $sql = "SELECT * FROM studentinfo WHERE srCode = '$srCode'";
    $result = mysqli_query($conn, $sql);
    
    if ($result && mysqli_num_rows($result) > 0) {
        $row = mysqli_fetch_assoc($result);
        $firstName = $row['firstName'];
        $lastName = $row['lastName'];
        $age = $row['age'];
        $gender = $row['gender'];
        $address = $row['address'];
        $contactNumber = $row['contactNumber'];
    } else {
        $errorMessage = "Error fetching profile data.";
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="style/studentProfile.css">
    <link href='https://fonts.googleapis.com/css?family=League Spartan' rel='stylesheet'>
    <title>E-Ligtas</title>
 
</head>
<body>
<section>
    <nav class="navbar">
        <div class="navbar-brand-container" style="gap: 1rem;">  
            <a class="navbar-brand" style="font-size: xx-large;" href="#">E-Ligtas</a>
        </div>
    
        <ul class="navbar-nav">
            <li class="nav-item">
                <a class="nav-link"  href="studentDashboard.html">Home</a>
            </li>
            <li class="nav-item">
                <a class="nav-link active"  href="studentProfile.html">Profile</a>
            </li>
            <li class="nav-item">
                <a class="nav-link"  aria-current="page" href="disaster.html">Disaster</a>
            </li>
            <li class="nav-item">
                <a class="nav-link " href="hotline.html">Emergency Hotlines</a>
            </li>
            <li class="nav-item">
                <a class="nav-link" href="report.html">Report</a>
            </li>
            <li class="nav-item">
                <a class="nav-link" href="index.php" onclick="return confirmLogout()">Log out</a>
            </li>
        </ul>
    </nav>
</section>

<section>
    <div class="profile">
        <div style="margin: 3%; padding: 5%; background-color: black;">
            <h1>My Profile</h1>
            <div style="display: flex; gap: 50px;">
                <div>
                    <h5>First Name:     </h5>
                    <h5>Last Name:      </h5>
                    <h5>Age:            </h5>
                    <h5>Gender:         </h5>
                    <h5>Current Address:</h5>
                    <h5>Contact Number: </h5>
                </div>
                <div>
                    <h5><?php echo htmlspecialchars($firstName); ?></h5>
                    <h5><?php echo htmlspecialchars($lastName); ?></h5>
                    <h5><?php echo htmlspecialchars($age); ?></h5>
                    <h5><?php echo htmlspecialchars($gender); ?></h5>
                    <h5><?php echo htmlspecialchars($address); ?></h5>
                    <h5><?php echo htmlspecialchars($contactNumber); ?></h5>
                </div>
            </div>
            <div style="display: flex; justify-content: flex-end; gap: 1rem; margin-right: 5%;">
                <button class="btn-profile">Edit Personal Information</button>
                <button class="btn-profile">Activity Log</button>
                <button class="btn-profile">Reset password</button>

                <form action="deleteStudentAccount.php">
                    <button class="btn-delete" >Delete Account</button>
                </form>

            </div>
        </div>
    </div>
</section>
<script>
function confirmLogout() {
    return confirm("Are you sure you want to log out?");
}
</script>

<center>
    <footer class="footer">
        <hr style="height: 0.2rem; background-color: rgb(253, 253, 253); width: 100%; border: none; margin: auto;"/>
        <p style="color: rgb(255, 255, 255); margin: 10px 0; font-size: small;">
            Copyright &copy; 2024 All rights reserved E-ligtas
        </p>
    </footer>
    
</center>

</section>
</body>
</html>
