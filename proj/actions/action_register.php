<?php
include_once('../includes/session.php');
include_once('../database/db_functions.php');

$name  = $_POST['name'];
$dateOfBirth = $_POST['dateOfBirth'];
$email = $_POST['email'];
$username = $_POST['username'];
$password = $_POST['password'];

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
