<?php

require_once 'DB.php';

class Article
{
    private $a_id;
    private $user_id;
    private $cat_id;
    private $a_title;
    private $a_description;
    private $a_timestamp;
    private $a_img_address;

    public function __construct()
    {
        $this->user_id = 0;
        $this->a_id = 0;
        $this->cat_id = 0;
        $this->a_title = '';
        $this->a_description = '';
        $this->a_img_address = '';
    }

    //getters
    public function getUserId()
    {
        return $this->user_id;
    }
    public function getArticleId()
    {
        return $this->a_id;
    }
    public function getCategoryId()
    {
        return $this->cat_id;
    }
    public function getArticleTitle()
    {
        return $this->a_title;
    }
    public function getArticleDescription()
    {
        return $this->a_description;
    }
    public function getArticleTimestamp()
    {
        return $this->a_timestamp;
    }
    public function getArticleImgAddress()
    {
        return $this->a_img_address;
    }

    //setters
    public function setUserId($id)
    {
        $this->user_id = $id;
    }
    public function setArticleId($id)
    {
        $this->a_id = $id;
    }
    public function setCategoryId($id)
    {
        $this->cat_id = $id;
    }
    public function setArticleTitle($title)
    {
        $this->a_title = $title;
    }
    public function setArticleDescription($description)
    {
        $this->a_description = $description;
    }
    public function setArticleTimestamp($timestamp)
    {
        $this->a_timestamp = $timestamp;
    }
    public function setArticleImgAddress($img_address)
    {
        $this->a_img_address = $img_address;
    }
}
