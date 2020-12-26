<?php

require_once 'includes/php/classes/DB.php';
require_once 'includes/php/classes/UsersController.php';
require_once 'includes/php/classes/ArticlesController.php';
require_once 'includes/php/classes/CategoriesController.php';

$db = new DB();
$userController = new UsersController();
$articlesController = new ArticlesController();
$categoriesController = new CategoriesController();
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

if (isset($_GET['page'])) {
    $page_no = $_GET['page'];
} else {
    $page_no = '1';
}

$categories = $categoriesController->getCategories();

$records_per_page = 10;
$offset = ($page_no - 1) * $records_per_page;
$total_records = $articlesController->getNumberOfArticles();
$total_pages = ceil($total_records / $records_per_page);

if (isset($_GET['cat_id'])) {
    $cat_id = $_GET['cat_id'];
    if ($categoriesController->isValidCategoryId($cat_id)) {
        $cat_name = $categoriesController->searchById($cat_id)['cat_name'];
        $articles = $articlesController->getArticlesByCategory($cat_id);
    } else {
        $valid_cat_id = false;
        $cat_id = 0;
        $articles = $articlesController->getArticles($offset, $records_per_page);
    }
} else {
    $valid_cat_id = false;
    $cat_id = 0;
    $articles = $articlesController->getArticles($offset, $records_per_page);
}

if (isset($_GET['del_res'])) {
    if ($_GET['del_res'] == 'success') {
        $del_res = 'success';
    } else {
        $del_res = 'failure';
    }
} else {
    $del_res = '';
}

if (isset($_GET['add_res'])) {
    $add_res = $_GET['add_res'];
} else {
    $add_res = '';
}

?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Articles</title>

    <link rel="stylesheet" href="includes/css/font-nunito-styles.css">
    <link rel="stylesheet" href="includes/css/header-styles.css">
    <link rel="stylesheet" href="includes/css/articles-styles.css">
    <link rel="stylesheet" href="includes/css/scrollbar-styles.css">
    <link rel="stylesheet" href="includes/css/footer-styles.css">

    <script src="includes/js/articles-script.js" defer></script>

</head>

<body>
    <input type="hidden" id="del-res" value="<?php echo $del_res; ?>">
    <input type="hidden" id="add-res" value="<?php echo $add_res; ?>">
    <!-- CONTENT -->
    <div class="main-container">

        <!-- NAVBAR -->
        <header class="header">
            <?php include 'includes/php/header.php'; ?>
        </header>

        <!-- SECTIONS -->
        <div class="main-section">
            <!-- LIST OF NEWS ARTICLES HERE -->
            <div class="article-section-heading">
                <h1>Articles</h1>
                <?php
                if (strtoupper($user_type) == 'ADMIN') {
                    echo '<a class="add-article-btn" href="new_article.php">Add Article</a>';
                }
                ?>
                <input type="hidden" id="cat-id" value="<?php echo $cat_id ?>">
                <form action="articles.php" class="filter-form" method="GET">
                    <select class="filter-input" id="filter-cat-id" name="cat_id">
                        <option value="0">All</option>
                        <?php
                        foreach ($categories as $category) {
                            echo '<option value="' . $category['cat_id'] . '">' . $category['cat_name'] . '</option>';
                        }
                        ?>
                    </select>
                    <button class="filter-btn" type="submit">Filter</button>
                </form>
            </div>

            <div class="article-section">

                <?php
                if (sizeof($articles) == 0) {
                    echo '<p class="no-article-text">There Are No Articles For Now...</p>';
                }
                foreach ($articles as $article) {
                ?>
                    <div class="article-container">
                        <div class="article">
                            <div class="article-left-section">
                                <h3 class="article-title"><?php echo $article['a_title'] ?></h3>
                                <p class="article-description">
                                    <?php echo substr($article['a_description'], 0, 50) ?>
                                </p>
                            </div>
                            <div class="article-right-section">
                                <?php
                                if (strtoupper($user_type) == 'ADMIN') {
                                ?>
                                    <a class="article-action-btn article-edit-btn" href="edit-article.php?edit_id=<?php echo $article['a_id'] ?>">Edit</a>
                                    <a class="article-action-btn article-delete-btn" href="article.php?del_id=<?php echo $article['a_id'] ?>">Delete</a>
                                <?php
                                }
                                ?>
                                <a class="article-action-btn article-view-btn" href="article.php?a_id=<?php echo $article['a_id'] ?>">View</a>
                            </div>
                        </div>
                    </div>
                <?php
                }

                ?>

                <!-- <div class="article-container">
                    <div class="article">
                        <div class="article-left-section">
                            <h3 class="article-title">Article Title</h3>
                            <p class="article-description">
                                Some description here
                            </p>
                        </div>
                        <div class="article-right-section">
                            <a class="article-view-btn" href="article.php">View</a>
                        </div>
                    </div>
                </div> -->

            </div>
            <?php
            if ($cat_id == 0) {
            ?>
                <div class="pagination-navbar">
                    <a href="?page=1" class="pagination-link">1</a>
                    <?php
                    for ($i = 2; $i <= intval($total_pages); $i++) {
                        echo '<a href="?page=' . $i . '" class="pagination-link">' . $i . '</a>';
                    }
                    ?>
                </div>
            <?php
            }
            ?>
        </div>

        <!-- FOOTER -->
        <?php include 'includes/php/footer.php'; ?>
    </div>
</body>


</html>