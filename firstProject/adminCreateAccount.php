<?php
session_start();
include 'db.php';
include 'hash.php';

$errorMessage = "";
$srCode = isset($_SESSION['verifiedSrCode']) ? $_SESSION['verifiedSrCode'] : "";
$firstName = "";
$lastName = "";
$age = 0;
$gender = "";
$position = "";
$contactNumber = "";
$password = "";
$confirmPassword = "";
$srCodeID = 0;

$passwordError = "";
$confirmPasswordError = "";
$srCodeError = "";

$encryptionKey = 'Y%z8@wD3!fG#7hJ2$';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Sanitize and trim input
    $srCode = trim(mysqli_real_escape_string($conn, $_POST['srCode']));
    $firstName = mysqli_real_escape_string($conn, $_POST['fName']);
    $lastName = mysqli_real_escape_string($conn, $_POST['lName']);
    $age = intval($_POST['age']);
    $gender = mysqli_real_escape_string($conn, $_POST['gender']);
    $position = mysqli_real_escape_string($conn, $_POST['position']);
    $contactNumber = mysqli_real_escape_string($conn, $_POST['contactNumber']);
    $password = mysqli_real_escape_string($conn, $_POST['password']);
    $confirmPassword = mysqli_real_escape_string($conn, $_POST['confirmPassword']);

    // Check password match
    if ($password !== $confirmPassword) {
        $confirmPasswordError = "Passwords do not match!";
    } else {
        // Fetch srCodeID
        $sql = "SELECT srCodeID FROM srcode WHERE srCode = '$srCode'";
        $result = mysqli_query($conn, $sql);

        if (mysqli_num_rows($result) > 0) {
            $row = mysqli_fetch_assoc($result);
            $srCodeID = $row['srCodeID'];

            // Encrypt the password
            $encryptedPassword = encryptPassword($password, $encryptionKey);

            // Insert data into admininfo
            $insertSql = "INSERT INTO admininfo (srCode, fName, lName, age, gender, position, contactNumber, pass, srCodeID) 
                          VALUES ('$srCode', '$firstName', '$lastName', $age, '$gender', '$position', '$contactNumber', '$encryptedPassword', $srCodeID)";

            if (mysqli_query($conn, $insertSql)) {
                $_SESSION['welcomeMessage'] = "Welcome Admin, $firstName! Your account has been successfully created.";
                $_SESSION['firstName'] = $firstName;

                header("Location: index.php");
                exit();
            } else {
                $errorMessage = "Error inserting data: " . mysqli_error($conn);
                echo "<script>alert('$errorMessage');</script>";
            }
        } else {
            $srCodeError = "Invalid Sr-Code!";
            echo "<script>alert('$srCodeError');</script>";
        }
    }
}

mysqli_close($conn);
?>
