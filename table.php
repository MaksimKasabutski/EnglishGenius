<?php
session_start();
include_once('Dictionary.php');
include_once('view/tableView.php');
include_once('Words.php');
error_reporting(E_ALL);
ini_set('display_errors', 'on');
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
    <link rel="stylesheet" href="library/hystModal-master/dist/hystmodal.min.css">
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0-alpha.4/css/bootstrap.min.css"
          integrity="2hfp1SzUoho7/TsGGGDaFdsuuDL0LX2hnUp6VkX3CUQ2K4K+xjboZdsXyp4oUHZj" crossorigin="anonymous">
    <title>Document</title>
</head>
<body style="margin-top: 40px">
<div class="container">
    <?php
    Dictionary::isUserHasADictionary($_SESSION['userid'], $_GET['id']);
    renderWords();
    ?>

    <div class="hystmodal" id="myModal" aria-hidden="true">
        <div class="hystmodal__wrap">
            <div id="modal_addWord_window" class="hystmodal__window" role="dialog" aria-modal="true">
                <button data-hystclose class="hystmodal__close">Закрыть</button>
                <form id="addWordIntoDictionary" method="POST">
                    <div class="modal_addWord_window_left">
                        <label for="englishWord">English</label>
                        <input type="text" id="englishWord" autocomplete="off">
                    </div>
                    <div class="modal_addWord_window_right">
                        <label for="translation">Translation</label>
                        <input type="text" id="translation" autocomplete="off">
                    </div>
                    <input type="hidden" id="dictionaryid" value="<?php echo $_GET['id'] ?>">
                    <input type="submit" class="btn btn-primary" value="Add">
                </form>
                <div id="response"></div>
            </div>
        </div>
    </div>
    <a href="#" role="button" class="btn btn-primary" data-hystmodal="#myModal">ADD WORD</a>
</div>

<script src="js/addWordIntoDictionary.js"></script>
<script src="library/hystModal-master/dist/hystmodal.min.js"></script>
<script>
    const myModal = new HystModal({
        linkAttributeName: "data-hystmodal",
    });
</script>

</body>
</html>