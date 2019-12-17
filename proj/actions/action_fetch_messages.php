<?php
include_once('../includes/session.php');
include_once('../database/db_functions.php');

if (!isset($_GET['mid']) || !isset($_GET['tid'])) die(header("Location: ../pages/404.php"));

$mid = intval($_GET['mid']);
$tid = intval($_GET['tid']);

$their_user = get_name_from_id($tid)['Username'];

$msgs = get_msgs_bw_2_usrs($mid, $tid);

function draw_msg($msg, $usrname){
    echo "<div id=\"sender\">";
    echo $usrname;
    echo "</div>";
    
    echo "<div id=\"content\">";
    echo $msg['Content'];
    echo "</div>";

    echo "<div id=\"timestamp\">";
    echo $msg['SentDate'];
    echo "</div>";
}

function my_msg($msg){
    echo "<div class=\"my_msg\" id=\"". intval($msg['SenderId']). "\">";
    draw_msg($msg, "You");
    echo "</div>";
}

function their_msg($msg){
    global $their_user;
    echo "<div class=\"their_msg\" id=\"". intval($msg['SenderId']). "\">";
    draw_msg($msg, $their_user);
    echo "</div>";
}

if (!$msgs) echo "<p>Nothing to see here...</p>";
else {
    foreach($msgs as $msg){
        if (intval($msg['SenderId']) == $mid) my_msg($msg);
        else their_msg($msg);
        echo "<br>";
    }
}

?>