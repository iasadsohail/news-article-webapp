<?php

require_once 'includes/php/classes/DB.php';
require_once 'includes/php/classes/Article.php';
require_once 'includes/php/classes/UsersController.php';
require_once 'includes/php/classes/ArticlesController.php';
require_once 'includes/php/classes/CategoriesController.php';

$db = new DB();
$userController = new UsersController();
$categoriesController = new CategoriesController();

$db->connect();

session_start();
if (isset($_SESSION['user_email'])) {
    $user = $userController->searchByEmail($_SESSION['user_email']);
    $user_name = $user->getUsername();
    $user_type = $user->getUsertype();
    $user_id = $user->getUserId();
    if ($user_type != 'admin') {
        header('Location: articles.php');
    } else {
        $categories = $categoriesController->getCategories();
    }
} else {
    header('Location: index.php');
}

if (isset($_POST['submit'])) {
    $title = addslashes($_POST['title']);
    $category_id = $_POST['cat_id'];
    $description = addslashes($_POST['description']);

    $file = $_FILES['file'];

    $file_name = $file['name'];
    $file_tmp_name = $file['tmp_name'];
    $file_size = $file['size'];
    $file_error = $file['error'];
    $file_type = $file['type'];

    $fileExt = explode('.', $file_name);
    $fileActualExt = strtolower(end($fileExt));

    $allowed_formats = array('image/jpg', 'image/jpeg', 'image/png');

    if (!in_array($fileActualExt, $allowed_formats)) {
        if ($file_error === 0) {
            if ($file_size < 5000000) {

                $timestamp = date('Y-m-d H:i:s');
                $img_address = $user_id . '__' . uniqid() . '.' . $fileActualExt;

                $article = new Article();
                $article->setUserId($user_id);
                $article->setCategoryId($category_id);
                $article->setArticleTitle($title);
                $article->setArticleDescription($description);
                $article->setArticleTimestamp($timestamp);
                $article->setArticleImgAddress($img_address);

                $articleController = new ArticlesController();
                if ($articleController->insertArticle($article)) {
                    move_uploaded_file($file_tmp_name, 'images/' . $img_address);
                    echo "<script> window.location.assign('articles.php?add_res=success') </script>";
                } else {
                    header('Location: new_article.php?add_res=failure');
                }
            } else {
                header('Location: new_article.php?add_res=large_size');
            }
        } else {
            header('Location: new_article.php?add_res=undefined');
        }
    } else {
        header('Location: new_article.php?add_res=wrong_format');
    }
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
    <title>New Article</title>

    <link rel="stylesheet" href="includes/css/font-nunito-styles.css">
    <link rel="stylesheet" href="includes/css/header-styles.css">
    <link rel="stylesheet" href="includes/css/new-article-styles.css">
    <link rel="stylesheet" href="includes/css/scrollbar-styles.css">
    <link rel="stylesheet" href="includes/css/footer-styles.css">

    <script src="includes/js/new-article-script.js" defer></script>
</head>

<body>

    <input type="hidden" id="add-res" value="<?php echo $add_res ?>">
    <!-- CONTENT -->
    <div class="main-container">

        <!-- NAVBAR -->
        <header class="header">
            <?php include 'includes/php/header.php'; ?>
        </header>

        <!-- SECTIONS -->
        <div class="main-section">
            <h1 class="form-heading">New Article</h1>
            <form action="new_article.php" method="POST" class="new-article-form" enctype="multipart/form-data">
                <div class="form-group">
                    <label id="form-label" for="category">Article Category: </label>
                    <select class="article-category" name="cat_id" id="category" required>
                        <option value="">--Select Category--</option>
                        <?php
                        foreach ($categories as $category) {
                            echo '<option value="' . $category['cat_id'] . '">' . $category['cat_name'] . '</option>';
                        }
                        ?>
                    </select>
                </div>
                <div class="form-group">
                    <label id="form-label" for="title">Article Title: </label>
                    <input type="text" class="form-input article-title" id="title" name="title" requried>
                </div>
                <div class="form-group">
                    <label id="form-label" for="image">Article Image: </label>
                    <input type="file" class="form-input article-image" id="file" name="file" required>
                </div>
                <div class="form-group">
                    <label id="form-label" for="description">Article Description: </label>
                    <textarea type="text" class="form-input article-description" rows="20" id="description" name="description" required></textarea>
                </div>
                <div class="form-group">
                    <button type="submit" name="submit" class="form-submit">Submit</button>
                </div>
            </form>
        </div>

        <!-- FOOTER -->
        <?php include 'includes/php/footer.php'; ?>
    </div>
</body>

</html>