<?php
include_once('../includes/session.php');
include_once('../database/db_functions.php');


$house_id = trim(strip_tags($_POST['houseId']));

$house_commodities = get_commodities_by_house_id($house_id);

if($house_commodities == -1){
    echo json_encode(-1);
}
else{
    echo json_encode($house_commodities);
}
?>