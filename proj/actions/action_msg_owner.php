<?php

include_once('../includes/session.php');
include_once('../database/db_functions.php');

if (!isset($_GET['mid']) || !isset($_GET['tid'])) die(header("Location: ../pages/404.php"));
$mid = intval($_GET['mid']);
$tid = intval($_GET['tid']);

try {
    create_msg($mid, $tid, "", date("Y-m-d H:i:s")); 
    header("Location: ../pages/myMessages.php");
} catch (PDOException $e) {
    echo "NAY";
    die(header("Location: ../pages/403.php"));
}

?>