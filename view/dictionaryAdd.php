<br>
<nav style="--bs-breadcrumb-divider: url(&#34;data:image/svg+xml,%3Csvg xmlns='http://www.w3.org/2000/svg' width='8' height='8'%3E%3Cpath d='M2.5 0L1 1.5 3.5 4 1 6.5 2.5 8l4-4-4-4z' fill='currentColor'/%3E%3C/svg%3E&#34;);"
     aria-label="breadcrumb">
    <ol class="breadcrumb">
        <li class="breadcrumb-item"><a href="/profile">Profile</a></li>
        <li class="breadcrumb-item active" aria-current="page">Add dictionary</li>
    </ol>
</nav>
<br>
<?php
if(!$data) {
    echo 'You already have all of dictionaries.';
} else {?>
<table class="table">
    <thead>
    <tr class="d-flex">
        <th scope="col" class="col-1">#</th>
        <th scope="col" class="col-2">Name</th>
        <th scope="col" class="col-7">Discription</th>
        <th scope="col" class="col-2">Action</th>
    </tr>
    </thead>
    <tbody>
    <?php
    $i = 1;
    //$data from DictionaryController->actionAdd->getAllDictionaries(array)
    foreach ($data as $dictionary) {
        $dictionaryId = $dictionary['dictionaryid'];
        $name = $dictionary['name'];
        $discription = $dictionary['discription'];
        ?>
        <tr class="d-flex">
            <th scope="row" class="col-1"><?php echo $i ?></th>
            <td class="col-2"><?php echo $name ?></td>
            <td class="col-7"><?php echo $discription ?></дщкуь></td>
            <td class="col-2">
                <button class="btn btn-primary" id="addButton<?php echo $dictionaryId ?>" onclick="addDictionaryToUser(<?php echo $dictionaryId . ', \'' . $_SESSION['username'].'\''?>)">Add</button>
            </td>
        </tr>
        <?php
        $i++;
    }
    ?>
    </tbody>
</table>
<?php } ?>
<script src='/js/script.js'></script>