<?php
include_once('../includes/session.php');
include_once('../database/db_functions.php');
include_once('..templates/tpl_common.php');

$location  = $_POST['location'];
$start_date = $_POST['start'];
$end_date = $_POST['end'];
$guest_no = $_POST['people'];

$loc_info = explode(',', $location);




$city_name = trim(strip_tags(ltrim($loc_info[0])));

$country_name = trim(strip_tags(ltrim($loc_info[1])));

$result = get_location_from_names($city_name, $country_name);

$id = intval(trim(strip_tags($result['Id'])));
$cid = intval(trim(strip_tags($result['CountryId'])));

if ($start_date == "" && $end_date == "") {
    header("Location: ../pages/search.php?city_id=$id&country_id=$cid&gn=$guest_no");
} else if ($end_date != "" && $start_date != "") {

    $start_time = strtotime($start_date);
    $end_time = strtotime($end_date);
    //DATE QUANDO VEM DO FORM VEM EM "YYYY-MM-DD"
    header("Location: ../pages/search.php?city_id=$id&country_id=$cid&sd=$start_date&ed=$end_date&gn=$guest_no");
} else {
    header("Location: ../pages/homepage.php#");
}
