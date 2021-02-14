<?php


class AuthregView
{
    public function loginView()
    {
        $page = include 'header.php';
        $page .=  "
        <div id='response' style='display: none;'></div>
        <div class='login-window' id='loginWindow'>
            <div class='head'>
                <p>ВХОД</p>
                <a href='registration'>Registration</a>
            </div>
            <fieldset>
                <form id='loginForm' method='POST'>
                    <label for='text'>Логин:</label><br>
                    <input name='login' class='login' type='text' placeholder='Login' value='' required><br>

                    <label for='password'>Пароль:</label><br>
                    <input name='password' class='password' type='password' placeholder='Password' value='' required><br>

                    <input type='submit' value='ВХОД'>
                </form>
            </fieldset>
        </div>
        <script src='js/login.js'></script>";
        $page .= include 'footer.php';
        echo $page;
    }

    public function registrationView()
    {
        include 'header.php';
        $page =  '
        <div id="response" style="display: none;"></div>
        <div class="login-window" id="registrationWindow">
            <div class="head">
                <p>РЕГИСТРАЦИЯ</p>
                <a href="login">Login</a>
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
        <script src="js/registration.js"></script>
        ';

        echo $page;
        include 'footer.php';
    }
}