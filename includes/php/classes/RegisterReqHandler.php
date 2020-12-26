<?php

require_once 'User.php';
require_once 'UsersController.php';
session_start();

if (isset($_POST['registerFlag'])) {
    if ($_POST['registerFlag'] == 1) {

        $user = new User();
        $userController = new UsersController();

        $user_name = $_POST['name'];
        $user_email = $_POST['email'];
        $user_password = md5($_POST['password']);

        $user->setUsername($user_name);
        $user->setUseremail($user_email);
        $user->setUserPassword($user_password);

        if (!$userController->searchByEmail($user_email)) {
            if ($userController->insertUser($user)) {
                $_SESSION['user_email'] = $user->getUseremail();
                echo 'success';
            } else {
                echo 'failure';
            }
        } else {
            echo 'already_exists';
        }
    }
}
