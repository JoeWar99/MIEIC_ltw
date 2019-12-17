<?php
include_once('../includes/session.php');
include_once('../database/db_functions.php');

$name  = trim(strip_tags(($_POST['name'])));
$dateOfBirth = trim(strip_tags($_POST['dateOfBirth']));
$email = trim(strip_tags(($_POST['email'])));
$username = trim(strip_tags($_POST['username']));
$password = trim(strip_tags($_POST['password']));



if (username_exists($username)) {
    $_SESSION['messageErrorUser'] = 'Username already exists';
}

if (email_exists($email)) {
    $_SESSION['messageErrorEmail'] = 'Email already exists';
}


try {
    create_user($name, $dateOfBirth, $email, $username, $password);
    $_SESSION['username'] = $username;
    header('Location: ../pages/homepage.php');
} catch (PDOException $e) {
    $_SESSION['messages'][] = array('type' => 'error', 'content' => 'Failed to signup!');
    header('Location: ../pages/register.php#');
}
?>
