<?php

require_once 'DB.php';
require_once 'User.php';

class UsersController
{
    private $conn;

    public function __construct()
    {
        $this->conn = DB::connect();
    }

    public function insertUser($user) {
        $user_name = $user->getUsername();
        $user_email = $user->getUseremail();
        $user_password = $user->getUserpassword();
        $user_type = $user->getUsertype();
        $ins_user = "INSERT INTO users 
            ( user_name, user_email, user_password, user_type ) VALUES
            ( '$user_name', '$user_email', '$user_password', '$user_type' );
        ";
        if(mysqli_query($this->conn, $ins_user)) {
            $user->setUserId( mysqli_insert_id($this->conn) );
            return true;
        } else {
            return false;
        }
    }

    public function getNumberOfUsers()
    {
        $sel_users = "SELECT COUNT(*) FROM users";
        $run_sel_users = mysqli_query($this->conn, $sel_users);
        return mysqli_fetch_array($run_sel_users)[0];
    }

    public function searchById($user_id)
    {
        $sel_user = "SELECT * FROM users WHERE user_id = '$user_id'";
        if ($run_sel_user = mysqli_query($this->conn, $sel_user)) {
            if (mysqli_num_rows($run_sel_user) == 0) {
                return null;
            } else {
                while ($user = mysqli_fetch_assoc($run_sel_user)) {
                    return $user;
                }
            }
        } else {
            return null;
        }
    }

    public function searchByEmail($user_email)
    {
        $sel_user = "SELECT * FROM users WHERE user_email = '$user_email'";
        if ($run_sel_user = mysqli_query($this->conn, $sel_user)) {
            if (mysqli_num_rows($run_sel_user) == 0) {
                return null;
            } else {
                while ($user = mysqli_fetch_assoc($run_sel_user)) {
                    $dbuser = new User();
                    $dbuser->setUserId($user['user_id']);
                    $dbuser->setUsername($user['user_name']);
                    $dbuser->setUseremail($user['user_email']);
                    $dbuser->setUserpassword($user['user_password']);
                    $dbuser->setUsertype($user['user_type']);
                    return $dbuser;
                }
            }
        } else {
            return null;
        }
    }

    private function deleteUser($user_id)
    {
        $del_user = "DELETE FROM users WHERE user_id = '$user_id'";
        if ($run_del_user = mysqli_query($this->conn, $del_user)) {
            return true;
        } else {
            return false;
        }
    }
}
