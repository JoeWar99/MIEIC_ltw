<?php

include_once('../includes/session.php');
include_once('../database/db_functions.php');

$username = $_SESSION['username'];
$houseId = $_POST['houseId'];


 if(!delete_house($houseId))
    echo json_encode(-1);
 else
   echo json_encode(0);
?>