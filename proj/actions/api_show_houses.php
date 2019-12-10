<?php

include_once('../includes/session.php');
include_once('../database/db_functions.php');


$username = $_SESSION['username'];

$houses_owned = get_all_properties_for_a_user($username);

// for($i = 0; $i < count($houses_owned); $i++){
//     $pic = get_house_top_pic($houses_owned['Id']);
//     $cnt = count_comments($houses_owned['Id']);
//     $houses_owned['pic'] = $pic;
//     $houses_owned['cnt'] = $cnt;
// }

echo json_encode($houses_owned);

?>