<?php

require_once 'includes/php/classes/DB.php';
require_once 'includes/php/classes/Comment.php';
require_once 'includes/php/classes/CommentsController.php';
require_once 'includes/php/classes/UsersController.php';
require_once 'includes/php/classes/ArticlesController.php';
require_once 'includes/php/classes/CategoriesController.php';

$db = new DB();
$userController = new UsersController();
$articlesController = new ArticlesController();
$commentsController = new CommentsController();
$categoriesController = new CategoriesController();

$db->connect();

session_start();
if (isset($_SESSION['user_email'])) {
    $user = $userController->searchByEmail($_SESSION['user_email']);
    $user_name = $user->getUsername();
    $user_type = $user->getUsertype();
    $user_id = $user->getUserId();
} else {
    $user_id = -1;
    $user_name = '';
    $user_type = 'user';
}

if (isset($_GET['add_c_res'])) {
    $a_id = $_GET['a_id'];
    $add_c_res = $_GET['add_c_res'];
} else {
    $add_c_res = '';
}

if (isset($_GET['a_id'])) {
    $a_id = $_GET['a_id'];
    $article = $articlesController->searchByArticleId($a_id);
    $author = $userController->searchById($article['user_id']);
    $comments = $commentsController->searchByArticleId($a_id);
    $category = $categoriesController->searchById($article['cat_id']);
} else {
    if (isset($_GET['del_id'])) {
        $del_id = $_GET['del_id'];
        if ($articlesController->deleteArticleById($del_id)) {
            header('Location: articles.php?del_res=success');
        } else {
            header('Location: articles.php?del_res=failure');
        }
    } else {
        if (isset($_POST['submit-comment'])) {
            $comment_input = $_POST['comment-input'];
            echo $article_id = $_POST['article-id'];
            $timestamp = date('Y-m-d H:i:s');

            $comment = new Comment();
            $comment->setUserId($user_id);
            $comment->setArticleId($article_id);
            $comment->setCommentText($comment_input);
            $comment->setCommentTimestamp($timestamp);

            if ($commentsController->insertComment($comment)) {
                header('Location: article.php?add_c_res=success&a_id=' . $article_id);
            } else {
                header('Location: article.php?add_c_res=failure&a_id=' . $article_id);
            }
        } else {
            header('Location: articles.php');
        }
    }
}

?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Article</title>

    <link rel="stylesheet" href="includes/css/font-nunito-styles.css">
    <link rel="stylesheet" href="includes/css/header-styles.css">
    <link rel="stylesheet" href="includes/css/article-styles.css">
    <link rel="stylesheet" href="includes/css/scrollbar-styles.css">
    <link rel="stylesheet" href="includes/css/comments-styles.css">
    <link rel="stylesheet" href="includes/css/footer-styles.css">

    <script src="includes/js/article-script.js" defer></script>
    <script src="includes/js/comment-script.js" defer></script>
</head>

<body>

    <input type="hidden" id="add-c-res" value="<?php echo $add_c_res; ?>">

    <!-- ADD COMMENT MODAL -->
    <div id="add-comment-modal" class="modal">
        <div class="modal-content">
            <div class="modal-header">
                <span class="close">&times;</span>
                <h2>Add Comment</h2>
            </div>
            <div class="modal-body">
                <form action="article.php" method="POST">
                    <input type="hidden" name="article-id" id="article-id" value="<?php echo $a_id; ?>">
                    <div class="form-group">
                        <textarea class="comment-input" name="comment-input" rows="10" placeholder="Comment your ideas..." required></textarea>
                    </div>
                    <div class="form-group">
                        <button class="add-comment-btn" name="submit-comment" type="submit">Post Comment</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <!-- CONTENT -->
    <div class="main-container">

        <!-- NAVBAR -->
        <header class="header">
            <?php include 'includes/php/header.php'; ?>
        </header>

        <!-- SECTIONS -->
        <div class="main-section">
            <!-- ARTICLE DETAILS -->
            <div class="article-title">
                <h1><?php echo $article['a_title'] ?></h1>
                <?php
                if (strtoupper($user_type) == 'ADMIN') {
                    echo '<a class="article-action-btn edit-article-btn" href="edit-article.php?edit_id=' . $article['a_id'] . '">Edit Article</a>';
                    echo '<a class="article-action-btn delete-article-btn" href="?del_id=' . $article['a_id'] . '">Delete Article</a>';
                }
                ?>
            </div>
            <hr>
            <br><br>
            <div class="article-container">
                <div class="article-image-container">
                    <img class="article-image" src="images/<?php echo $article['a_img_address'] ?>" alt="Article Image">
                </div>
                <p class="article-description">
                    <?php echo $article['a_description']; ?>
                </p>
                <hr><br>
                <div class="article-info">
                    Article Category: <?php echo $category['cat_name'] ?>
                </div>
                <div class="article-info">
                    Posted on: <?php echo $article['a_timestamp'] ?>
                </div>
                <div class="article-info">
                    Posted by: <?php echo $author['user_name'] ?>
                </div>
                <br>
                <hr>
            </div>
            <div class="comments-section">
                <div class="comments-section-heading">
                    Comments By Users
                </div>
                <div class="add-comment-section">
                    <button class="add-comment-btn" id="add-comment-btn">Add Comment</button>
                </div>
                <div class="comments">
                    <?php
                    foreach ($comments as $comment) {
                    ?>
                        <div class="comment-container">
                            <div class="comment">
                                <h3 class="comment-user">
                                    <?php echo $userController->searchById($comment['user_id'])['user_name']; ?>
                                </h3>
                                <label class="comment-description">
                                    <?php echo $comment['c_text'] ?>
                                </label>
                            </div>
                        </div>
                    <?php
                    }
                    ?>
                    <!-- <div class="comment-container">
                        <div class="comment">
                            <h3 class="comment-user">Comment User</h3>
                            <label class="comment-description">
                                Some comment here
                            </label>
                        </div>
                    </div> -->
                </div>
            </div>

            <br>
            <hr><br>
        </div>

        <!-- FOOTER -->
        <?php include 'includes/php/footer.php'; ?>
    </div>
</body>

</html>