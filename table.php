<?php
session_start();
?>
<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <link rel="stylesheet" href="css/table.css">
    <link rel="stylesheet" href="css/fonts.css">
    <link href="/css/font-awesome.css" rel="stylesheet">
    <title>Document</title>
</head>
<body>
<?php
include_once('DictionaryProvider.php');

DictionaryProvider::isUserHasADictionary($_SESSION['userid'], $_GET['id']);

?>

<div id="modal_addWord">

    <div id="modal_addWord_window">
        <form id="addWordIntoDictionary" method="POST">
            <div class="modal_addWord_window_left">
                <label for="englishWord">English</label>
                <input type="text" id="englishWord" autocomplete="off">
            </div>
            <div class="modal_addWord_window_right">
                <label for="translation">Translation</label>
                <input type="text" id="translation" autocomplete="off">
            </div>
            <input type="hidden" id="dictionaryid" value="<?php echo $_GET['id']?>">
            <input type="submit" class="button" value="Add">
        </form>
        <div id="response"></div>
        <a href="#" id="modal_closeButton"><i class="fa fa-times" aria-hidden="true"></i></a>
    </div>
    <script src='js/addWordIntoDictionary.js'></script>
</div>

<button class="button" id="addWordButton">ADD WORD</button>

</body>
</html>