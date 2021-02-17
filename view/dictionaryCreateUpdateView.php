<?php
$nameField = '';
$discriptionField = '';
$isPublic = 0;
$value = 'Create';
$dictionaryId = '';
if($data != NULL) {
    $dictionaryId = $data[0]['dictionaryid'];
    $nameField = $data[0]['name'];
    $discriptionField = $data[0]['discription'];
    $isPublic = $data[0]['ispublic'];
    $value = 'Update';
}
?>
<div id="response" style="display: none;"></div>

<form id="CUDictionary" method="post" class="col-4">
    <br>
    <div class="mb-3">
        <label for="wordlistName" class="form-label">Wordlist name</label>
        <input type="text" class="form-control" id="wordlistName" placeholder="Wordlist Name"
               aria-describedby="passwordHelpBlock" value="<?php echo $nameField ?>" required>
        <div id="passwordHelpBlock" class="form-text">
            Must be 8-20 characters long.
        </div>
    </div>
    <div class="mb-3">
        <label for="wordlistDiscription" class="form-label">Wordlist discription</label>
        <textarea class="form-control" id="wordlistDiscription" rows="3" required><?php echo $discriptionField ?></textarea>
    </div>
    <div class="mb-3 form-check">
        <label class="form-check-label" for="isPublic">Make public</label>
        <input type="checkbox" class="form-check-input" name="isPublic" id="isPublic" <?php if($isPublic == 1){echo 'checked';}?> >
    </div>
    <input type="hidden" id='dictionaryid' value="<?php echo $dictionaryId ?>">
    <input type="submit" id="status" class="btn btn-primary" value="<?php echo $value ?>">
</form>
<script src='/js/CUDictionary.js'></script>