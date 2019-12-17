<?php
    include('../templates/tpl_common.php');
    include('../templates/tpl_pages.php');
    include_once('../includes/session.php');
    include_once('../database/db_functions.php');

    if(!isset($_GET['house_id']) || ($house_id = intval($_GET['house_id'])) === 0)
        die(header('Location: 404.php')); 

    if (!isset($_SESSION['username'])){
         $usr = null;
         $usrid = null;
    }
    else {
        $usr = $_SESSION['username'];
        $usrid = get_id_from_usr($usr);
    }

    $house_id = $_GET['house_id'];
    $house_info = get_house_by_id($_GET['house_id']);
    $city_info = get_city_by_id($house_info['CityId']);
    $country_info = get_country_by_id($city_info['CountryId']);
    $commodities = get_commodities_by_house_id($_GET['house_id']);
    $owner_info = get_house_owner($_GET['house_id']);
    $comments = get_recent_comments($_GET['house_id']);
    $picpath = get_house_top_pic($_GET['house_id']);
    
    global $main_stylesheet, $fonts, $logged_house_sl, $not_logged_house_sl;
    if($usr != NULL)$sl = $logged_house_sl;
    else $sl = $not_logged_house_sl;

    open_html(); 
    draw_head(get_title("house"), [$main_stylesheet,$fonts[0], $fonts[1], $fonts[2]], $sl);
    open_body();
    open_overlay();
    draw_header($usr, "house");
    draw_housepage($house_info, $city_info, $country_info, $commodities, $owner_info, $comments, $picpath, $house_id, $usrid);
    close_overlay();
    draw_rent_form($house_info['Id'], $usrid, $house_info['PricePerDay']);
    footer();
    close_body();
    close_html();
   
?>