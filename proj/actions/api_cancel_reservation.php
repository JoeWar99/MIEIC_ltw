<?php

include_once('../includes/session.php');
include_once('../database/db_functions.php');

$username = $_SESSION['username'];
$rent_id = trim(strip_tags($_POST['rent_id']));


echo json_encode(cancel_reservation($rent_id));
?>