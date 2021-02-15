<div class="container">
    <div id='initial-message'>Welcome, <?php echo $_SESSION['username'] ?> <a href='/logout'>Logout</a></div>
    <nav aria-label="breadcrumb">
        <ol class="breadcrumb">
            <li class="breadcrumb-item active" aria-current="page">Profile</li>
        </ol>
    </nav>
    <div><a href='/createwordlist.php' class='button'>Create dictionaries</a></div>
    <br>
    <br>
    <p>Your dictionaries</p>
    <ul class='list-group'>
        <?php
        $page = '';
        for ($i = 0;
             $i < count($data);
             $i++) {
            $link = "http://englishgenius.loc/dictionary/" . $data[$i]['dictionaryid'];
            ?>
            <li class='list-group-item'>
                <a class='stretched-link' href='<?php echo $link ?> '> <?php echo $data[$i]['name'] ?> </a>
                <div class='control-buttons'>
                    <button type='button' class='btn btn-danger'>
                        <i class='fa fa-trash-o fa-lg' aria-hidden='true'></i>
                    </button>
                </div>
            </li>
        <?php } ?>
    </ul>
</div>