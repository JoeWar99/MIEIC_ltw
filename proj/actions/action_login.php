<?php
  include_once('../includes/session.php');
  include_once('../database/db_functions.php');

  // trimming the password or email after the input, eliminating spaces in the beginning and in the end
  $username_or_email = trim(strip_tags($_POST['username_or_email']));
  $password = trim(strip_tags($_POST['password']));

  // checking if the username or email and password are valid one , if so the session start
  if (check_usr_pass($username_or_email, $password)) {
    $_SESSION['username'] = $username_or_email;
    $_SESSION['message']= 'Logged in successfully!';
    header('Location: ../pages/homepage.php');
  }
  
  // if the username and password doenst check out to any valid username and password then we say login failed and we 
  // go back to the login page and display the error
  else {
    $_SESSION['message'] = 'Login failed! Username or password incorrect';
    die(header('Location: ' . $_SERVER['HTTP_REFERER']));
  }
  
?>



