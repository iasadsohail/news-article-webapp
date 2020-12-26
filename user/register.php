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
    <title>Register</title>

    <link rel="stylesheet" href="../includes/css/register-styles.css">
    <script type="text/javascript" src="../includes/js/register-script.js" defer></script>
</head>

<body>
    <header class="top-header">
        <a class="go-home-btn" href="../">Home</a>
        <a class="go-home-btn" href="login.php">Login</a>
    </header>

    <!-- LOGIN CARD -->
    <div class="main-container">
        <form method="POST" id="login-form">
            <h1 class="form-heading">Register</h1>
            <input type="text" class="form-input" id="name" placeholder="e.g John Carter" required><br>
            <input type="email" class="form-input" id="email" placeholder="you@yourdomain" required><br>
            <input type="password" class="form-input" id="password" placeholder="Password" required><br>
            <input type="password" class="form-input" id="re-password" placeholder="Retype Password" required><br>
            <div class="submit-btn-container">
                <button type="submit" class="form-submit" id="submit-btn">Register</button>
            </div>
        </form>
    </div>
    
</body>

</html>