<?php
use Models\Dictionary;

$value = NULL;
if ($data == NULL) {
    $nameField = '';
    $discriptionField = '';
    $isPublic = 0;
    $value = 'Create';
    $dictionaryId = '';
}
if ($data != NULL) {
    if (Dictionary::isDictionaryOwner($data[0]['dictionaryid'])) {
        $dictionaryId = $data[0]['dictionaryid'];
        $nameField = $data[0]['name'];
        $discriptionField = $data[0]['discription'];
        $isPublic = $data[0]['ispublic'];
        $value = 'Update';
    }
}
if ($value) {
    ?>
    <br>
    <nav style="--bs-breadcrumb-divider: url(&#34;data:image/svg+xml,%3Csvg xmlns='http://www.w3.org/2000/svg' width='8' height='8'%3E%3Cpath d='M2.5 0L1 1.5 3.5 4 1 6.5 2.5 8l4-4-4-4z' fill='currentColor'/%3E%3C/svg%3E&#34;);"
         aria-label="breadcrumb">
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="/profile">Profile</a></li>
            <li class="breadcrumb-item active" aria-current="page">Create dictionary</li>
        </ol>
    </nav>
    <div id="response" class="alert" style="display: none"></div>

    <form id="dictionaryCreateUpdate" method="post" class="col-4">
        <br>
        <div class="mb-3">
            <label for="dictionaryName" class="form-label">Dictionary name</label>
            <input type="text" class="form-control" id="dictionaryName" placeholder="Dictionary Name"
                   aria-describedby="passwordHelpBlock" value="<?php echo $nameField ?>" required>
            <div id="passwordHelpBlock" class="form-text">
                Must be 8-20 characters long.
            </div>
        </div>
        <div class="mb-3">
            <label for="dictionaryDiscription" class="form-label">Dictionary discription</label>
            <textarea class="form-control" id="dictionaryDiscription" rows="3"
                      required><?php echo $discriptionField ?></textarea>
        </div>
        <div class="mb-3 form-check">
            <label class="form-check-label" for="isPublic">Make public</label>
            <input type="checkbox" class="form-check-input" name="isPublic" id="isPublic" <?php if ($isPublic == 1) {
                echo 'checked';
            } ?> >
        </div>
        <input type="hidden" id='dictionaryid' value="<?php echo $dictionaryId ?>">
        <input type="submit" id="status" class="btn btn-primary" value="<?php echo $value ?>">
    </form>
<?php } else { ?>
    <div class="alert alert-danger">
        Access denied
    </div>
<?php } ?>
<script src='/js/dictionaryCreateUpdate.js'></script>