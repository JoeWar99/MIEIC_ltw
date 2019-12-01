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

    draw_header($usr, "house");
    var_dump($house_info);
    echo "<br>";
    var_dump($city_info);
    echo "<br>";
    var_dump($country_info);
?>
    <h1> <?=$house_info['Name'] ?> </h1>
    <h3> <?= $city_info['Name']?>, <?= $country_info['Name'] ?></h3>
    <ul>
        <li><?=$house_info['Rating']?> stars</li>
        <li><?=$house_info['Rating']?> rooms</li>
        <li><?=$house_info['Rating']?> beds</li>
        <li><?=$house_info['Rating']?> loos</li>
    </ul>

    <div id="description">
        <h2>Description</h2>
        <p> <?=$house_info['Description'] ?> </p>
    </div>
<?php    
draw_footer();
   
?>