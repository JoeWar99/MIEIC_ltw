<?php 

  include('../templates/tpl_common.php');
  include('../templates/tpl_pages.php');
  include_once('../includes/session.php');
  include_once('../database/db_functions.php');

  if (!isset($_SESSION['username'])) die(header('Location: homepage.php')); 
  else $usr = $_SESSION['username'];


  $house_id = $_POST['HouseId'];

  draw_header($usr, "addProperty"); 
  draw_edit_property($usr, $house_id);
  draw_footer();

?>
