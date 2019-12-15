<?php 

  include('../templates/tpl_common.php');
  include('../templates/tpl_pages.php');
  include_once('../includes/session.php');
  include_once('../database/db_functions.php');

  if (!isset($_SESSION['username'])) die(header('Location: homepage.php')); 
  else $usr = $_SESSION['username'];


  $house_id = $_POST['HouseId'];
  global $main_stylesheet, $fonts, $editProperty_sl;
  
  open_html(); 
  draw_head(get_title("editProperty"), [$main_stylesheet,$fonts[0], $fonts[1], $fonts[2]], $editProperty_sl);
  open_body();
  open_overlay();
  draw_header($usr, "editProperty"); 
  draw_edit_property($usr, $house_id);
  footer();
  close_overlay();
  close_body();
  close_html();
?>
