<?php
if (session_status() != PHP_SESSION_ACTIVE) session_start();
?>
<!DOCTYPE html>
<html lang='en'>
<head>
    <meta charset="utf-8">
    <title>EnglishGenius</title>
    <link rel="stylesheet" href="style.css">
    <link rel="stylesheet" href="library/hystModal-master/dist/hystmodal.min.css">
</head>
<body>
<div id="response" style="display: none;"></div>
<noscript>
    Внимание, включите JavaScript!
</noscript>
<?php
require_once('Security.php');
if (isset($_SESSION['username']) AND Security::checkCookie()) {
    header('Location: /mainpage.php');
} else {
    echo '
        <div class="login-window" id="loginWindow">
            <div class="head">
                <p>ВХОД</p>
            </div>
            <fieldset>
                <form id="loginForm" method="POST">
                    <label for="text">Логин:</label><br>
                    <input name="login" class="login" type="text" placeholder="Login" value="" required><br>

                    <label for="password">Пароль:</label><br>
                    <input name="password" class="password" type="password" placeholder="Password" value="" required><br>

                    <input type="submit" value="ВХОД">
                </form>
            </fieldset>
        </div>
        <div class="login-window" id="registrationWindow">
            <div class="head">
                <p>РЕГИСТРАЦИЯ</p>
            </div>
            <fieldset>
                <form id="registrationForm" method="POST">
                    <label for="text">Логин:</label><br>
                    <input name="username" class="login" type="text" placeholder="Username" value="" required><br>

                    <label for="password">Пароль:</label><br>
                    <input name="password" class="password" type="password" placeholder="Password" value="" required><br>

                    <label for="password">Повторите пароль:</label><br>
                    <input name="confirm_password" id="confirm_password" type="password" placeholder="Password" value="" required><br>

                    <label for="email">E-mail:</label><br>
                    <input name="email" id="email" type="email" placeholder="E-mail" value="" required><br>
                    
                    <input type="submit" value="РЕГИСТРАЦИЯ">
                </form>
            </fieldset>
        </div>
        ';
}
?>
<script src='script.js'></script>
<script src="library/hystModal-master/dist/hystmodal.min.js"></script>
</body>
</html>