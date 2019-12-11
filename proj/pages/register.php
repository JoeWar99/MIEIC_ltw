<?php 
  include_once('../includes/session.php');
  include_once('../templates/tpl_common.php');
  include_once('../templates/tpl_auth.php');

  // Verify if user is logged in
  if (isset($_SESSION['username']))
    die(header('Location: homepage.php'));
    
 //   echo '<pre>' , var_dump($_SESSION) , '</pre>';

  global $main_stylesheet, $fonts, $register_sl;
  open_html(); 
  draw_head(get_title("register"), [$main_stylesheet,$fonts[0], $fonts[1], $fonts[2]], $register_sl);
  open_body();
  draw_header(null, "register");
  draw_register();
  footer();
  close_body(); 
  close_html();
?>









   
    
  