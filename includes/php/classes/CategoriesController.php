<?php

require_once 'DB.php';
require_once 'Category.php';

class CategoriesController
{
    private $conn;

    public function __construct()
    {
        $this->conn = DB::connect();
    }

    public function insertCategory($category)
    {
        $cat_id = $category->getCategoryId();
        $cat_name = $category->getCategoryName();

        $ins_category = "INSERT INTO categories 
            ( cat_id, cat_name ) VALUES
            ( '$cat_id', '$cat_name' );
        ";
        if (mysqli_query($this->conn, $ins_category)) {
            $category->setCategoryId(mysqli_insert_id($this->conn));
            return true;
        } else {
            return false;
        }
    }

    public function updateCategory($category) {
        $cat_name = $category->getCategoryName();
        $cat_id = $category->getCategoryId();
        $upd_category = "UPDATE categories SET cat_name = '$cat_name' WHERE cat_id = '$cat_id'";
        if(mysqli_query($this->conn, $upd_category)) {
            return true;
        } else {
            return false;
        }
    }

    public function isValidCategoryId($cat_id) {
        $sel_categories = "SELECT COUNT(*) FROM categories WHERE cat_id = '$cat_id'";
        $run_sel_categories = mysqli_query($this->conn, $sel_categories);
        $category_count = mysqli_fetch_array($run_sel_categories)[0];
        if($category_count == 0) return false;
        else return true;
    }

    public function getNumberOfCategories()
    {
        $sel_categories = "SELECT COUNT(*) FROM categories";
        $run_sel_categories = mysqli_query($this->conn, $sel_categories);
        return mysqli_fetch_array($run_sel_categories)[0];
    }

    public function getCategories() {
        $categories = array();
        $sel_categories = "SELECT * FROM categories";
        $run_sel_categories = mysqli_query($this->conn, $sel_categories);
        while( $category = mysqli_fetch_assoc($run_sel_categories)) {
            array_push($categories, $category);
        }
        return $categories;
    }

    public function searchById($cat_id)
    {
        $sel_category = "SELECT * FROM categories WHERE cat_id = '$cat_id'";
        if ($run_sel_category = mysqli_query($this->conn, $sel_category)) {
            if (mysqli_num_rows($run_sel_category) == 0) {
                return null;
            } else {
                while ($category = mysqli_fetch_assoc($run_sel_category)) {
                    return $category;
                }
            }
        } else {
            return null;
        }
    }

    public function deleteCategory($cat_id)
    {
        $del_category = "DELETE FROM categories WHERE cat_id = '$cat_id'";
        if (mysqli_query($this->conn, $del_category)) {
            return true;
        } else {
            return false;
        }
    }
}
