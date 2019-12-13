<?php
include_once('../includes/session.php');
include_once('../database/db_functions.php');

if(isset($_GET['start_date']) && isset($_GET['end_date']) && isset($_GET['hid'])){
    $sd = $_GET['start_date'];
    $ed = $_GET['end_date'];
    $hid = intval($_GET['hid']);
}
?>