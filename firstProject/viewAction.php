<?php
session_start();
include 'db.php';

// Check if the form was submitted via POST
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Retrieve form data
    $reportID = $_POST['reportID'];
    $dateAction = $_POST['date-time']; // Corrected to match input name
    $action = $_POST['action'];

    // Prepare SQL statement to update the report
    $stmt = mysqli_prepare($conn, "UPDATE studentreport SET date_action = ?, action = ? WHERE reportID = ?");
    mysqli_stmt_bind_param($stmt, "ssi", $dateAction, $action, $reportID);
    
    // Execute the update statement
    if (mysqli_stmt_execute($stmt)) {
        header("Location: studentReports.php"); // Redirect back with success message
    } else {
        echo "Error updating report: " . mysqli_error($conn);
    }

    // Close the prepared statement
    mysqli_stmt_close($stmt);
}

// Close the database connection
mysqli_close($conn);
?>
