<?php
    include('../templates/tpl_common.php');
    include('../templates/tpl_pages.php');
    include_once('../includes/session.php');
    include_once('../database/db_functions.php');

    if (!isset($_SESSION['username'])) $usr = null;
    else $usr = $_SESSION['username'];

    $city_id  = $_GET['lid'];
    $start_date = $_GET['sd'];
    $end_date = $_GET['ed'];
    $guest_no = $_GET['gn'];

    draw_header($usr, 'search');
    var_dump($city_id, $start_date, $end_date, $guest_no);
    draw_footer();
?>