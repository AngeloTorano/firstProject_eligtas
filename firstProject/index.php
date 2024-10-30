<?php
session_start();

$errorMessage = "";
$welcomeMessage = "";
if (isset($_SESSION['welcomeMessage'])) {
    $welcomeMessage = $_SESSION['welcomeMessage'];
    unset($_SESSION['welcomeMessage']);
}


if (isset($_SESSION['errorMessage'])) {
    $errorMessage = $_SESSION['errorMessage'];
    unset($_SESSION['errorMessage']); 
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href='https://fonts.googleapis.com/css?family=League Spartan' rel='stylesheet'>
    <link rel="stylesheet" href="style/index-s.css">
    <style>
        .main{
            display: flex;
            justify-content: center;
            align-items: center;
            gap: 30rem;
        }
        .logo {
    perspective: 1000px; /* Adds perspective to the container */
}

.logo img {
    margin: 12rem 0 0 10rem;
    height: 500px; 
    width: 500px; 
    border-radius: 50%;
    transition: transform ease-in-out 0.6s; /* Adjust transition for a smoother effect */
    transform-style: preserve-3d; /* Ensures child elements retain their 3D transformations */
}

.logo img:hover {
    transform: rotateY(180deg); /* Flips the image */
}

    </style>
    <title>E-Ligtas</title>
</head>
<body>
<section>
    <nav class="navbar">
        <a class="navbar-brand" href="#">E-ligtas</a>
        <ul class="navbar-nav">
            <li class="nav-item">
                <a class="nav-link active" aria-current="page" href="index.html">Home</a>
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

<section>
    <div class="main">
        <div class="logo" style="">
                <img src="style/img/logo.png" alt="">
        </div>
        <form class="formLogin" action="login.php" method="POST">
            <div class="loginContainer">
                <h1 id="login">LOGIN</h1>
            
                <div class="loginInput">
                    <input type="text" class="form-control" id="srcode" name="srcode" placeholder="Sr-Code" required>
                </div>
                <br>
            
                <div class="loginInput">
                    <input type="password" class="form-control" id="password" name="password" placeholder="Password" required>
                </div>
                <div class="loginInput">
                    <label class="terms">
                        <input type="checkbox" id="terms" name="terms" required>
                        I agree to the 
                        <a href="terms.html">Terms and Conditions</a>
                    </label>
                </div>
                <br>
                <div class="button-container">
                    <button id="loginButton" type="submit">Log In</button>
                </div>
                <div class="loginInput">
                    <label class="createAccount">
                        <a href="register.php">Create Account</a>
                    </label>
                </div>
            </div> 
        </form>
    </div>
</section>

<script>
        window.onload = function() {
            <?php if (!empty($welcomeMessage)): ?>
                alert("<?php echo addslashes($welcomeMessage); ?>");
            <?php endif; ?>
        };
</script>
<script>
    <?php if (!empty($errorMessage)): ?>
        alert('<?php echo $errorMessage; ?>');
    <?php endif; ?>
</script>
</body>
</html>
