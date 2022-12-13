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

        if (empty($_POST['username'])) {
            showTemplate('user/login.twig', [
            'error' => 'Please fill in your username',
            ]);
        } elseif (empty($_POST['password'])) {
            showTemplate('user/login.twig', [
            'error' => 'Please fill in your password',
            ]);
        } else if (!$user) {
            showTemplate('user/login.twig', [
            'error' => 'Wrong login',
            ]);
        } elseif (!password_verify($_POST['password'], $user->password)) {
            showTemplate('user/login.twig', [
            'error' => 'Wrong login',
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

    public function register()
    {
        showTemplate('user/register.twig');
    }

    public function registerPost()
    {
        $dbUsername = R::findOne('users', 'username = ?', [$_POST['username']]);

        if ($dbUsername) {
            showTemplate('user/register.twig', [
            'error' => 'Username already exists',
            ]);
        } else if (empty($_POST['username'])) {
            showTemplate('user/register.twig', [
            'error' => 'Please fill in your username',
            ]);
        } else if (empty($_POST['password'])) {
            showTemplate('user/register.twig', [
            'error' => 'Please fill in your password',
            ]);
        } else if (empty($_POST['confirmPassword'])) {
            showTemplate('user/register.twig', [
            'error' => 'Please fill in your password again',
            ]);
        } else if ($_POST['password'] !== $_POST['confirmPassword']) {
            showTemplate('user/register.twig', [
            'error' => 'Passwords do not match',
            ]);
        } else {
            $user = R::dispense('users');
            $user->username = $_POST['username'];
            $user->password = password_hash($_POST['password'], PASSWORD_DEFAULT);
            R::store($user);
            header('Location: /user/login');
        }
    }
}
