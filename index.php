<?php

require_once 'includes/php/classes/DB.php';
require_once 'includes/php/classes/UsersController.php';
require_once 'includes/php/classes/ArticlesController.php';
require_once 'includes/php/classes/CommentsController.php';

$db = new DB();
$userController = new UsersController();
$articlesController = new ArticlesController();
$commentsController = new CommentsController();
$total_articles = $articlesController->getNumberOfArticles();
$total_users = $userController->getNumberOfUsers();
$total_comments = $commentsController->getNumberOfComments();

$db->connect();

session_start();
if (isset($_SESSION['user_email'])) {
    $user = $userController->searchByEmail($_SESSION['user_email']);
    $user_name = $user->getUsername();
    $user_type = $user->getUsertype();
} else {
    $user_name = '';
    $user_type = 'user';
}

?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Home</title>

    <link rel="stylesheet" href="includes/css/font-nunito-styles.css">
    <link rel="stylesheet" href="includes/css/header-styles.css">
    <link rel="stylesheet" href="includes/css/home-styles.css">
    <link rel="stylesheet" href="includes/css/scrollbar-styles.css">
    <link rel="stylesheet" href="includes/css/footer-styles.css">
    <script src="includes/js/home-script.js" defer></script>
</head>

<body>

    <!-- CONTENT -->
    <div class="main-container">

        <!-- NAVBAR -->
        <header class="header">
            <?php include 'includes/php/header.php'; ?>
        </header>

        <!-- SECTIONS -->
        <div class="main-section">

            <!-- TOP SECTION -->
            <div class="section top-section">
                <div class="section-image-container">
                    <img src="includes/images/home-news.png" class="section-image" alt="NEWS">
                </div>
                <div class="section-caption">Read All the News with the Click of A Button</div>
                <div class="section-button-container">
                    <a class="section-button get-started-btn" href="articles.php">Get Started</a>
                </div>
            </div>

            <!-- MIDDLE SECTION -->
            <div class="section middle-section-container">
                <div class="section-caption">Website Stats</div>
                <div class="middle-section">
                    <div class="section-card">
                        <div class="card-heading">Posts</div>
                        <div class="card-body">
                            <h1 class="card-data-numbers"><?php echo $total_articles; ?></h1>
                            <div class="card-description">We gained a lot of news articles/posts over the time.</div>
                        </div>
                    </div>
                    <div class="section-card">
                        <div class="card-heading">Users</div>
                        <div class="card-body">
                            <h1 class="card-data-numbers"><?php echo $total_users ?></h1>
                            <div class="card-description">The Number of people moved up quite a bit.</div>
                        </div>
                    </div>
                    <div class="section-card">
                        <div class="card-heading">Comments</div>
                        <div class="card-body">
                            <h1 class="card-data-numbers"><?php echo $total_comments ?></h1>
                            <div class="card-description">Interesting articles attracted interesting people with their interesting ideas in the form of comments.</div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- JOIN US SECTION -->
            <div class="join-us-section">
                <div class="section-caption join-us">Join Us Now!</div>
                <div class="section-button-container">
                    <a class="section-button join-us-button" href="user/register.php">Register</a>
                </div>
            </div>

            <!-- FOOTER -->
            <?php include 'includes/php/footer.php'; ?>
        </div>

    </div>

</body>

</html>