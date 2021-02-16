<div id="response" style="display: none;"></div>

<form id="createWordlist" method="post" class="col-4">
    <br>
    <div class="mb-3">
        <label for="wordlistName" class="form-label">Wordlist name</label>
        <input type="text" class="form-control" id="wordlistName" placeholder="Wordlist Name"
               aria-describedby="passwordHelpBlock">
        <div id="passwordHelpBlock" class="form-text">
            Must be 8-20 characters long.
        </div>
    </div>
    <div class="mb-3">
        <label for="wordlistDiscription" class="form-label">Wordlist discription</label>
        <textarea class="form-control" id="wordlistDiscription" rows="3" required></textarea>
    </div>
    <div class="mb-3 form-check">
        <label class="form-check-label" for="isPublic">Make public</label>
        <input type="checkbox" class="form-check-input" name="isPublic" id="isPublic">
    </div>
    <input type="submit" class="btn btn-primary" value="Create">
</form>
<script src='/js/createWordlist.js'></script>