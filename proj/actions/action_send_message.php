<?php
include_once('../includes/session.php');
include_once('../database/db_functions.php');

if (!isset($_GET['mid']) || !isset($_GET['tid']) || !isset($_GET['content'])) die(header("Location: ../pages/404.php"));

$mid = intval($_GET['mid']);
$tid = intval($_GET['tid']);
$content = htmlentities($_GET['content']);


try {
    create_msg($mid, $tid, $content, date("Y-m-d H:i:s")); //está aqui o erro

    echo "YAY";
} catch (PDOException $e) {
    echo "NAY";
}

?>