<?php 
  include_once('../includes/session.php');
  include_once('../templates/tpl_common.php');
  include_once('../templates/tpl_auth.php');

  // Verify if user is logged in
  if (isset($_SESSION['username']))
    die(header('Location: homepage.php'));
    
 //   echo '<pre>' , var_dump($_SESSION) , '</pre>';

  draw_header(null);
  draw_register();
  draw_footer();
?>









   
    
  