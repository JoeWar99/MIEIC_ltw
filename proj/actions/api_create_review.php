<?php

include_once('../includes/session.php');
include_once('../database/db_functions.php');

$rent_id = trim(strip_tags($_POST['rent_id']));
$date = trim(strip_tags($_POST['date']));
$comment = trim(strip_tags($_POST['comment']));
$rating = trim(strip_tags($_POST['rating']));

echo json_encode(create_review($rent_id, $rating, $comment, $date));

?>