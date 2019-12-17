<?php

include_once('../includes/session.php');
include_once('../database/db_functions.php');

$rent_id = $_POST['rent_id'];
$date = $_POST['date'];
$comment = $_POST['comment'];
$rating = $_POST['rating'];

echo json_encode(create_review($rent_id, $rating, $comment, $date));

?>