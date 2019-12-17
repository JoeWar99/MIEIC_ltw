<?php
include_once('../includes/session.php');
include_once('../database/db_functions.php');

$locations = get_locations();


if($locations == -1){
    echo json_encode(-1);
}
else{
 
    echo json_encode($locations);
}
