<?php
include_once('../includes/database.php');
include_once('../database/db_functions.php');
include_once('../includes/session.php');

    $username = $_SESSION['username'];
    $name = $_FILES['choose_photo']['name'];
    $file_name = "../assets/profile/$username$name";
    move_uploaded_file($_FILES['choose_photo']['tmp_name'], $file_name);

    new_photo($username, $file_name);

    header('Location: ../pages/editprofile.php#');
?>