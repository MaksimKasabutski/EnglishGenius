<?php
session_start();
require_once ('UserProvider.php');
require_once('DictionaryProvider.php');
echo "<div id='initial-message'>Добро пожаловать, " . $_SESSION['username'] . " <a href='../logout.php'>Выйти</a></div>";
?>
<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title><?php echo $_SESSION['username']?></title>
</head>
<body>
<a href="/createwordlist.php">Создать словарь</a>
<br>
<br>
<p>Ваши словари</p>
<?php
echo DictionaryProvider::getUsersLists($_SESSION['userid']);
?>
</body>
</html>
