<?php

require_once 'DB.php';
require_once 'Article.php';
require_once 'CommentsController.php';

class ArticlesController
{
    private $conn;

    public function __construct()
    {
        $this->conn = DB::connect();
    }

    public function insertArticle($article)
    {
        $user_id = $article->getUserId();
        $cat_id = $article->getCategoryId();
        $a_title = $article->getArticleTitle();
        $a_description = $article->getArticleDescription();
        $a_timestamp = $article->getArticleTimestamp();
        $a_img_address = $article->getArticleImgAddress();
        $ins_article = "INSERT INTO articles 
            ( user_id, cat_id, a_title, a_description, a_timestamp, a_img_address ) VALUES
            ( '$user_id', '$cat_id', '$a_title', '$a_description', '$a_timestamp', '$a_img_address' );
        ";
        if (mysqli_query($this->conn, $ins_article)) {
            $article->setArticleId(mysqli_insert_id($this->conn));
            return true;
        } else {
            return false;
        }
    }

    public function getNumberOfArticles()
    {
        $sel_articles = "SELECT COUNT(*) FROM articles";
        $run_sel_articles = mysqli_query($this->conn, $sel_articles);
        return mysqli_fetch_array($run_sel_articles)[0];
    }

    public function getArticles($offset, $limit)
    {
        $articles = array();
        $sel_articles = "SELECT * FROM articles ORDER BY a_id DESC LIMIT $offset, $limit";
        $run_sel_articles = mysqli_query($this->conn, $sel_articles);
        while ($article = mysqli_fetch_assoc($run_sel_articles)) {
            array_push($articles, $article);
        }
        return $articles;
    }

    public function getArticlesByCategory($cat_id)
    {
        $articles = array();
        $sel_articles = "SELECT * FROM articles WHERE cat_id = '$cat_id' ORDER BY a_id DESC";
        $run_sel_articles = mysqli_query($this->conn, $sel_articles);
        while ($article = mysqli_fetch_assoc($run_sel_articles)) {
            array_push($articles, $article);
        }
        return $articles;
    }

    public function searchByArticleId($a_id)
    {
        $sel_article = "SELECT * FROM articles WHERE a_id = '$a_id'";
        if ($run_sel_article = mysqli_query($this->conn, $sel_article)) {
            if (mysqli_num_rows($run_sel_article) == 0) {
                return null;
            } else {
                while ($article = mysqli_fetch_assoc($run_sel_article)) {
                    return $article;
                }
            }
        } else {
            return null;
        }
    }

    public function searchByUserId($user_id)
    {
        $articles = array();
        $sel_articles = "SELECT * FROM articles WHERE user_id = '$user_id'";
        if ($run_sel_articles = mysqli_query($this->conn, $sel_articles)) {
            while ($article = mysqli_fetch_assoc($run_sel_articles)) {
                array_push($articles, $article);
            }
        } else {
            return null;
        }
        return $articles;
    }

    public function updateArticle($article, $updateImage)
    {

        $a_id = $article->getArticleId();
        $cat_id = $article->getCategoryId();
        $a_title = $article->getArticleTitle();
        $a_description = $article->getArticleDescription();
        $a_timestamp = $article->getArticleTimestamp();
        $old_img_address = $this->searchByArticleId($a_id)['a_img_address'];

        if ($updateImage == true) {
            $a_img_address = $article->getArticleImgAddress();
        } else {
            $a_img_address = $old_img_address;
        }

        $upd_article = "
            UPDATE articles SET 
                cat_id = '$cat_id',
                a_title = '$a_title',
                a_description = '$a_description',
                a_timestamp = '$a_timestamp',
                a_img_address = '$a_img_address'
            WHERE a_id = '$a_id'
        ";

        if (mysqli_query($this->conn, $upd_article)) {
            if ($old_img_address != '' && $updateImage) {
                $temp = 'images/' . $old_img_address;
                if (unlink($temp)) {
                    return true;
                } else {
                    return false;
                }
            } else {
                return true;
            }
        } else {
            return false;
        }
    }

    public function deleteArticleById($a_id)
    {
        $article = $this->searchByArticleId($a_id);
        $a_img_address = 'images/' . $article['a_img_address'];

        $del_article = "DELETE FROM articles WHERE a_id = '$a_id'";
        if (mysqli_query($this->conn, $del_article)) {
            if (!unlink($a_img_address)) {
                return false;
            } else {
                $commentsController = new CommentsController();
                if ($commentsController->deleteCommentsByArticleId($a_id)) {
                    return true;
                }
            }
        } else {
            return false;
        }
    }
}
