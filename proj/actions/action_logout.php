<?php
  include_once('../includes/session.php');
  
  // destroying the session, clean slate
  session_destroy();
  session_start();

  $_SESSION['messages'][] = array('type' => 'success', 'content' => 'Logged out!');

  // redirecting to the login page after log out
  header('Location: ../pages/login.php');

?>