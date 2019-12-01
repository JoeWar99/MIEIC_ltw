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
    $city_info = get_city_by_id($house_info['CityId']);
    $country_info = get_country_by_id($city_info['CountryId']);
    $commodities = get_commodities_by_house_id($_GET['house_id']);
    $owner_info = get_house_owner($_GET['house_id']);
    $comments = get_recent_comments($_GET['house_id']);
    $picpath = get_house_top_pic($_GET['house_id']);
    
    draw_header($usr, "house");
    draw_housepage($house_info, $city_info, $country_info, $commodities, $owner_info, $comments, $picpath);
    draw_footer();
   
?>