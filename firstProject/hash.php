<?php
// Function to encrypt a password
function encryptPassword($plainPassword, $encryptionKey) {
    $iv = openssl_random_pseudo_bytes(openssl_cipher_iv_length('AES-256-CBC'));
    $encryptedPassword = openssl_encrypt($plainPassword, 'AES-256-CBC', $encryptionKey, 0, $iv);
    return base64_encode($iv . $encryptedPassword);
}

// Function to decrypt a password
function decryptPassword($encryptedPassword, $encryptionKey) {
    $data = base64_decode($encryptedPassword);
    $ivLength = openssl_cipher_iv_length('AES-256-CBC');
    $iv = substr($data, 0, $ivLength);
    $encryptedPassword = substr($data, $ivLength);
    return openssl_decrypt($encryptedPassword, 'AES-256-CBC', $encryptionKey, 0, $iv);
}

// Define the encryption key
$encryptionKey = 'Y%z8@wD3!fG#7hJ2$';

// Handle form submissions
$decryptedPassword = '';
$encryptedPassword = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (isset($_POST['encryptPassword'])) {
        $plainPassword = $_POST['plainPassword'] ?? '';
        if ($plainPassword) {
            $encryptedPassword = encryptPassword($plainPassword, $encryptionKey);
        }
    } elseif (isset($_POST['decryptPassword'])) {
        $encryptedPasswordInput = $_POST['encryptedPassword'] ?? '';
        if ($encryptedPasswordInput) {
            $decryptedPassword = decryptPassword($encryptedPasswordInput, $encryptionKey);
        }
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Password Encryptor/Decryptor</title>
    <style>
        body {
            background-color: #121212;
            color: white;
            font-family: Arial, sans-serif;
            margin: 0;
            padding: 20px;
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100vh;
        }
        .container {
            max-width: 400px;
            width: 100%;
            background-color: #222;
            padding: 30px;
            border-radius: 8px;
            box-shadow: 0 0 15px rgba(255, 0, 0, 0.7);
            text-align: center;
        }
        h1, h2 {
            color: white;
            margin: 0 0 20px;
        }
        label {
            display: block;
            margin: 10px 0 5px;
            text-align: left;
        }
        textarea, input[type="text"] {
            width: calc(100% - 20px);
            padding: 10px;
            border: 1px solid red;
            border-radius: 4px;
            background-color: #333;
            color: white;
            font-size: 16px;
            margin-bottom: 15px;
            resize: none;
        }
        input[type="submit"] {
            background-color: red;
            color: white;
            border: none;
            padding: 10px;
            cursor: pointer;
            border-radius: 4px;
            font-size: 16px;
            transition: background-color 0.3s;
            width: 100%;
        }
        input[type="submit"]:hover {
            background-color: darkred;
        }
        .result {
            margin-top: 20px;
            background-color: #333;
            padding: 15px;
            border-radius: 4px;
            text-align: center;
            box-shadow: 0 0 10px rgba(255, 0, 0, 0.5);
        }
        .result p {
            margin: 0;
            font-weight: bold;
            color: #00FF00;
        }
    </style>
</head>
<body>
    <div class="container">
        <h1>Password Encryptor/Decryptor</h1>

        <form method="post">
            <label for="plainPassword">Plain Password:</label>
            <input type="text" id="plainPassword" name="plainPassword" required>
            <input type="submit" name="encryptPassword" value="Encrypt">
        </form>

        <?php if ($encryptedPassword): ?>
            <div class="result">
                <h2>Encrypted Password:</h2>
                <p><?php echo htmlspecialchars($encryptedPassword); ?></p>
            </div>
        <?php endif; ?>

        <form method="post" style="margin-top: 30px;">
            <label for="encryptedPassword">Encrypted Password:</label>
            <textarea id="encryptedPassword" name="encryptedPassword" rows="4" required></textarea>
            <input type="submit" name="decryptPassword" value="Decrypt">
        </form>

        <?php if ($decryptedPassword !== ''): ?>
            <div class="result">
                <h2>Decrypted Password:</h2>
                <p><?php echo htmlspecialchars($decryptedPassword); ?></p>
            </div>
        <?php endif; ?>
    </div>
</body>
</html>
