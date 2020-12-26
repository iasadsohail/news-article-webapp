<?php


require_once 'User.php';
require_once 'UsersController.php';
session_start();

if (isset($_POST['loginFlag'])) {
    if ($_POST['loginFlag'] == 1) {
        $user = new User();
        $userController = new UsersController();

        $user_email = $_POST['email'];
        $user_password = md5($_POST['password']);

        $user->setUseremail($user_email);
        $user->setUserPassword($user_password);

        if ($dbuser = $userController->searchByEmail($user_email)) {
            if($dbuser->getUserpassword() === $user_password) {
                $_SESSION['user_email'] = $dbuser->getUseremail();
                echo 'success';
            } else {
                echo 'wrong_password';
            }
        } else {
            echo 'no_user';
        }
    }
} else {
    echo 'nothing_received';
}
