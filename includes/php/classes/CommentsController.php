<?php

require_once 'DB.php';
require_once 'Comment.php';

class CommentsController
{
    private $conn;

    public function __construct()
    {
        $this->conn = DB::connect();
    }

    public function insertComment($comment)
    {
        $user_id = $comment->getUserId();
        $a_id = $comment->getArticleId();
        $c_text = $comment->getCommentText();
        $c_timestamp = $comment->getCommentTimestamp();
        $ins_comment = "INSERT INTO comments 
            ( user_id, a_id, c_text, c_timestamp ) VALUES
            ( '$user_id', '$a_id', '$c_text', '$c_timestamp' );
        ";
        if (mysqli_query($this->conn, $ins_comment)) {
            $comment->setCommentId(mysqli_insert_id($this->conn));
            return true;
        } else {
            return false;
        }
    }

    public function getNumberOfComments()
    {
        $sel_comments = "SELECT COUNT(*) FROM comments";
        $run_sel_comments = mysqli_query($this->conn, $sel_comments);
        return mysqli_fetch_array($run_sel_comments)[0];
    }

    public function searchByCommentId($c_id)
    {
        $sel_comment = "SELECT * FROM comments WHERE c_id = '$c_id'";
        if ($run_sel_comment = mysqli_query($this->conn, $sel_comment)) {
            if (mysqli_num_rows($run_sel_comment) == 0) {
                return null;
            } else {
                while ($comment = mysqli_fetch_assoc($run_sel_comment)) {
                    return $comment;
                }
            }
        } else {
            return null;
        }
    }

    public function searchByArticleId($a_id)
    {
        $comments = array();
        $sel_comment = "SELECT * FROM comments WHERE a_id = '$a_id'";
        if ($run_sel_comment = mysqli_query($this->conn, $sel_comment)) {
            while ($comment = mysqli_fetch_assoc($run_sel_comment)) {
                array_push($comments, $comment);
            }
        } else {
            return null;
        }
        return $comments;
    }

    public function deleteComment($c_id)
    {
        $del_comment = "DELETE FROM comments WHERE c_id = '$c_id'";
        if (mysqli_query($this->conn, $del_comment)) {
            return true;
        } else {
            return false;
        }
    }

    public function deleteCommentsByArticleId($a_id)
    {
        $del_comment = "DELETE FROM comments WHERE a_id = '$a_id'";
        if(mysqli_query($this->conn, $del_comment)) {
            return true;
        } else {
            return false;
        }
    }
}
