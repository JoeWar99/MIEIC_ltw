<?php 

  include('../templates/tpl_common.php');
  include('../templates/tpl_pages.php');
  include_once('../includes/session.php');
  include_once('../database/db_functions.php');

  if (!isset($_SESSION['username'])) $usr = null;
  else $usr = $_SESSION['username'];

  
  
  draw_header($usr, "edit"); 
  draw_editpage($usr);
  draw_footer();

?>