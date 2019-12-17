<?php
include_once('../includes/database.php');
include_once('../database/db_functions.php');
include_once('../includes/session.php');

$username = $_SESSION['username'];
$name = $_FILES['choose_photo']['name'];
if ($name != null) {
    $file_name = "../assets/profile/$username$name";
    move_uploaded_file($_FILES['choose_photo']['tmp_name'], $file_name);

    $path_current_photo = get_photo_from_usr($username);

    if (file_exists($path_current_photo)) {
        chmod($path_current_photo, 0755); //Change the file permissions if allowed
        unlink($path_current_photo); //remove the file
    }


    new_photo($username, $file_name);
}

header('Location: ../pages/editprofile.php');
