<?php
include_once('../includes/session.php');
include_once('../database/db_functions.php');

if(!isset($_POST['start_date']) || !isset($_POST['end_date'])
|| !isset($_POST['tid']) || !isset($_POST['hid']) || !isset($_POST['ppd'])) var_dump($_POST);//die(header("Location: ../pages/404.php"));

else{

$start_date = trim(strip_tags($_POST['start_date']));
$end_date = trim(strip_tags($_POST['end_date']));
$tid = intval(trim(strip_tags($_POST['tid'])));
$hid = intval(trim(strip_tags($_POST['hid'])));
$ppd = intval(trim(strip_tags($_POST['ppd'])));

$st = strtotime($start_date);
$et = strtotime($end_date);
$datediff = $et - $st;
$price = round($datediff/(60*60*24));

try {
    create_rent($start_date, $end_date, $price, $hid, $tid);
    header('Location: ../pages/myReservations.php');
} catch (PDOException $e) {
    $_SESSION['messages'][] = array('type' => 'error', 'content' => 'Failed to rent!');
    header('Location: ../pages/housepage.php?id=' . $hid . "&msg=" . $_SESSION['messages']);
}
}

?>