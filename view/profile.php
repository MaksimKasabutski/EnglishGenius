<br>
<div>
    <a href='/dictionary/create' class='btn btn-outline-primary'>Create dictionary</a>
    <a style="margin-left: 10px;" href='/dictionary/add' class='btn btn-outline-primary'>Add dictionary</a>
</div>
<br>
<p>Your dictionaries</p>
<div class="accordion" id="accordionExample">
    <?php
    $page = '';
    for ($i = 0; $i < count($data); $i++) {
        $id = $data[$i]['dictionaryid'];
        $name = $data[$i]['name'];
        $discription = $data[$i]['discription'];
        $link = URL . "dictionary/" . $id;
        $removeLink = URL . 'dictionary/remove/' . $id;
        $updateLink = URL . 'dictionary/update/' . $id;
        $deleteLink = URL . 'dictionary/delete/' . $id;
        ?>
        <!--           Wordlist generation       -->
        <div class="accordion-item">
            <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse"
                    data-bs-target="#<?php echo 'collapse' . $id ?>"
                    aria-expanded="true" aria-controls="<?php echo 'collapse' . $id ?>">
                <?php echo $name ?>
            </button>
            <div id="<?php echo 'collapse' . $id ?>" class="accordion-collapse collapse" aria-labelledby="headingOne"
                 data-bs-parent="#accordionExample">
                <div class="accordion-body">
                    <p><?php echo $discription ?></p>
                    <p>
                        <a class="btn btn-primary" href="<?php echo $link ?> ">Go</a>
                        <?php if(Dictionary::isDictionaryOwner($id)) { ?>
                            <a class="btn btn-warning" href="<?php echo $updateLink ?>">
                                <i class="fa fa-pencil fa-lg" aria-hidden="true"></i>
                            </a>
                            <button onclick="generateModalForDelete(<?php echo $id . ', \'' . $name . '\', \'' . $deleteLink . '\'' ?>)"
                                    type="button" class="btn btn-danger" data-bs-toggle="modal"
                                    data-bs-toggle="tooltip"
                                    data-bs-placement="bottom" title="Delete wordlist">
                                <i class="fa fa-trash-o fa-lg" aria-hidden="true"></i>
                            </button>
                        <?php } else { ?>
                        <button onclick="generateModalForRemove(<?php echo $id . ', \'' . $name . '\', \'' . $removeLink . '\'' ?>)"
                                type="button" class="btn btn-info" data-bs-toggle="modal"
                                data-bs-toggle="tooltip"
                                data-bs-placement="bottom" title="Remove wordlist">
                            <i class="fa fa-trash-o fa-lg" aria-hidden="true"></i>
                        </button>
                        <?php } ?>
                    </p>
                </div>
            </div>
        </div>
    <?php } ?>
</div>
<script src="/js/script.js"></script>