<?php
include_once('../database/db_functions.php');
include_once('../includes/session.php');
?>

<?php
    $new_username = trim(strip_tags($_POST['new_username']));
    $old_username = $_SESSION['username'];

    $ret = new_username($old_username, $new_username);

    if($ret != 0){
        echo json_encode(-1);
    }
    else{
        $_SESSION['username'] = $new_username;
        echo json_encode(0);
    }
?>