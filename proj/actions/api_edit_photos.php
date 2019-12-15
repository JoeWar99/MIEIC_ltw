<?php
include_once('../includes/session.php');
include_once('../database/db_functions.php');

file_put_contents('somefilename.txt', print_r($_POST, true), FILE_APPEND);


$house_id = $_POST['houseId'];


$house_photos = get_houses_photos($house_id);

if($house_photos == -1){
    echo json_encode(-1);
}
else{
    echo json_encode($house_photos);
}
?>