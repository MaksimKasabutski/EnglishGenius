<?php
namespace Models;
use Components\{Service, Security};
use PHPMailer\{PHPMailer, SMTP};

class Users
{

    public static function isAlreadyLogin(): bool
    {
        if (isset($_SESSION['username'])) {
            return true;
        }
        return false;
    }

    public static function getUserId($username)
    {
        $mysqli = Service::connectToDB();
        $query = "SELECT userid FROM users WHERE username = '$username'";
        $result = $mysqli->query($query)->fetch_all(MYSQLI_ASSOC);
        $mysqli->close();
        return $result[0]['userid'];
    }

    public static function isUsernameUsed($username): bool
    {
        $mysqli = Service::connectToDB();
        $query = "SELECT username FROM users WHERE username = '$username'";
        $result = $mysqli->query($query)->fetch_all(MYSQLI_ASSOC);
        $mysqli->close();
        if (empty($result)) {
            return false;
        } else return true;
    }

    public static function isEmailUsed($email): bool
    {
        $mysqli = Service::connectToDB();
        $query = "SELECT email FROM users WHERE email = '$email'";
        $result = $mysqli->query($query)->fetch_all(MYSQLI_ASSOC);
        $mysqli->close();
        if (empty($result)) {
            return false;
        } else return true;
    }

    public static function checkUserName($username): bool
    {
        $username = htmlspecialchars(trim($username, " \n\r\t\v\0"));
        if (!Service::checkLength(4, 16, $username)) {
            return false;
        }
        if (preg_match("/[^(\w\-)]/u", $username) == 1) {
            return false;
        }
        return true;
    }

    public static function addUser($username, $email, $password): bool
    {
        $mysqli = Service::connectToDB();
        $result = mysqli_query($mysqli, "INSERT INTO users VALUES(NULL, '$username', '$email', '$password', NULL)");
        $mysqli->close();
        return $result;
    }

    public static function generateResetLink($email)
    {
        $resetlink = hash("md2", str_replace('.', '', $_SERVER['REMOTE_ADDR']));
        $mysqli = Service::connectToDB();
        $query = "UPDATE users SET resetlink = '$resetlink' WHERE email = '$email'";
        $mysqli->query($query);
        return $resetlink;
    }

    public static function sendEmail($email)
    {
        $mail = new PHPMailer(true);
        $mail->CharSet = 'UTF-8';
        $mail->SMTPDebug = SMTP::DEBUG_SERVER;
        $mail->isSMTP();
        $mail->SMTPAuth = true;
        $mail->SMTPDebug = 0;
        $mail->SMTPSecure = 'tls';
        $mail->Host = 'smtp.gmail.com';
        $mail->Port = 587;
        $mail->Username = 'maksim.kasabutski@gmail.com';
        $mail->Password = 'maksim9890292';
        $mail->setFrom('admin@englishgenius.com', 'EnglishGenius');
        $mail->addAddress($email);
        $mail->isHTML(true);
        $mail->Subject = 'Password recovery';
        $link = 'http://englishgenius.loc/reset/' . self::generateResetLink($email);
        $mail->Body = "To recover your password follow the link below: <br><br> $link";
        $mail->send();
        if ($mail) return true;
        else return false;
    }

    public static function compareLinks($email, $resetLink): bool
    {
        $usersResetLink = Service::connectToDB()->query("SELECT resetlink FROM users WHERE email = '$email'")->fetch_all(MYSQLI_ASSOC)[0]['resetlink'];
        if ($resetLink != $usersResetLink) return false;
        else return true;
    }

    public static function setNewPassword($email, $password): bool
    {
        $password = Security::encodePassword($password);
        return mysqli_query(Service::connectToDB(),"UPDATE users SET password = '$password' WHERE email = '$email'");
    }
}