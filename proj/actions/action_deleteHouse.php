<?php

include_once('../includes/session.php');
include_once('../database/db_functions.php');

$username = $_SESSION['username'];
$houseId = $_POST['houseId'];


 $e = delete_house($houseId);
    $_SESSION['message'] = $e->getMessage();

header('Location: ../pages/myProperties.php');
?>