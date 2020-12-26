<?php

require_once '../includes/php/classes/DB.php';
require_once '../includes/php/classes/UsersController.php';

$db = new DB();
$userController = new UsersController();

$db->connect();

session_start();
if (isset($_SESSION['user_email'])) {
    $user = $userController->searchByEmail($_SESSION['user_email']);
    $user_name = $user->getUsername();
    $user_type = $user->getUsertype();
    if ($user_type != 'admin') {
        header('Location: ../');
    }
} else {
    header('Location: ../');
}

?>


<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Panel</title>

    <link rel="stylesheet" href="../includes/css/font-nunito-styles.css">
    <link rel="stylesheet" href="../includes/css/header-styles.css">
    <link rel="stylesheet" href="../includes/css/scrollbar-styles.css">
    <link rel="stylesheet" href="admin-styles.css">
</head>

<body>
    <!-- CONTENT -->
    <div class="main-container">

        <!-- NAVBAR -->
        <header class="header">
            <?php include 'header.php'; ?>
        </header>

        <!-- SECTIONS -->
        <div class="main-section">
            <div class="dashboard-section">
                <a class="section-button" href="categories.php">View Categories</a> <br>
                <a class="section-button" href="../articles.php">View Articles</a>
                <hr>
            </div>
        </div>

    </div>
</body>

</html>