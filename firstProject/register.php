<?php
session_start();
include 'db.php';

$errorMessage = "";
$srcodeError = "";

if (isset($_SESSION['errorMessage'])) {
    $errorMessage = $_SESSION['errorMessage'];
    unset($_SESSION['errorMessage']);
}

if (isset($_SESSION['srcodeError'])) {
    $srcodeError = $_SESSION['srcodeError'];
    unset($_SESSION['srcodeError']);
}

$role = "";
$srCode = "";
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    if (isset($_POST['verify'])) {
        $srCode = mysqli_real_escape_string($conn, $_POST['srcode']);
        
        $sql = "SELECT * FROM srcode WHERE srCode = '$srCode'";
        $result = mysqli_query($conn, $sql);

        if (mysqli_num_rows($result) > 0) {
            $row = mysqli_fetch_assoc($result);
            $role = $row['role'];

            if ($role === "student") {
                $accountCheckSql = "SELECT * FROM studentinfo WHERE srCode = '$srCode'";
            } elseif ($role === "admin") {
                $accountCheckSql = "SELECT * FROM admininfo WHERE srCode = '$srCode'";
            }

            $accountResult = mysqli_query($conn, $accountCheckSql);

            if (mysqli_num_rows($accountResult) > 0) {
                $_SESSION['errorMessage'] = "An account with this Sr-Code is already registered!";
                header("Location: register.php");
                exit();
            } else {
                if ($role === "student") {
                    $_SESSION['verifiedSrCode'] = $srCode;
                    header("Location: studentRegister.php");
                    exit();
                } elseif ($role === "admin") {
                    $_SESSION['verifiedSrCode'] = $srCode;
                    header("Location: adminRegister.php");
                    exit();
                }
            }
        } else {
            $_SESSION['srcodeError'] = "Sr-Code not found!";
            header("Location: register.php");
            exit();
        }
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href='https://fonts.googleapis.com/css?family=League Spartan' rel='stylesheet'>
    <link rel="stylesheet" href="style/register.css">
    <style>
        .error{
            color: red;
            font-size: medium;        }
    </style>
    <title>Create Account</title>

</head>
<body>
<section>
    <nav class="navbar">
        <a class="navbar-brand" href="#">E-ligtas</a>
        <ul class="navbar-nav">
            <li class="nav-item">
                <a class="nav-link active" aria-current="page" href="index.php">Home</a>
            </li>
            <li class="nav-item">
                <a class="nav-link" href="about.html">About Us</a>
            </li>
            <li class="nav-item">
                <a class="nav-link" href="help.html">Help</a>
            </li>
        </ul>
    </nav>
</section>

<center>
    <section>
            <div class="verifyContainer">
                <h1 id="register">VERIFY SR-CODE</h1>
                <form action="" method="POST">
                    <div class="srcode">
                        
                        <input type="text" id="form-control" name="srcode" placeholder="Sr-Code" required>
                    </div>
                    <br>
                    <div class="button-container">
                        <button type="submit" name="verify">Verify</button>
                    </div>
                </form>
            </div>
    </section>

<script>
        window.onload = function() {
        <?php if (!empty($errorMessage)): ?>
            alert("<?php echo addslashes($errorMessage); ?>");
        <?php endif; ?>

        <?php if (!empty($srcodeError)): ?>
            alert("<?php echo addslashes($srcodeError); ?>");
        <?php endif; ?>
        };
</script>
</center>

</body>
</html>
