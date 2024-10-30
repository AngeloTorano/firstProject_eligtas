<?php
include 'db.php';

session_start();

$errorMessage = "";

if (isset($_SESSION['errorMessage'])) {
    $errorMessage = $_SESSION['errorMessage'];
    unset($_SESSION['errorMessage']); 
}

$srCode = isset($_SESSION['verifiedSrCode']) ? $_SESSION['verifiedSrCode'] : "";
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="style/studentRegister.css">
    <link href='https://fonts.googleapis.com/css?family=League Spartan' rel='stylesheet'>
    <title>Create Student Account</title>
    <style>
        .error {
            margin-left: 10px;
            color: red;
            font-size: 1.2rem;
        }
        .input{
            display: flex; 
            width: 100%; 
            gap: 15px;
            flex-direction: column; 
            align-items: center; 
            justify-content: center;
        }
        
    </style>
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
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
    <section id="studentRegistrationForm" style="height: 130vh;">
        <div style="padding-top: 1%; margin-top: 2%; background-color: white; width: 60%; border-radius: 2%;">
            <div sty><img src="style/img/accLogo.png" alt=""></div>
            <h1 style="font-size: larger; color: black;" id="create">CREATE STUDENT ACCOUNT</h1>
            <form id="createAccountForm" action="studentCreateAccount.php" method="POST">
                <div style="width: 60%; padding: 10px;">
                    <div class="input" style="">
                        <input type="hidden" id="studentSrCode" name="srCode" value="<?php echo htmlspecialchars($srCode); ?>" readonly>
    
                        <input type="text" class="form-control" id="fName" name="fName" placeholder="First Name" required>
            
                        <input type="text" class="form-control" id="lName" name="lName" placeholder="Last Name" required>
            
                        <input type="number" class="form-control" id="age" name="age" placeholder="Age" required>
            
                        <input type="text" class="form-control" id="gender" name="gender" placeholder="Gender" required>
            
                        <input type="text" class="form-control" id="address" name="address" placeholder="Address" required>
            
                        <input type="text" class="form-control" id="contactNumber" name="contactNumber" placeholder="Contact Number" required>

                        <div style="padding-left: 5rem; font-size: small; width: 100%; color: rgb(110, 104, 104); display: flex; flex-direction: column; justify-content: start; align-items: start;">

                            <ul style="text-align: start; text-decoration: none; list-style-type: none;"> 
                                <li><strong>Password must:</strong></li>
                                <li>8 characters long.</li>
                                <li>Atleast one uppercase letter.</li>
                                <li>Atleast one number.</li>
                                <li>Atleast one special character.</li>
                            </ul>
                        </div>
                        <input type="password" class="form-control" id="password" name="password" placeholder="Password" required>
                        <div id="passwordError" class="error"></div>
            
                        <input type="password" class="form-control" id="confirmPassword" name="confirmPassword" placeholder="Confirm Password" required>
                        <div id="confirmPasswordError" class="error"></div>
            
                        <div class="button-container">
                            <button style="background-color: transparent; border: 0; cursor: pointer; color: white;" type="submit" name="createAccount">Create Account</button>
                        </div>
                    </div>
        
                    <label style="color: black; font-size: small;" class="login" style="font-size: small;">
                        Already have an account?
                        <a href="index.php">Back to login</a>
                    </label>
                </form>
        
                <div class="error"><?php echo htmlspecialchars($errorMessage); ?></div>
                </div>
        </div>
    </section>
</center>

<script>
    $(document).ready(function () {
        function validatePassword() {
            let password = $('#password').val();
            let confirmPassword = $('#confirmPassword').val();
            let valid = true;

            $('#passwordError').text('');
            $('#confirmPasswordError').text('');

            if (password.length < 8) {
                $('#passwordError').text('Password must be at least 8 characters long.');
                valid = false;
            }

            if (!/[A-Z]/.test(password)) {
                $('#passwordError').text('Password must contain at least one uppercase letter.');
                valid = false;
            }

            if (!/[0-9]/.test(password)) {
                $('#passwordError').text('Password must contain at least one number.');
                valid = false;
            }

            if (!/[\W_]/.test(password)) {
                $('#passwordError').text('Password must contain at least one special character.');
                valid = false;
            }

            if (confirmPassword !== "") {
                if (password !== confirmPassword) {
                    $('#confirmPasswordError').text('Passwords do not match!');
                    valid = false;
                }
            }

            return valid;
        }

        $('#password, #confirmPassword').on('input', function () {
            validatePassword();
        });

        $('#createAccountForm').on('submit', function (event) {
            if (!validatePassword()) {
                event.preventDefault();
            }
        });
    });
</script>
<center>
    <footer class="footer">
        <hr style="height: 0.2rem; background-color: rgb(253, 253, 253); width: 100%; border: none; margin: auto;"/>
        <p style="color: rgb(255, 255, 255); margin: 10px 0; font-size: small;">
            Copyright &copy; 2024 All rights reserved E-ligtas
        </p>
    </footer>
</center>
</body>
</html>
