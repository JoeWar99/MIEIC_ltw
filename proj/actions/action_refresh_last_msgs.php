<?php
include_once('../includes/session.php');
include_once('../database/db_functions.php');

if (!isset($_SESSION['username'])) die(header('Location: homepage.php'));
else $usr = $_SESSION['username'];

$usrid = get_id_from_usr($usr);

$last_rcv_msgs = get_last_recv_msgs($usrid);

function prep_last_rcv_msgs_for_json($last_rcv_msgs){
    $i = 0;
    $result = array(array());
    foreach($last_rcv_msgs as $lm){
        $result[$i]['sid'] = $lm['SenderId'];
        $result[$i]['id'] = intval($lm['Id']);
        $i++;
    }

    return $result;

}

function send_json_obj_l($json){
    global $usrid;
    $a = array();
    foreach($json as $obj){
        array_push($a, $obj);
    }

    echo json_encode($a);
}

$json_obj = prep_last_rcv_msgs_for_json($last_rcv_msgs);
send_json_obj_l($json_obj);
?>