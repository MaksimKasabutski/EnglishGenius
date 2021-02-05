<?php
?>
<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Create wordlist</title>
</head>
<body>
<div id="response" style="display: none;"></div>
<fieldset>
    <form id="createWordlist" method="post">
        <label for="wordlistName">Wordlist Name</label>
        <input type="text" name="wordlistName" id="wordlistName" required>

        <label for="wordlistDiscription">Wordlist Discription</label>
        <input type="text" name="wordlistDiscription" id="wordlistDiscription" required>

        <label for="isPublic">Make public</label>
        <input type="checkbox" name="isPublic" id="isPublic">

        <button type="submit">NEXT</button>
    </form>
</fieldset>
<script src='/js/createWordlist.js'></script>
</body>
</html>
