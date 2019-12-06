<?php
    include('../templates/tpl_common.php');
    include('../templates/tpl_pages.php');
    include_once('../includes/session.php');
    include_once('../database/db_functions.php');

    if (!isset($_GET['city_id']) || ($city_id = intval( $_GET['city_id'])) === 0 || 
    !isset($_GET['country_id']) || ($country_id = intval( $_GET['country_id'])) === 0
    || !isset($_GET['gn']) || ($guest_no = intval($_GET['gn'])) === 0 || $guest_no > 9
    || !isset($_GET['sd']) || strlen($_GET['sd']) != 10
    || !isset($_GET['ed']) || strlen($_GET['ed']) != 10) 
        die(header("Location: 404.php"));

    $start_date = $_GET['sd'];
    $end_date = $_GET['ed'];

    if (!isset($_SESSION['username'])) $usr = null;
    else $usr = $_SESSION['username'];

    draw_header($usr, 'search');
    h2("Showing results for places in: ". get_city_by_id($city_id)['Name'] . ", " . get_country_by_id($country_id)['Name']);
    $tmp1 = explode("-", $start_date);
    $tmp2 = explode("-", $end_date);
    h3($tmp1[2] . "/" . $tmp1[1] . "/" . $tmp1[0] . " - " . $tmp2[2] . "/" . $tmp2[1] . "/" . $tmp2[0]);
    var_dump($city_id, $country_id, $start_date, $end_date, $guest_no);
    draw_footer();
?>