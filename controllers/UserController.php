<?php

require_once '../vendor/autoload.php';

use RedBeanPHP\R as R;

class UserController extends BaseController
{
    public function login()
    {
        showTemplate('user/login.twig');
    }

    public function loginPost()
    {
        $user = R::findOne('users', 'username = ?', [$_POST['username']]);

        if (!$user) {
            showTemplate('user/login.twig', [
            'error' => 'User not found',
            ]);
        } elseif (!password_verify($_POST['password'], $user->password)) {
            showTemplate('user/login.twig', [
            'error' => 'Wrong password',
            ]);
        } else {
            $_SESSION['user'] = $user;
            header('Location: /');
        }
    }

    public function logout()
    {
        session_destroy();
        header('Location: /user/login');
    }
}
