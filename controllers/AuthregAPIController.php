<?php
namespace Controllers;
use Core\APIController;
use Components\{DB, Response, Security, Validation};
use Models\Users;
class AuthregAPIController extends APIController
{
    private $username;
    private $password;
    private $passwordConf;
    private $email;
    private $resetLink;

    public function __construct()
    {
        parent::__construct();
        $this->username = Validation::strCleaner(isset($this->request['username']) ? $this->request['username'] : NULL);
        $this->password = Validation::strCleaner(isset($this->request['password']) ? $this->request['password'] : NULL);
        $this->passwordConf = Validation::strCleaner(isset($this->request['passwordConf']) ? $this->request['passwordConf'] : NULL);
        $this->email = Validation::strCleaner(isset($this->request['email']) ? $this->request['email'] : NULL);
        $this->resetLink = isset($this->request['resetLink']) ? $this->request['resetLink'] : NULL;
    }

    public function actionLogin()
    {
        if (!Users::isUsernameUsed($this->username)) {
            $response = new Response('error', 'Такой пользователь не найден.');
        } else {
            if (Security::checkPassword($this->username, $this->password)) {
                setcookie("hash", '', strtotime('+30 days'));
                $_SESSION['userid'] = Users::getUserId($this->username);
                $_SESSION['username'] = $this->username;
                $response = new Response('success', 'Hello, ' . $this->username);
            } else {
                $response = new Response('error', 'Неверный пароль');
            }
        }
        echo json_encode($response);
    }

    public function actionRegistration()
    {
        if (Users::isUsernameUsed($this->username)) {
            $response = new Response('error', 'User with the same name already exists');
        } elseif (!Users::checkUserName($this->username)) {
            $response = new Response('error', 'Wrong username format');
        } elseif (!Validation::checkLength(8, 60, $this->password)) {
            $response = new Response('error', 'Password length must be from 8 to 60');
        } elseif (Users::isEmailUsed($this->email)) {
            $response = new Response('error', 'User with this email address already exists');
        } elseif ($this->password != $this->passwordConf) {
            $response = new Response('error', 'Password mismatch');
        } elseif (!Validation::emailValidation($this->email)) {
            $response = new Response('error', 'Wrong email address format');
        } else {
            $hash = Security::encodePassword($this->password);
            if (Users::addUser($this->username, $this->email, $hash)) {
                setcookie("hash", '', strtotime('+30 days')); //1 month
                $_SESSION['userid'] = Users::getUserId($this->username);
                $_SESSION['username'] = $this->username;
                $response = new Response('success', 'Регистрация прошла успешно');
            } else $response = new Response('error', 'Something went wrong');
        }

        echo json_encode($response);
    }

    public function actionReset()
    {
        if (!Validation::emailValidation($this->email)) {
            $response = new Response('error', 'Wrong email address format');
            echo json_encode($response);
        } elseif (!Users::isEmailUsed($this->email)) {
            $response = new Response('error', 'User with this email address doesn\'t exist');
            echo json_encode($response);
        } else {
            if (Users::sendEmail($this->email)) {
                $response = new Response('success', 'Instructions for password recovery have been sent to your mail');
                echo json_encode($response);
            } else {
                $response = new Response('error', 'Dont sent');
                echo json_encode($response);
            }
        }
    }

    public function actionNewpass()
    {
        if (!Validation::emailValidation($this->email)) {
            $response = new Response('error', 'Wrong email address format');
            echo json_encode($response);
        } elseif (!Users::isEmailUsed($this->email)) {
            $response = new Response('error', 'User with this email address doesn\'t exist');
            echo json_encode($response);
        } elseif ($this->password != $this->passwordConf) {
            $response = new Response('error', 'Password mismatch');
            echo json_encode($response);
        } elseif (!Validation::checkLength(8, 60, $this->password)) {
            $response = new Response('error', 'Wrong password length');
            echo json_encode($response);
        } elseif (Users::compareLinks($this->email, $this->resetLink)) {
            if(Users::setNewPassword($this->email, $this->password)) {
                $response = new Response('success', 'All is fine');
                echo json_encode($response);
            } else {
                $response = new Response('error', 'Something went wrong');
                echo json_encode($response);
            }
        } else {
            $response = new Response('error', "Something went wrong");
            echo json_encode($response);
        }
    }
}