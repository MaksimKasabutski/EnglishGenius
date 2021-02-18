<br>
<nav style="--bs-breadcrumb-divider: url(&#34;data:image/svg+xml,%3Csvg xmlns='http://www.w3.org/2000/svg' width='8' height='8'%3E%3Cpath d='M2.5 0L1 1.5 3.5 4 1 6.5 2.5 8l4-4-4-4z' fill='currentColor'/%3E%3C/svg%3E&#34;);"
     aria-label="breadcrumb">
    <ol class="breadcrumb">
        <li class="breadcrumb-item"><a href="/profile">Profile</a></li>
        <li class="breadcrumb-item active" aria-current="page"><?php echo $title ?></li>
    </ol>
</nav>

<?php if (isset($wordpare['wordid'])) { ?>
    <div class='col-sm-4'>
        <table class='table table-inverse'>
            <tr>
                <th>English word</th>
                <th>Translation</th>
            </tr>
            <?php
            $dictionaryId = $data['dictionaryid'];
            foreach ($data as $wordpare) {
                $result = "<tr><td>" . $wordpare['word'] . "</td><td>" . $wordpare['translation'] . "</td>";
                if (Dictionary::isDictionaryOwner($dictionaryId)) {
                    $result .= "<td><a href='" . $dictionaryId . "/" . $wordpare['wordid'] . "' >DEL</a></td>";
                }
                $result .= "</tr>";
                echo $result;
            }
            ?>
        </table>
    </div>
<?php } else echo "There is nothing here yet."; ?>

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


<script src="/library/hystModal-master/dist/hystmodal.min.js"></script>
<script>
    const myModal = new HystModal({
        linkAttributeName: "data-hystmodal",
    });
</script>