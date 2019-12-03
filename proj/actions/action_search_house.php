<?php
include_once('../includes/session.php');
include_once('../database/db_functions.php');
include_once('..templates/tpl_common.php');

$location  = $_POST['Location'];
$start_date = $_POST['Start'];
$end_date = $_POST['End'];

$loc_info = explode(',', $location);

$city_name = ltrim($loc_info[0]);

$country_name = ltrim($loc_info[1]);

$ids = get_location_from_names($city_name, $country_name);

$city_id = intval($ids['CityId']);
$country_id =intval($ids['CountryId']);

if($ids)  header("Location: ../pages/search.php?city_id=$city_id&country_id=$country_id&sd=$start_date&ed=$end_date");
else header("Location: ../pages/homepage.php");
?>
