<?php
include_once('../database/db_functions.php');
include_once('../includes/session.php');
?>

<?php
    $description = $_POST['new_description'];
    $username = $_SESSION['username'];

    $ret = new_description($username, $description);

    if($ret != 0){
        echo json_encode(-1);
    }
    else{
        echo json_encode(0);
    }
?>