<?php 
  include_once('../includes/session.php');
  include_once('../templates/tpl_common.php');
  include_once('../templates/tpl_auth.php');

  // Verify if user is logged in
  if (isset($_SESSION['username']))
    die(header('Location: homepage.php'));
    
 //   echo '<pre>' , var_dump($_SESSION) , '</pre>';

  global $main_stylesheet, $fonts;
  //draw_header(null);
  open_html();
  draw_head("Register", [$main_stylesheet,$fonts[0], $fonts[1], $fonts[2]], [["../js/register.js", true]]);
  open_body();
  open_header();
  close_header();
  draw_register();
  draw_footer();
?>









   
    
  