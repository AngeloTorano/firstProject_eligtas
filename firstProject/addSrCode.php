<?php
session_start();
include 'db.php';

$errorMessage = "";
$srCode = "";
$role = "";

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Sanitize and trim input
    $srCode = trim(mysqli_real_escape_string($conn, $_POST['srcode']));
    $role = mysqli_real_escape_string($conn, $_POST['role']);

    // Check for any potential validation errors
    if (empty($srCode) || empty($role)) {
        $errorMessage = "Please fill in all fields.";
    } else {
        // Check if srCode already exists
        $checkSql = "SELECT srCodeID FROM srcode WHERE srCode = '$srCode'";
        $checkResult = mysqli_query($conn, $checkSql);

        if (mysqli_num_rows($checkResult) > 0) {
            $errorMessage = "Sr-Code already exists!";
            echo "<script>alert('$errorMessage');</script>";
        } else {
            // Insert data into srcode
            $insertSql = "INSERT INTO srcode (srCode, role) 
                          VALUES ('$srCode', '$role')";

            if (mysqli_query($conn, $insertSql)) {
                $_SESSION['message'] = "Sr-Code added successfully!!";
                header("Location: srcode.php");
                exit();
            } else {
                $errorMessage = "Error inserting data: " . mysqli_error($conn);
                echo "<script>alert('$errorMessage');</script>";
            }
        }
    }
}

mysqli_close($conn);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href='https://fonts.googleapis.com/css?family=League Spartan' rel='stylesheet'>
    <link rel="stylesheet" href="style/management/addSrCode.css">
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
                <a class="nav-link"  href="adminDashboard.php">Home</a>
            </li>
            <li class="nav-item">
                <a class="nav-link"  href="adminProfile.php">Profile</a>
            </li>
            <li class="nav-item">
                <a class="nav-link  active"  aria-current="page" href="management.php">Management</a>
            </li>
            <li class="nav-item">
                <a class="nav-link" href="announcement.php">Announcement</a>
            </li>
            <li class="nav-item">
                <a class="nav-link" href="adminLog.php">Activity Log</a>
            </li>
            <li class="nav-item">
                <a class="nav-link" href="" onclick="return confirmLogout()">Log out</a>
            </li>
        </ul>
    </nav>
</section>
<section">
<div class="view-all">
    <a class="btn" href="srcode.php">View All Sr-Code</a>
</div>
</section>
<section>
    <div class="report">
        <form class="report-form" method="post" action="">
            <h3 class="head">Add Sr-Code</h3>

            <div class="form-group">
                <input class="form-control" type="text" placeholder="Sr Code" id="srcode" name="srcode" required>
            </div>
 
            <div class="form-group">
                <select id="role" name="role" required>
                    <option value="" disabled selected hidden>Role</option>
                    <option value="admin">Admin</option>
                    <option value="student">Student</option>
                   
                </select>
            </div>
            <center><button type="submit">ADD</button></center>
        </form>
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
