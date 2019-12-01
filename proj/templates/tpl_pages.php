<?php include_once('../database/db_functions.php'); ?>

<?php

function draw_searchbox(){
    echo "<div id=\"searchbox\">";
        echo "<header>";
            echo "<h2>Find me a cozy place...</h2>";
        echo "</header>";
            echo "<form>";
                echo "<input name=\"Location\" type=\"text\" placeholder=\"Location\" required=\"required\"> <br>";
                
                echo "<input name=\"Start\" type=\"date\" required=\"required\">";

                echo "<input name=\"End\" type=\"date\" required=\"required\"> <br>";

                echo "<select id=\"howmany\" name=\"people\">";
                    echo "<option value=\"1\">1 guest</option>";
                    echo "<option value=\"2\">2 guests</option>";
                    echo "<option value=\"3\">3 guests</option>";
                    echo "<option value=\"4\">4 guests</option>";
                    echo "<option value=\"5\">5 guests</option>";
                    echo "<option value=\"6\">6 guests</option>";
                echo "</select> <br>";
                echo "<button formaction=\"\" formmethod=\"post\">Search</button>";
            echo "</form>";
        echo "</div>";
}

function draw_trending_houses(){
  
    $result = get_top_rated_houses();
    for($i = 0; $i < count($result); $i++){ 
        echo "<div class=\"sample_house\">";
            $pic = get_house_top_pic($result[$i]['Id']);
            echo "<img src=$pic width=\"330\" height=\"230\" />";
            echo "<section name=\"information\">";
            $name = $result[$i]["Name"];
            $id = $result[$i]['Id'];
            echo "<p><a href=\"housepage.php?house_id=$id\"> $name </a></p>";
            $addr = $result[$i]["Address"];
            echo "<p> $addr </p>";
            $price = $result[$i]["PricePerDay"];
            echo "<p> Price: $price /night </p>";
            $rating = $result[$i]["Rating"];
            echo "<p> $rating </p>";
            $cnt = count_comments($result[$i]['Id']);
            echo "<p> $cnt comments</p>";
            echo "</section>";
        echo "</div>";  
    }
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
        echo "<h2>Description</h2>";
        $description = $house_info['Description'];
        echo $description;
    echo "</div>";
}

function draw_house_commodities($commodities){
    echo "<div id=\"Commodities\">";
        echo "<h2>Commodities</h2>";
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
    echo "<h2>Managed by</h2>";
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
    echo "<h2>Comments</h2>";
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

function draw_house_pics($picpath){
    echo "<img src=$picpath alt=\"House_Pic1\" />";
}

function draw_housepage($house_info, $city_info, $country_info, $commodities, $owner_info, $comments, $picpath){
    $name = $house_info['Name'];
    echo "<h1> $name </h1>";
    $city = $city_info['Name']; $country = $country_info['Name'];
    echo "<h3> $city, $country</h3>";

    draw_house_base_info($house_info);
    draw_house_description($house_info);
    draw_house_commodities($commodities);
    draw_house_owners($owner_info);
    draw_house_comments($comments);
    draw_rent_button();
    draw_msg_button();
    draw_house_pics($picpath);
}
?>