<?php
include_once('../database/db_functions.php');
include_once('../includes/session.php');
?>

<?php
    $new_password = $_POST['new_password'];
    $username = $_SESSION['username'];

    $ret = new_password($username, $new_password);

    if($ret != 0){
        echo json_encode(-1);
    }
    else echo json_encode(0);
?>