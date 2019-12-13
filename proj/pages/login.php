<?php 
  include_once('../includes/session.php');
  include_once('../templates/tpl_common.php');
  include_once('../templates/tpl_auth.php');
  include_once('../database/db_functions.php');

  // Verify if user is logged in
  if (isset($_SESSION['username']))
    die(header('Location: homepage.php'));
  
  global $main_stylesheet, $fonts;
  
  open_html(); 
  draw_head(get_title("login"), [$main_stylesheet,$fonts[0], $fonts[1], $fonts[2]]);
  open_body();
  open_overlay();
  draw_header(null, "login");
  draw_login();
  footer();
  close_overlay();
  close_body(); 
  close_html();
?>




