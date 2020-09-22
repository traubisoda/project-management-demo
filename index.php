<?php

require_once 'db.php';
include 'head.php';

parse_str($_SERVER['QUERY_STRING'] ?? '', $urlParams);

$db = new DB();

$status = isset($_GET['status']) ? $_GET['status'] : null;
$projectCount = $db->countProjects($status);

$currentPage = isset($_GET['page']) ? $_GET['page'] : 0;
$projectsPerPage = 5;

$projects = $db->getProjects($projectsPerPage, $currentPage * $projectsPerPage, $status);

?>
<div class="p-4">
    <form method="GET">
        <label for="label">Státusz:</label>
        <select name="status" id="status">
            <option value="">
                Minden
            </option>
            <option value="pending" <?= $status ==='pending' ? 'selected' : null ?>>
                Fejlesztésre vár
            </option>
            <option value="inprogress" <?= $status ==='inprogress' ? 'selected' : null ?>>
                Folyamatban
            </option>
            <option value="done" <?= $status ==='done' ? 'selected' : null ?>>
                Kész
            </option>
        </select>
        <button class="btn btn-info">Szűrés</button>
    </form>
</div>
<table class="table">
    <thead>
        <tr>
            <td>Név</td>
            <td>Leírás</td>
            <td>Státusz</td>
            <td>Kapcsolattartók</td>
            <td>Műveletek</td>
        </tr>
    </thead>
    <?php foreach($projects as $project) : ?>
    <tr data-id="<?= $project['ID'] ?>">
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
            <a href="#"
               class="btn btn-danger"
               data-role="delete"
               data-id="<?= $project['ID'] ?>">
                &times;
            </a>
            <a href="create.php?id=<?= $project['ID'] ?>">Szerkeszetés</a>
        </td>
        <td>
            <?= $db->countContactsByProjectId($project['ID']) ?>
        </td>
    </tr>
    <?php endforeach; ?>
</table>

<div class="container">
    <nav aria-label="Page navigation example">
        <ul class="pagination">
            <li class="page-item"><a class="page-link" href="#">Previous</a></li>
            <?php for ($i = 0; $i < $projectCount / $projectsPerPage; $i++): ?>
            <li class="page-item">
                <a class="page-link" href="?<?= http_build_query(array_merge($urlParams, ['page' => $i] )) ?>">
                    <?= $i + 1 ?>
                </a>
            </li>
            <?php endfor; ?>
            <li class="page-item"><a class="page-link" href="#">Next</a></li>
        </ul>
    </nav>
</div>

<?php

include 'foot.php';
