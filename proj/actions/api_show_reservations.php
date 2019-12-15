<?php

include_once('../includes/session.php');
include_once('../database/db_functions.php');


$username = $_SESSION['username'];

$houses_reserved = get_all_reservations_for_a_user($username);

if($houses_reserved == -1){
    echo json_encode(-1);
}
else{
    for($i = 0; $i < count($houses_reserved); $i++){
        $pic = get_house_top_pic($houses_reserved[$i]["Id"]);
        $cnt = count_comments($houses_reserved[$i]["Id"]);
        $houses_reserved[$i]["pic"] = $pic;
        $houses_reserved[$i]["cnt"] = $cnt;
        $rentId = $houses_reserved[$i]["RentId"];
        $houses_reserved[$i]["review"] = check_for_a_review_of_rent($rentId);
    }

    echo json_encode($houses_reserved);
}
?>