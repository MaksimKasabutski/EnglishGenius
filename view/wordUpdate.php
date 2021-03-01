<br>
<?php
if ($data != NULL) {
    $dictionaryname = $data['dictionaryname'];
    $dictionaryid = $data['dictionaryid'];
    $wordid = $data[0]['wordid'];
    $engWord = $data[0]['word'];
    $rusWord = $data[0]['translation'];
    $pos = $data[0]['pos'];
}
?>
<nav style="--bs-breadcrumb-divider: url(&#34;data:image/svg+xml,%3Csvg xmlns='http://www.w3.org/2000/svg' width='8' height='8'%3E%3Cpath d='M2.5 0L1 1.5 3.5 4 1 6.5 2.5 8l4-4-4-4z' fill='currentColor'/%3E%3C/svg%3E&#34;);"
     aria-label="breadcrumb">
    <ol class="breadcrumb">
        <li class="breadcrumb-item"><a href="/profile">Profile</a></li>
        <li class="breadcrumb-item"><a href="<?php echo $_SERVER['HTTP_REFERER'] ?>"><?php echo $dictionaryname ?></a>
        </li>
        <li class="breadcrumb-item active" aria-current="page">Update word</li>
    </ol>
</nav>
<div id="response" class="alert" style="display: none"></div>

<form id="updateWord" method="POST">
    <label for="englishWord" class="form-label">English</label>
    <input type="text" class="form-control" id="englishWord" value="<?php echo $engWord?>">
    <div class="form-text">Must be 1-25 english letters long.</div>
    <br>
    <label for="translation" class="form-label">Translate</label>
    <input type="text" class="form-control" id="translation" value="<?php echo $rusWord?>">
    <div class="form-text">Must be 1-25 russian letters long.</div>
    <br>
    <label for="pos">Part of speech</label>
    <select id="pos" class="form-select">
        <option selected><?php echo $pos ?></option>
        <option >-</option>
        <option value="noun">noun</option>
        <option value="verb">verb</option>
        <option value="adverb">adverb</option>
        <option value="adjective">adjective</option>
        <option value="preposition">preposition</option>
    </select>
    <input type="hidden" id="wordid" value="<?php echo $wordid ?>">
    <input type="hidden" id="dictionaryid" value="<?php echo $dictionaryid ?>">
    <br><br>
    <input type="submit" class="btn btn-primary" value="Save">
    <a class="btn btn-secondary" href="<?php echo $_SERVER['HTTP_REFERER'] ?>">Cancel</a>


</form>
<div id="response" class="alert" style="display: none; width: 90%; margin: 0 auto 15px auto;"></div>

<script src='/js/word.js'></script>