<?php
session_start();
include 'db.php';

// Check if reportID is provided in the URL
if (isset($_GET['reportID'])) {
    $reportID = $_GET['reportID'];

    // Prepare SQL statement to fetch the report
    $stmt = mysqli_prepare($conn, "SELECT * FROM studentreport WHERE reportID = ?");
    mysqli_stmt_bind_param($stmt, "i", $reportID);
    mysqli_stmt_execute($stmt);
    $result = mysqli_stmt_get_result($stmt);

    // Fetch the report data
    $report = mysqli_fetch_assoc($result);

    // Close the prepared statement
    mysqli_stmt_close($stmt);
} else {
    // Handle case where reportID is not provided
    die('Report ID not provided.');
}

// Close the database connection
mysqli_close($conn);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
    <link href='https://fonts.googleapis.com/css?family=League Spartan' rel='stylesheet'>
    <link rel="stylesheet" href="">
    <title>Document</title>

    <style>
        html, body {
            margin: 0;  
            height: 100%;
            font-family: 'League Spartan';
        }

        body {
            margin: 0;
            background: linear-gradient(to bottom, red, black);
            background-size: cover;
            background-position: center; 
            background-repeat: no-repeat;
            background-attachment: fixed;
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

        .form-group{
            margin-bottom: 15px; /* Space between form groups */
            font-size: 20px;
        }
        #situation{
            font-size: 100px;
        }

        label {
            display: block; /* Make labels block-level */
            margin-bottom: 5px; /* Space between label and input */
        }

        input[type="text"],
        select  {
            width: 100%; /* Full width */   
            padding: 10px; /* Padding inside inputs */
            border: none; /* Border around inputs */
            border-radius: 4px; /* Rounded corners */
            box-sizing: border-box; /* Include padding in total width */
            font-size: medium;
            color: black;
        }
        #date-time{
            width: 100%; /* Full width */   
            padding: 10px; /* Padding inside inputs */
            border: none; /* Border around inputs */
            border-radius: 4px; /* Rounded corners */
            box-sizing: border-box; /* Include padding in total width */
            font-size: medium;
            color: black;
        }
        #date-time1{
            width: 100%; /* Full width */   
            padding: 10px; /* Padding inside inputs */
            border: 1px solid #ccc; /* Border around inputs */
            border-radius: 4px; /* Rounded corners */
            box-sizing: border-box; /* Include padding in total width */
            font-size: medium;
            color: black;
        }
        #disaster-type > option {
            color: black;
        }
        input::placeholder {
            position: absolute;
            top: 10px; /* Adjust as needed */
            left: 10px; /* Adjust as needed */
            color: #aaa; /* Placeholder color */
            font-size: 16px; /* Placeholder font size */
            transform: translateY(0); /* Ensure it stays in place */
        }
        button {
            background-color: #e63a34; /* Button background color */
            color: white; /* Button text color */
            border: none; /* Remove default border */
            border-radius: 5px; /* Rounded corners */
            padding: 10px; /* Padding inside button */
            cursor: pointer; /* Pointer cursor on hover */
            width: 30%; /* Full width */  
            font-size: medium;
        }

        button:hover {
            background-color: #c52f29; /* Darker shade on hover */
        }

        .report-form{
            width: 70%;
            margin: 2rem 0 5rem 0;
        }

        .report{
            display: flex;
            align-items: center;
            justify-content: center;
            border-radius: 10px;
            background-color: hwb(0 100% 0%);
            width: 60vw;
            margin: 3rem 0 5rem 25rem;
        }

        .head{
            font-size: xx-large;
            display: flex;
            justify-content: center;
        }

        .form-group textarea {
            height: 150px; /* Set the height as needed */
            width: 100%; /* Full width */
            padding: 10px; /* Padding inside the textarea */
            border: 1px solid #ccc; /* Border around textarea */
            border-radius: 4px; /* Rounded corners */
            box-sizing: border-box; /* Include padding in total width */
            font-size: medium;
            color: black;
            vertical-align: top; /* Align text to the top */
            resize: none; /* Prevent resizing if desired */
        }
        #situation{
            height: 150px;width: 100%; /* Full width */
            padding: 10px; /* Padding inside the textarea */
            border-radius: 4px; /* Rounded corners */
            border: none;
            box-sizing: border-box; /* Include padding in total width */
            font-size: large;
            color: black;
            vertical-align: top; /* Align text to the top */
            resize: none; /* Prevent resizing if desired */
        }


    </style>
</head>
<body>
    <section>
        <nav class="navbar">
            <div class="navbar-brand-container" style="gap: 1rem;">  
                <a href="studentReports.php"><i class="fa fa-arrow-left" style="font-size:36px; color: white"></i></a>
                <a class="navbar-brand" style="font-size: xx-large;" href="#">Reports</a>
            </div>
        
            <ul class="navbar-nav">
                <li class="nav-item">
                    <a class="nav-link"  href="adminDashboard.html">Home</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link"  href="">Profile</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link  active"  aria-current="page" href="#">Management</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="#">Announcement</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="#">Activity Log</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="" onclick="return confirmLogout()">Log out</a>
                </li>
            </ul>
        </nav>
    </section>
    

    <section>
        <div class="report">
            <form class="report-form" method="POST" action="viewAction.php">
                <input type="hidden" placeholder="reportID" id="reportID" name="reportID" value="<?php echo htmlspecialchars($report['reportID']); ?>" readonly>
                <h3 class="head">Students' Report</h3>
                <div class="form-group">  
                    <label for="Name"><strong>Name:</strong></label>  
                    <input type="text" placeholder="Name" id="name" name="name" value="<?php echo htmlspecialchars($report['name']); ?>" readonly>
                </div>
                <div class="form-group">
                    <label for="disaster-type"><strong>Type of Disaster:</strong></label>  
                    <input type="text" placeholder="Type of Disaster" id="disaster-type" name="disaster-type" value="<?php echo htmlspecialchars($report['disasterType']); ?>" readonly>
                </div>
                <div class="form-group">
                    <label for="contact-num"><strong>Contact Number:</strong></label>  
                    <input type="text" placeholder="Contact Number" id="contact-num" name="contact-num" value="<?php echo htmlspecialchars($report['contactNumber']); ?>" readonly>
                </div>
                <div class="form-group">
                    <label for="location"><strong>Location:</strong></label>  
                    <input type="text" placeholder="Location" id="location" name="location" value="<?php echo htmlspecialchars($report['location']); ?>" readonly>
                </div>
                <div class="form-group">
                    <label for="situation"><strong>Situation:</strong></label>
                    <textarea style="border: none; font-size: 24px; id="situation" name="situation" placeholder="Current Situation" required readonly><?php echo htmlspecialchars($report['situation']); ?></textarea>
                </div>
                <div class="form-group">
                    <label for="datetime"><strong>Date Reported:</strong></label>  
                    <input type="datetime" placeholder="Date Reported" id="date-time" name="date-time" value="<?php echo htmlspecialchars($report['date_reported']); ?>" readonly>
                </div>
                <div class="form-group">
                <label for="date-time1"><strong>Date Action Taken:</strong></label>
                     <?php if (empty($report['action'])): ?>
                        <input type="datetime-local" id="date-time1" name="date-time" required>
                      <?php else: ?>
                        <input style="border: none;" type="datetime"  id="date-time1" name="date-time" value="<?php echo htmlspecialchars($report['date_action']); ?>" readonly>
                      <?php endif; ?>
                 </div>

                <div class="form-group">
                    <label for="action"><strong>Action Taken:</strong></label>
                    <?php if (empty($report['action'])): ?>
                        <textarea id="action" name="action" placeholder="Action" required></textarea>
                    <?php else: ?>
                        <textarea  style="border: none; font-size: 24px; " id="action" name="action" readonly><?php echo htmlspecialchars($report['action']); ?></textarea>
                    <?php endif; ?>
                </div>

                <center><button type="submit">Submit</button></center>
            </form>
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
</body>
</html>