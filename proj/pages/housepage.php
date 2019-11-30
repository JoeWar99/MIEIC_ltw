<?php
    include('../templates/tpl_common.php');
    include('../templates/tpl_pages.php');
    include_once('../includes/session.php');
    include_once('../database/db_functions.php');

    if(!isset($_GET['house_id']) || ($house_id = intval($_GET['house_id'])) === 0)
        die(header('Location: 404page.php')); 

    if (!isset($_SESSION['username'])) $usr = null;
    else $usr = $_SESSION['username'];

    $house_info = get_house_by_id($_GET['house_id']);

    draw_header($usr, "house");
    var_dump($house_info);
    draw_footer();
   
?>