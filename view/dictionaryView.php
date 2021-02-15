<div class="container">
    <div id='initial-message'>Welcome, <?php echo $_SESSION['username'] ?> <a href='/logout'>Logout</a></div>
    <nav aria-label="breadcrumb">
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="/profile">Profile</a></li>
            <li class="breadcrumb-item active" aria-current="page"><?php echo $title ?> </li>
        </ol>
    </nav>
    <?php echo $data;?>

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
                <div id="response" style="display: none"></div>
            </div>
        </div>
    </div>
    <a href="#" role="button" class="btn btn-primary" data-hystmodal="#myModal">ADD WORD</a>
</div>


<script src="/library/hystModal-master/dist/hystmodal.min.js"></script>
<script>
    const myModal = new HystModal({
        linkAttributeName: "data-hystmodal",
    });
</script>