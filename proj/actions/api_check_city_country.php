<?php
include_once('../includes/session.php');
include_once('../database/db_functions.php');

file_put_contents('somefilename.txt', print_r($_POST, true), FILE_APPEND);


$country  = $_POST['country'];
$city  = $_POST['city'];


$ret = check_city_for_a_country($city, $country);

echo json_encode($ret);
?>