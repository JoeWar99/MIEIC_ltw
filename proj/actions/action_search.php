<?php
include_once('../includes/session.php');
include_once('../database/db_functions.php');
include_once('..templates/tpl_common.php');

$location  = $_POST['location'];
$start_date = $_POST['start'];
$end_date = $_POST['end'];
$guest_no = $_POST['people'];

$loc_info = explode(',', $location);

$city_name = ltrim($loc_info[0]);

$country_name = ltrim($loc_info[1]);

$result = get_location_from_names($city_name, $country_name);

$id = intval($result['id']);

//DATE QUANDO VEM DO FORM VEM EM "YYYY-MM-DD"


if($id)  header("Location: ../pages/search.php?lid=$id&sd=$start_date&ed=$end_date&gn=$guest_no");
else header("Location: ../pages/homepage.php#");
?>
