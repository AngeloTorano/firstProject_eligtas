<?php
include 'db.php';
include 'hash.php'; // Include the file with the encrypt/decrypt functions
session_start();

$error_message = "";
$encryptionKey = 'Y%z8@wD3!fG#7hJ2$';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Sanitize input
    $srCode = mysqli_real_escape_string($conn, $_POST['srcode']);
    $password = mysqli_real_escape_string($conn, $_POST['password']);

    // Fetch student info
    $studentSql = "SELECT * FROM studentinfo WHERE srCode = '$srCode'";
    $studentResult = mysqli_query($conn, $studentSql);

    if (mysqli_num_rows($studentResult) > 0) {
        $row = mysqli_fetch_assoc($studentResult);

        // Decrypt the stored password
        $decryptedPassword = decryptPassword($row['pass'], $encryptionKey);

        // Verify if the entered password matches the decrypted password
        if ($password === $decryptedPassword) {
            $_SESSION['srCode'] = $row['srCode'];
            $_SESSION['firstName'] = $row['firstName'];
            $_SESSION['role'] = 'student';

            header("Location: studentDashboard.php");
            exit();
        } else {
            $_SESSION['errorMessage'] = "Invalid password for student account.";
            header("Location: index.php");
            exit();
        }
    } else {
         // Fetch admin info if student not found
        $adminSql = "SELECT * FROM admininfo WHERE srCode = '$srCode'";
        $adminResult = mysqli_query($conn, $adminSql);
        if (mysqli_num_rows($adminResult) > 0) {
            $row = mysqli_fetch_assoc($adminResult);

            // Decrypt the stored password
            $decryptedPassword = decryptPassword($row['pass'], $encryptionKey);

            // Verify if the entered password matches the decrypted password
            if ($password === $decryptedPassword) {
                $_SESSION['srCode'] = $row['srCode'];
                $_SESSION['firstName'] = $row['firstName'];
                $_SESSION['role'] = 'admin';

                header("Location: adminDashboard.php");
                exit();
            } else {
                $_SESSION['errorMessage'] = "Invalid password for admin account.";
                header("Location: adminDashboard.php");
                exit();
            }
        } else {
            $_SESSION['errorMessage'] = "No account found with that Sr-Code.";
            header("Location: index.php");
            exit();
        }
    }
}

mysqli_close($conn);

if (!empty($error_message)) {
    echo "<script>alert('$error_message');</script>";
}
?>
