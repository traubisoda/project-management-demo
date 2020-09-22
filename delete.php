<?php

require_once 'db.php';
$db = new DB();
$projectId = $_POST['ID'];
$db->deleteProjectById($projectId);
