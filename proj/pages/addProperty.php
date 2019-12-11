<?php 

  include('../templates/tpl_common.php');
  include('../templates/tpl_pages.php');
  include_once('../includes/session.php');
  include_once('../database/db_functions.php');

  if (!isset($_SESSION['username'])) die(header('Location: homepage.php')); 
  else $usr = $_SESSION['username'];

  draw_header($usr, "addProperty"); 
  draw_add_property($usr);
  draw_footer();

?>
