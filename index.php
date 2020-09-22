<?php

require_once 'db.php';
include 'head.php';

$db = new DB();
?>
<table class="table">
    <thead>
        <tr>
            <td>Név</td>
            <td>Leírás</td>
            <td>Státusz</td>
            <td>Műveletek</td>
        </tr>
    </thead>
    <?php foreach($db->getProjects() as $project) : ?>
    <tr>
        <td>
            <?= $project['name'] ?>
        </td>
        <td>
            <?= $project['description'] ?>
        </td>
        <td>
            <?= $project['status'] ?>
        </td>
        <td>
            <a href="#" class="btn btn-danger">&times;</a>
        </td>
    </tr>
    <?php endforeach; ?>
</table>

<?php

include 'foot.php';
