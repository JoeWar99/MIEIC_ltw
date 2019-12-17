<?php
include_once('../includes/session.php');
include_once('../database/db_functions.php');



$country  = trim(strip_tags($_POST['country']));
$city  = trim(strip_tags($_POST['city']));


$ret = check_city_for_a_country($city, $country);

echo json_encode($ret);
?>