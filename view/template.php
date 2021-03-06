<!DOCTYPE html>
<html lang='en'>
<head>
    <meta charset="utf-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <link rel="icon" href="/favicon.ico" type="image/x-icon">
    <link rel="stylesheet" href="/style.css">
    <link rel="stylesheet" href="/css/signin.css">
    <link rel="stylesheet" href="/css/pagination.css">
    <link rel="stylesheet" href="/css/font-awesome.css">
    <link rel="stylesheet" href="/css/fonts.css">
    <link rel="stylesheet" href="/css/bootstrap.min.css">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
    <title><?php echo $title ?></title>
</head>
<body>

<nav class="navbar navbar-dark bg-dark">
    <div class="container">
        <a class="navbar-brand" href="/profile" style="font-family: Ambassador; font-size: 26px">EnglishGenius</a>
        <div class="initial-message">Welcome, <?php echo $_SESSION['username'] ?> <a href='/logout'>Logout</a></div>
    </div>
</nav>
<div class="container">

    <?php require 'view/' . $contentView; ?>

</div>

<script src="/js/bootstrap.min.js"></script>
</body>
</html>
