<?php
include_once('../includes/session.php');
include_once('../database/db_functions.php');
include_once('..templates/tpl_common.php');

$location  = $_GET['Location'];
$start_date = $_GET['Start'];
$end_date = $_GET['End'];

header("Location: ../pages/search.php?location=$location&sd=$start_date&ed=$end_date");
?>
