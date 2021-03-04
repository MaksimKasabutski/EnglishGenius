<?php

$dictionaryid = $_SESSION['dictionaryId'];
$dictionaryName = \Models\Dictionary::getDictionaryName($dictionaryid);
?>
<br>
<nav style="--bs-breadcrumb-divider: url(&#34;data:image/svg+xml,%3Csvg xmlns='http://www.w3.org/2000/svg' width='8' height='8'%3E%3Cpath d='M2.5 0L1 1.5 3.5 4 1 6.5 2.5 8l4-4-4-4z' fill='currentColor'/%3E%3C/svg%3E&#34;);"
     aria-label="breadcrumb">
    <ol class="breadcrumb">
        <li class="breadcrumb-item"><a href="/profile">Profile</a></li>
        <li class="breadcrumb-item"><a href="<?php echo $_SERVER['HTTP_REFERER'] ?>"><?php echo $dictionaryName ?></a>
        </li>
        <li class="breadcrumb-item active" aria-current="page">Learning</li>
    </ol>
</nav>
<div class="row">
    <div class="col-3 learning-form">
        <form id="learning-form">
            <div class="header">
                <div class="counter">
                    <div id="current">1</div>
                    <span>/</span>
                    <div id="total"><?php echo $data['count']?></div>
                </div>
                <div id="word">
                    <?php echo $data[0] ?>
                </div>
            </div>
            <div id="pos">
                <?php echo $data[2] ?>
            </div>
            <input class="form-control" type="text" id="translation" autocomplete="off" value="">
            <input type="hidden" id="counter" value="0">
            <br>
            <div class="learning-form-button">
                <button id="prev-button" class="btn btn-outline-primary" disabled="disabled"><i class="fa fa-arrow-left"
                                                                            aria-hidden="true"></i> Prev
                </button>
                <button id="check-button" class="btn btn-success">Check</button>
                <button id="next-button" class="btn btn-outline-primary">Next <i class="fa fa-arrow-right"
                                                                                 aria-hidden="true"></i>
                </button>
            </div>
        </form>
    </div>
</div>
<script src="/js/learning.js"></script>