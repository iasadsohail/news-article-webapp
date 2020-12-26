<?php

require_once '../includes/php/classes/DB.php';
require_once '../includes/php/classes/Category.php';
require_once '../includes/php/classes/UsersController.php';
require_once '../includes/php/classes/CategoriesController.php';

$db = new DB();
$userController = new UsersController();
$categoriesController = new CategoriesController();



$db->connect();

session_start();
if (isset($_SESSION['user_email'])) {
    $user = $userController->searchByEmail($_SESSION['user_email']);
    $user_name = $user->getUsername();
    $user_type = $user->getUsertype();
    if ($user_type != 'admin') {
        header('Location: ../');
    } else {
        $categories = $categoriesController->getCategories();
    }
} else {
    header('Location: ../');
}

if (isset($_GET['del_id'])) {
    $delete_id = $_GET['del_id'];
    if ($categoriesController->deleteCategory($delete_id)) {
        echo "<script>window.location.assign('categories.php?del_res=success')</script>";
    } else {
        echo "<script>window.location.assign('categories.php?del_res=failure')</script>";
    }
}

if (isset($_GET['del_res'])) {
    $del_res = $_GET['del_res'];
} else {
    $del_res = '';
}

if (isset($_POST['submit-add-category'])) {
    $category_input = $_POST['add-category-input'];
    $category = new Category();

    $category->setCategoryName($category_input);
    if ($categoriesController->insertCategory($category)) {
        echo "<script>window.location.assign('categories.php?add_cat_res=success')</script>";
    } else {
        echo "<script>window.location.assign('categories.php?add_cat_res=failure')</script>";
    }
}

if(isset($_GET['add_cat_res'])) {
    $add_cat_res = $_GET['add_cat_res'];
} else {
    $add_cat_res = '';
}

if(isset($_GET['edit_id'])) {
    $edit_id = $_GET['edit_id'];
    $category = $categoriesController->searchById($edit_id);
} else {
    $edit_id = '-1';
}

if(isset($_POST['submit-edit-category'])) {
    $category_input = $_POST['edit-category-input'];
    $category_id = $_POST['edit-category-id'];
    $category = new Category();
    $category->setCategoryName($category_input);
    $category->setCategoryId($category_id);
    if($categoriesController->updateCategory($category)) {
        echo "<script>window.location.assign('categories.php?edit_cat_res=success')</script>";
    } else {
        echo "<script>window.location.assign('categories.php?edit_cat_res=failure')</script>";
    }
}


if(isset($_GET['edit_cat_res'])) {
    $edit_cat_res = $_GET['edit_cat_res'];
} else {
    $edit_cat_res = '';
}

?>


<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Panel</title>

    <!-- FONT AWESOME -->
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css" integrity="sha384-wvfXpqpZZVQGK6TAh5PVlGOfQNHSoD2xbE+QkPxCAFlNEevoEH3Sl0sibVcOQVnN" crossorigin="anonymous">

    <link rel="stylesheet" href="../includes/css/font-nunito-styles.css">
    <link rel="stylesheet" href="../includes/css/header-styles.css">
    <link rel="stylesheet" href="../includes/css/scrollbar-styles.css">
    <link rel="stylesheet" href="admin-styles.css">

    <script src="categories-script.js" defer></script>
</head>

<body>

    <input type="hidden" id="del-res" value="<?php echo $del_res; ?>">
    <input type="hidden" id="add-cat-res" value="<?php echo $add_cat_res; ?>">
    <input type="hidden" id="edit-id" value="<?php echo $edit_id; ?>">
    <input type="hidden" id="edit-cat-res" value="<?php echo $edit_cat_res; ?>">
    
    <!-- ADD CATEGORY MODAL -->
    <div id="add-category-modal" class="modal">
        <div class="modal-content">
            <div class="modal-header">
                <span class="close" id="close-add-modal">&times;</span>
                <h2>Add Category</h2>
            </div>
            <div class="modal-body">
                <form action="categories.php" method="POST">
                    <div class="form-group">
                        <input class="category-input" name="add-category-input" placeholder="Category Name" required>
                    </div>
                    <div class="form-group">
                        <button class="add-category-btn" name="submit-add-category" type="submit">Add Category</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <!-- ADD CATEGORY MODAL -->
    <div id="edit-category-modal" class="modal">
        <div class="modal-content">
            <div class="modal-header">
                <span class="close" id="close-edit-modal">&times;</span>
                <h2>Edit Category</h2>
            </div>
            <div class="modal-body">
                <form action="categories.php" method="POST">
                    <input type="hidden" name="edit-category-id" value="<?php echo $edit_id ?>">
                    <div class="form-group">
                        <input class="category-input" name="edit-category-input" placeholder="Category Name" value="<?php echo $category['cat_name'] ?>" required>
                    </div>
                    <div class="form-group">
                        <button class="add-category-btn" name="submit-edit-category" type="submit">Submit Category</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <!-- CONTENT -->
    <div class="main-container">

        <!-- NAVBAR -->
        <header class="header">
            <?php include 'header.php'; ?>
        </header>

        <!-- SECTIONS -->
        <div class="main-section">
            <h1>Categories</h1>
            <button class="add-category-btn" id="add-category-btn">Add Category</button>
            <table class="categories-table">
                <tr class="table-row table-header">
                    <th class="table-heading">#</th>
                    <th class="table-heading">Category Name</th>
                    <th class="table-heading">Actions</th>
                </tr>
                <?php
                $i = 1;
                foreach ($categories as $category) {
                ?>
                    <tr class="table-row">
                        <td class="table-data"><?php echo $i++; ?></td>
                        <td class="table-data"><?php echo $category['cat_name'] ?></td>
                        <td class="table-data">
                            <a class="category-action-btn" href="categories.php?edit_id=<?php echo $category['cat_id'] ?>">
                                <i class="fa fa-pencil" aria-hidden="true"></i>
                            </a>
                            <a class="category-action-btn" href="categories.php?del_id=<?php echo $category['cat_id'] ?>">
                                <i class="fa fa-trash" aria-hidden="true"></i>
                            </a>
                        </td>
                    </tr>
                <?php
                }
                ?>
                <!--
                    <tr class="table-row">
                        <td class="table-data">1</td>
                        <td class="table-data">Business</td>
                        <td class="table-data">
                            <a class="category-action-btn"> <i class="fa fa-pencil" aria-hidden="true"></i> </a>
                            <a class="category-action-btn"> <i class="fa fa-trash" aria-hidden="true"></i> </a>
                        </td>
                    </tr>
                -->
            </table>
        </div>
    </div>
</body>

</html>