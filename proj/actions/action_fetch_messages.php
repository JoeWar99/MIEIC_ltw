<?php
include_once('../includes/session.php');
include_once('../database/db_functions.php');

if (!isset($_GET['mid']) || !isset($_GET['tid'])) die(header("Location: ../pages/404.php"));

$mid = intval($_GET['mid']);
$tid = intval($_GET['tid']);

$msgs = get_msgs_bw_2_usrs($mid, $tid);

if (!$msgs) echo "<p>Nothing to see here...</p>";
else var_dump($msgs);

?>