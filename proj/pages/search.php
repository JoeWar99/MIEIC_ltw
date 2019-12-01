<?php
    include('../templates/tpl_common.php');
    include('../templates/tpl_pages.php');
    include_once('../includes/session.php');
    include_once('../database/db_functions.php');

    if (!isset($_SESSION['username'])) $usr = null;
    else $usr = $_SESSION['username'];

    $location  = $_GET['location'];
    $start_date = $_GET['sd'];
    $end_date = $_GET['ed'];

    draw_header($usr, "result");
    var_dump($location, $start_date, $end_date);
    draw_footer();
?>