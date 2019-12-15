<?php 

  include('../templates/tpl_common.php');
  include('../templates/tpl_pages.php');
  include_once('../includes/session.php');
  include_once('../database/db_functions.php');

  if (!isset($_SESSION['username'])) $usr = null;
  else $usr = $_SESSION['username'];


  global $main_stylesheet, $fonts, $edit_sl;
  open_html();
  draw_head(get_title("editProfile"), [$main_stylesheet,$fonts[0], $fonts[1], $fonts[2]], $edit_sl);
  open_body();
  open_overlay();
  draw_header($usr, "editProfile"); 
  draw_editpage($usr);
  footer();
  close_overlay();
  close_body();
  close_html();

?>