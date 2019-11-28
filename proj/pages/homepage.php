<?php 
  include('../templates/tpl_common.php');
  include('../templates/tpl_pages.php');
  include_once('../includes/session.php');
  include_once('../database/db_functions.php');

  if (!isset($_SESSION['username']))
    die(header('Location: login.php'));

  draw_header($_SESSION['username']); 
  draw_homepage();
  draw_footer();

?>

