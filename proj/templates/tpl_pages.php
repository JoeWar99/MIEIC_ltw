<?php 
include_once('../database/db_functions.php');
include_once('../template/tpl_common.php');
 ?>

<?php

function draw_searchbox(){
    echo "<div id=\"searchbox\">";
        echo "<header>";
            h2("Find me a cozy place...");
        echo "</header>";
            echo "<form name=\"search_form\">";
                
                echo "<div>";
                    echo "<input name=\"location\" type=\"text\" placeholder=\"Location\" required=\"required\">";
                    echo "<div id=\"location_error\" class=\"valError\"> </div>";
                echo "</div>";
                
                echo "<div>";
                    echo "<input name=\"start\" type=\"date\" required=\"required\">";
                    echo "<div id=\"start_error\" class=\"valError\"> </div>";
                echo "</div>";

                echo "<div>";
                    echo "<input name=\"end\" type=\"date\" required=\"required\"> <br>";
                    echo "<div id=\"end_error\" class=\"valError\"> </div>";
                echo "</div>";

                echo "<select id=\"guest_no\" name=\"people\">";
                    echo "<option value=\"1\">1 guest</option>";
                    echo "<option value=\"2\">2 guests</option>";
                    echo "<option value=\"3\">3 guests</option>";
                    echo "<option value=\"4\">4 guests</option>";
                    echo "<option value=\"5\">5 guests</option>";
                    echo "<option value=\"6\">6 guests</option>";
                    echo "<option value=\"7\">7 guests</option>";
                    echo "<option value=\"8\">8 guests</option>";
                    echo "<option value=\"9\">9 guests</option>";
                echo "</select> <br>";
                echo "<button formaction=\"../actions/action_search.php\" formmethod=\"POST\" onsubmit=\"return Validate()\">Search</button>";
            echo "</form>";
        echo "</div>";
}

function draw_house_list($house_list){
    foreach($house_list as $house){ 
        echo "<div class=\"house_preview\">";
            $pic = get_house_top_pic($house['Id']);
            echo "<img src=$pic width=\"330\" height=\"230\" />";
            echo "<section name=\"information\">";
            $name = $house["Name"];
            $id = $house['Id'];
            echo "<p><a href=\"housepage.php?house_id=$id\"> $name </a></p>";
            $city = get_city_by_id($house["CityId"]);
            $country = get_country_by_id($city["CountryId"]);
            echo "<p>". $city["Name"] . ", " . $country["Name"]. "</p>";
            $price = $house["PricePerDay"];
            echo "<p> Price: $price /night </p>";
            $rating = $house["Rating"];
            echo "<p> $rating </p>";
            $cnt = count_comments($house['Id']);
            echo "<p> $cnt comments</p>";
            echo "</section>";
        echo "</div>";  
    }
}

function draw_trending_houses(){
  
    $result = get_top_rated_houses();
    echo "<div class=\"Trending\">";
    draw_house_list($result);
    echo "</div>";
}

function draw_homepage(){  

    echo "<div id=\"homePage\">";
        draw_searchbox();
        echo "<p> Trending </p>";
        draw_trending_houses();
    echo "</div>";
}

function draw_house_base_info($house_info){
    echo "<div id=\"baseinfo\">";
    echo "<ul>";
        $rating = $house_info['Rating'];
        echo "<li> $rating stars</li>";
        $capacity = $house_info['Capacity'];
        echo "<li>Room for $capacity guests</li>";
    echo "</ul>";
    echo "</div>";
}

function draw_house_description($house_info){
    echo "<div id=\"description\">";
        h2("Description");
        $description = $house_info['Description'];
        echo $description;
    echo "</div>";
}

function draw_house_commodities($commodities){
    echo "<div id=\"Commodities\">";
        h2("Commodities");
        echo "<ul>";
        foreach($commodities as $commodity){
            $type = $commodity['Type'];
            echo "<li>$type</li>";
        
        }
        echo "</ul>";
    echo "</div>";
}

function draw_house_owners($owner_info){
    echo "<div id=\"Owners\">";
        h2("Managed by");
        echo "<ul>";
            $name = $owner_info["Name"];
            $email = $owner_info["Email"];
            echo "<li>$name</li>";
            echo "<li>$email</li>";
        echo "</ul>";
    echo "</div>";
}

function draw_house_comments($comments){
    echo "<div id=\"Comments\">";
    h2("Comments");
    foreach($comments as $comment){
        echo "<div id=\"Username\">";
            echo $comment["Username"];
        echo "</div>";
        
        echo "<div id=\"Date\">";
            echo $comment["Date"];
        echo "</div>";
        
        echo "<div id=\"Text\">";
            echo $comment["Text"];
        echo "</div>";
    }
    echo "</div>";
}

function draw_rent_button(){
    echo "<button type=\"button\">Rent</button>";
}

function draw_msg_button(){
    echo "<button type=\"button\">Message Owner</button>";
}

function draw_housepage($house_info, $city_info, $country_info, $commodities, $owner_info, $comments, $picpath){
    $name = $house_info['Name'];
    h1($name);
    $city = $city_info['Name']; $country = $country_info['Name'];
    h3($city .", " . $country);

    draw_house_base_info($house_info);
    draw_house_description($house_info);
    draw_house_commodities($commodities);
    draw_house_owners($owner_info);
    draw_house_comments($comments);
    draw_rent_button();
    draw_msg_button();
    draw_pic($picpath, "House_PIC1");
}

function draw_search_page($city_id, $start_date, $end_date, $guest_no){
   
}
?>