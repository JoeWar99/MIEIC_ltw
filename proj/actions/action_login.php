<?php
  include_once('../includes/session.php');
  include_once('../database/db_functions.php');

  $username_or_email = $_POST['username_or_email'];
  $password = $_POST['password'];

  if (check_usr_pass($username_or_email, $password)) {
    $_SESSION['username'] = $username_or_email;
    $_SESSION['message']= 'Logged in successfully!';
    header('Location: ../pages/homepage.php');
  }
   
  else {
    $_SESSION['message'] = 'Login failed! Username or password incorrect';
    header('Location: ../pages/login.php');
  }
  
?>



