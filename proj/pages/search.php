<?php
    include('../templates/tpl_common.php');
    include('../templates/tpl_pages.php');
    include_once('../includes/session.php');
    include_once('../database/db_functions.php');

    if (!isset($_SESSION['username'])) $usr = null;
    else $usr = $_SESSION['username'];

    $city_id  = $_GET['city_id'];
    $country_id  = $_GET['country_id'];
    $start_date = $_GET['sd'];
    $end_date = $_GET['ed'];

    draw_header($usr, 'search');
    var_dump($city_id, $country_id, $start_date, $end_date);
    draw_footer();
?>