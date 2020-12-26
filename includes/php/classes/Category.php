<?php

require_once 'DB.php';

class Category
{
    private $cat_id;
    private $cat_name;

    public function __construct()
    {
        $this->cat_id = 0;
        $this->cat_name = '';
    }

    //getters
    public function getCategoryId() {
        return $this->cat_id;
    }
    public function getCategoryName() {
        return $this->cat_name;
    }

    //setters
    public function setCategoryId($id) {
        $this->cat_id = $id;
    }
    public function setCategoryName($name) {
        $this->cat_name = $name;
    }
}

