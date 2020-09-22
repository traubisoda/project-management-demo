<?php
require_once 'db.php';
include "head.php";

$db = new DB();
$project = [];
$contacts = [];

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if ($_POST['ID']) {
        $db->updateProject($_POST);
        $db->updateContacts($_POST['ID'], $_POST['contacts']);
    }
    else {
        $db->createProject($_POST);
    }
}

if (isset($_GET['id'])) {
    $project = $db->getProjectById($_GET['id']);
    $contacts = $db->getContactsForProject($_GET['id']);
}
?>

    <form action="" class="p-4" method="POST">
        <h2>Project létrehozása</h2>
        <input type="hidden" name="ID" value="<?= $project['ID'] ?? '' ?>">
        
        <div class="form-group">
            <label for="name">Név</label>
            <input type="text" class="form-control" name="name" id="name" value="<?= $project['name'] ?? '' ?>">
        </div>
        <div class="form-group">
            <label for="description">Leírás</label>
            <textarea class="form-control" name="description" id="description"><?= $project['description'] ?? '' ?></textarea>
        </div>
        <div class="form-group">
            <label for="status">Státusz</label>
            <select name="status" id="status" class="form-control">
                <option value="pending" <?= isset($project['status']) && $project['status'] == 'pending' ? 'selected' : '' ?>>
                    Fejlesztésre vár
                </option>
                <option value="inprogress" <?= isset($project['status']) && $project['status'] == 'inprogress' ? 'selected' : '' ?>>
                    Folyamatban
                </option>
                <option value="done" <?= isset($project['status']) && $project['status'] == 'done' ? 'selected' : '' ?>>
                    Kész
                </option>
            </select>
        </div>
        <h3>Kapcsolattartók</h3>
        <div id="contacts">
            <?php foreach($contacts as $i => $contact): ?>
                <div data-contact>
                    <div class="form-group">
                        <label for="name">Név:</label>
                        <input type="text" name="contacts[<?= $i ?>][name]" value="<?= $contact['name'] ?>">
                    </div>
                    <div class="form-group">
                        <label for="email">Email:</label>
                        <input type="email" name="contacts[<?= $i ?>][email]" value="<?= $contact['email'] ?>">
                    </div>
                </div>
            <?php endforeach; ?>
        </div>
        <div>
            <div class="form-group">
                <label for="name">Név:</label>
                <input type="text" name="name" id="newName">
            </div>
            <div class="form-group">
                <label for="email">Email:</label>
                <input type="email" name="email" id="newEmail">
            </div>
            <button class="btn btn-info" id="addContact">Hozzáadás</button>
        </div>

        <div class="form-group">
            <button class="btn btn-success">Mentés</button>
        </div>
    </form>

<?php
include "foot.php";
