<?php

require_once 'includes/php/classes/DB.php';
require_once 'includes/php/classes/Article.php';
require_once 'includes/php/classes/UsersController.php';
require_once 'includes/php/classes/ArticlesController.php';
require_once 'includes/php/classes/CategoriesController.php';

$db = new DB();
$userController = new UsersController();
$articleController = new ArticlesController();
$categoriesController = new CategoriesController();

$db->connect();

if (isset($_GET['edit_id'])) {
    $edit_id = $_GET['edit_id'];
    $article = $articleController->searchByArticleId($edit_id);
    if (sizeof($article) == 0) {
        header('Location: index.php');
    }
    $cat_id = $article['cat_id'];
} else if(!isset($_POST['submit'])) {
    header('Location: index.php');
}

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
    $a_id = $_POST['a_id'];

    $file = $_FILES['file'];

    if ($file['error'] === 0) {
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
                    $article->setArticleId($a_id);
                    $article->setCategoryId($category_id);
                    $article->setArticleTitle($title);
                    $article->setArticleDescription($description);
                    $article->setArticleTimestamp($timestamp);
                    $article->setArticleImgAddress($img_address);

                    if ($articleController->updateArticle($article, true)) {
                        move_uploaded_file($file_tmp_name, 'images/' . $img_address);
                        echo "<script> window.location.assign('articles.php?edit_res=success') </script>";
                    } else {
                        header('Location: edit_article.php?edit_res=failure&edit_id='.$a_id);
                    }
                } else {
                    header('Location: edit_article.php?edit_res=large_size&edit_id='.$a_id);
                }
            } else {
                header('Location: edit_article.php?edit_res=undefined&edit_id='.$a_id);
            }
        } else {
            header('Location: edit_article.php?edit_res=wrong_format&edit_id='.$a_id);
        }
    } else {
        $timestamp = date('Y-m-d H:i:s');
        $article = new Article();
        $article->setArticleId($a_id);
        $article->setCategoryId($category_id);
        $article->setArticleTitle($title);
        $article->setArticleDescription($description);
        $article->setArticleTimestamp($timestamp);

        if ($articleController->updateArticle($article, false)) {
            echo "<script> window.location.assign('articles.php?edit_res=success') </script>";
        } else {
            header('Location: new_article.php?edit_res=failure');
        }
    }
}

if (isset($_GET['edit_res'])) {
    $edit_res = $_GET['edit_res'];
} else {
    $edit_res = '';
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

    <script src="includes/js/edit-article-script.js" defer></script>
</head>

<body>

    <input type="hidden" id="edit-res" value="<?php echo $edit_res ?>">
    <!-- CONTENT -->
    <div class="main-container">

        <!-- NAVBAR -->
        <header class="header">
            <?php include 'includes/php/header.php'; ?>
        </header>

        <!-- SECTIONS -->
        <div class="main-section">
            <h1 class="form-heading">Edit Article</h1>
            <form action="edit-article.php" method="POST" class="new-article-form" enctype="multipart/form-data">
                <div class="form-group">
                    <input type="hidden" id="category-id" value="<?php echo $cat_id; ?>">
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
                <input type="hidden" value="<?php echo $article['a_id'] ?>" name="a_id" id="article-id">
                <div class="form-group">
                    <label id="form-label" for="title">Article Title: </label>
                    <input type="text" class="form-input article-title" id="title" name="title" value="<?php echo $article['a_title']; ?>" requried>
                </div>
                <div class="form-group">
                    <label id="form-label" for="image">Updated Image: </label>
                    <input type="file" class="form-input article-image" id="file" name="file">
                </div>
                <p style="text-align: right;">
                    <span style="font-weight:lighter;">Note:</span>
                    If you leave the `Updated Image` field as empty, the already attached image will be used.
                </p>
                <div class="form-group">
                    <label id="form-label" for="description">Article Description: </label>
                    <textarea type="text" class="form-input article-description" rows="20" id="description" name="description" required><?php echo $article['a_description']; ?></textarea>
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