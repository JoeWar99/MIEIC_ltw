<?php 

  include('../templates/tpl_common.php');
  include('../templates/tpl_pages.php');
  include_once('../includes/session.php');
  include_once('../database/db_functions.php');

  if (!isset($_SESSION['username'])) die(header('Location: homepage.php')); 
  else $usr = $_SESSION['username'];

  global $main_stylesheet, $fonts, $addProperty_sl;
  open_html(); 
  draw_head(get_title("addProperty"), [$main_stylesheet,$fonts[0], $fonts[1], $fonts[2]], $addProperty_sl);
  open_body();
  open_overlay();
  draw_header($usr, "addProperty"); 
  draw_add_property($usr);
  footer();
  close_overlay();
  close_body();
  close_html();

?>
