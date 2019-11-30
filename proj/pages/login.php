<?php 
  include_once('../includes/session.php');
  include_once('../templates/tpl_common.php');
  include_once('../templates/tpl_auth.php');
  include_once('../database/db_functions.php');

  // Verify if user is logged in
  if (isset($_SESSION['username']))
    die(header('Location: homepage.php'));
  
  draw_header(null, "login");
  draw_login();
  draw_footer();
?>




