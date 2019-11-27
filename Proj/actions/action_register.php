<?php
include_once('../includes/session.php');
include_once('../database/db_functions.php');


$name  = $_POST['name'];
$dateOfBirth = $_POST['dateofbirth'];
$email = $_POST['email'];
$username = $_POST['username'];
$password = $_POST['password'];


//Don't allow certain characters
if (!preg_match("/^[a-zA-Z0-9]+$/", $username)) {
    $_SESSION['messages'][] = array('type' => 'error', 'content' => 'Username can only contain letters and numbers!');
    die(header('Location: ../pages/register.php'));
}


try {
    createUser($name, $dateOfBirth, $email, $username, $password);
    $_SESSION['username'] = $username;
    $_SESSION['messages'][] = array('type' => 'success', 'content' => 'Signed up and logged in!');
    header('Location: ../pages/homepage.php');
} 
catch (PDOException $e){
    $_SESSION['messages'][] = array('type' => 'error', 'content' => $e->getMessage());
    header('Location: ../pages/register.php');
}
