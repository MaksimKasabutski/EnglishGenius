<br>
<table class="table">
    <thead>
    <tr>
        <th scope="col">#</th>
        <th scope="col">Name</th>
    </tr>
    </thead>
    <?php
    $i = 1;
    foreach ($data as $dictionary) {
        $name = $dictionary['name'];
        $discription = $dictionary['discription'];
        ?>

        <thead>
        <tr>
            <th scope="row"><?php echo $i ?></th>
            <th><?php echo $name ?></th>
        </tr>
        </thead>
        <?php
        $i++;
    }
    ?>
</table>
