<?php

require_once 'DB.php';

class Comment
{
    private $c_id;
    private $user_id;
    private $a_id;
    private $c_text;
    private $c_timestamp;

    public function __construct()
    {
        $this->user_id = 0;
        $this->c_id = 0;
        $this->a_id = 0;
        $this->c_text = '';
    }

    //getters
    public function getUserId()
    {
        return $this->user_id;
    }
    public function getCommentId()
    {
        return $this->c_id;
    }
    public function getArticleId()
    {
        return $this->a_id;
    }
    public function getCommentText()
    {
        return $this->c_text;
    }
    public function getCommentTimestamp()
    {
        return $this->c_timestamp;
    }

    //setters
    public function setUserId($id)
    {
        $this->user_id = $id;
    }
    public function setCommentId($id)
    {
        $this->c_id = $id;
    }
    public function setArticleId($id)
    {
        $this->a_id = $id;
    }
    public function setCommentText($text)
    {
        $this->c_text = $text;
    }
    public function setCommentTimestamp($timestamp)
    {
        $this->c_timestamp = $timestamp;
    }
}
