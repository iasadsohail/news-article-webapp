<?php

session_start();

if(isset($_SESSION['user_email'])) {
    header('Location: ../');
}


?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login</title>

    <link rel="stylesheet" href="../includes/css/login-styles.css">
    <script type="text/javascript" src="../includes/js/login-script.js" defer></script>
</head>

<body>
    <header class="top-header">
        <a class="go-home-btn" href="../">Home</a>
        <a class="go-home-btn" href="register.php">Register</a>
    </header>

    <!-- LOGIN CARD -->
    <div class="main-container">
        <form method="POST" id="login-form">
            <h1 class="form-heading">Login</h1>
            <input type="email" class="form-input" id="email" placeholder="you@yourdomain" required><br>
            <input type="password" class="form-input" id="password" placeholder="Password" required><br>
            <div class="submit-btn-container">
                <button type="submit" class="form-submit" id="submit-btn">Login</button>
            </div>
        </form>
    </div>
    
</body>

</html>