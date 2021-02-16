<br>
<div>
    <a href='/dictionary/create' class='btn btn-outline-primary'>Create dictionary</a>
    <a style="margin-left: 10px;" href='#' class='btn btn-outline-primary'>Add dictionary</a>
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
                        <a class="btn btn-primary" href='<?php echo $link ?> '>Go</a>
                        <button type="button" class="btn btn-danger" data-bs-toggle="modal" data-bs-target="#modal<?php echo $id ?>" data-bs-toggle="tooltip" data-bs-placement="bottom" title="Delete wordlist"><i class="fa fa-trash-o fa-lg" aria-hidden="true"></i></button>
                    </p>
                </div>
            </div>
        </div>
<!--        Modal windows generation       -->
        <div class="modal fade" id="modal<?php echo $id ?>" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        Are you shure you want to remove <?php echo $name ?> from your list?
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                        <a type="button" class="btn btn-danger" href="<?php echo URL . 'dictionary/remove/' . $id ?>">Remove</a>
                    </div>
                </div>
            </div>
        </div>
    <?php } ?>
</div>
