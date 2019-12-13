<?php 

  include('../templates/tpl_common.php');
  include('../templates/tpl_pages.php');
  include_once('../includes/session.php');
  include_once('../database/db_functions.php');

  if (!isset($_SESSION['username'])) $usr = null;
  else $usr = $_SESSION['username'];

  
  global $main_stylesheet, $fonts, $search_sl;
  open_html();
  draw_head(get_title("home"), [$main_stylesheet,$fonts[0], $fonts[1], $fonts[2]], $search_sl);
  open_body();
  open_overlay();
  draw_header($usr, "home"); 
  draw_homepage();
  footer();
  close_overlay();
  close_body(); 
  close_html();
?>

