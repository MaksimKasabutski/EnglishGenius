<?php require_once ROOT . '/core/Controller.php' ?>
<br>
<nav style="--bs-breadcrumb-divider: url(&#34;data:image/svg+xml,%3Csvg xmlns='http://www.w3.org/2000/svg' width='8' height='8'%3E%3Cpath d='M2.5 0L1 1.5 3.5 4 1 6.5 2.5 8l4-4-4-4z' fill='currentColor'/%3E%3C/svg%3E&#34;);"
     aria-label="breadcrumb">
    <ol class="breadcrumb">
        <li class="breadcrumb-item"><a href="/profile">Profile</a></li>
        <li class="breadcrumb-item active" aria-current="page"><?php echo $title ?></li>
    </ol>
</nav>
<button type="button" class="btn btn-primary" data-bs-toggle="modal"
        data-bs-toggle="tooltip" data-bs-target="#addword"
        data-bs-placement="bottom" title="Remove wordlist">ADD WORD
</button>
<div class='col-6'>
    <table class='table table-inverse'>
        <tr>
            <th class="col-5">English word</th>
            <th class="col-5">Translation</th>
            <th class="col-2">Actions</th>
        </tr>

        <?php
        //date from Dictionary->getWords => DictionaryController->actionData
        $dictionaryId = array_pop($data);
        if (!empty($data)) {
            foreach ($data as $wordpare) {
                $result = "<tr id='" . $wordpare['wordid'] . "'><td>" . $wordpare['word'] . " <div class='pos'>" . $wordpare['pos'] . "</div></td><td>" . $wordpare['translation'] . "</td>";
                if (Dictionary::isDictionaryOwner($dictionaryId)) {
                    $wordpareData = $wordpare['wordid'] . ", '" . $wordpare['word'] . "', '" . $wordpare['pos'] . "', '" . $wordpare['translation'] . "'";
                    $result .= "<td><button class='btn btn-primary btn-sm' onclick='deleteWord(" . $dictionaryId . ", " . $wordpare['wordid'] . ")'>Del</button>";
                    $result .= "<button class='btn btn-primary btn-sm' onclick=\"editWord(" . $wordpareData . ")\">Edit</button></td>";
                }
                $result .= "</tr>";
                echo $result;
            }
        } else echo "<tr id='warning'><td> There is nothing here yet.</td></tr>";
        ?>

    </table>
</div>

<div class="modal fade" id="addword" tabindex="-1" aria-labelledby="exampleModalLabel"
     aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Add word</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <form id="addWordIntoDictionary" method="POST">
                <div class="modal-body">
                    <label for="englishWord" class="form-label">English</label>
                    <input type="text" class="form-control" id="englishWord" autocomplete="off">
                    <div class="form-text">Must be 1-25 english letters long.</div>
                    <br>
                    <label for="translation" class="form-label">Translate</label>
                    <input type="text" class="form-control" id="translation" autocomplete="off">
                    <div class="form-text">Must be 1-25 russian letters long.</div>
                    <br>
                    <label for="pos">Part of speech</label>
                    <select id="pos" class="form-select">
                        <option selected>-</option>
                        <option value="noun">noun</option>
                        <option value="verb">verb</option>
                        <option value="adverb">adverb</option>
                        <option value="adjective">adjective</option>
                    </select>
                    <input type="hidden" id="dictionaryid" value="<?php echo $dictionaryId ?>">
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                    <input type="submit" class="btn btn-primary" value="Add">
                </div>
            </form>
            <div id="response" class="alert" style="display: none; width: 90%; margin: 0 auto 15px auto;"></div>
        </div>
    </div>
</div>

<script src="/js/word.js"></script>
<script src="/js/addWordIntoDictionary.js"></script>
