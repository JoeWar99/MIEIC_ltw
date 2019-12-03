<?php include_once('../database/db_functions.php'); ?>

<?php



/* START OF FUNCTIONS TO DRAW THE HOMEPAGE */

/**
 * Draws the search box in the homepage
 */
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

/**
 * Outputs all of the information about a house in a organized fashion
 * @param house all the information about a specific house
 */
function draw_house_in_organized_fashion($house){

    $pic = get_house_top_pic($house['Id']);
    echo "<img src=$pic width=\"330\" height=\"230\" />";
    echo "<section name=\"information\">";
    $name = $house["Name"];
    $id = $house['Id'];
    echo "<p><a href=\"housepage.php?house_id=$id\"> $name </a></p>";
    $addr = $house["Address"];
    echo "<p> $addr </p>";
    $price = $house["PricePerDay"];
    echo "<p> Price: $price /night </p>";
    $rating = $house["Rating"];
    echo "<p> $rating </p>";
    $cnt = count_comments($house['Id']);
    echo "<p> $cnt comments</p>";
    echo "</section>";
}

/**
 * Draws the trending section in the homepage
 */
function draw_trending_houses(){
  
    $result = get_top_rated_houses();
    for($i = 0; $i < count($result); $i++){ 
        echo "<div class=\"sample_house\">";
            draw_house_in_organized_fashion($result[$i]);
        echo "</div>";  
    }
}

/**
 * Draws the homepage
 */
function draw_homepage(){  

    echo "<div id=\"homePage\">";
        draw_searchbox();
        echo "<p> Trending </p>";
        draw_trending_houses();
    echo "</div>";
}

/* END OF FUNCTIONS TO DRAW THE HOMEPAGE */


/* START OF FUNCTIONS TO DRAW THE HOUSE PAGE*/

/**
 * Outputs the basic information for a house
 * @param $house_info An array containing all the information related to an house
 */
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

/**
 * Outputs the description a specific house
 * @param house_info An array containing all the information related to an house
 */
function draw_house_description($house_info){
    echo "<div id=\"description\">";
        echo "<h2>Description</h2>";
        $description = $house_info['Description'];
        echo $description;
    echo "</div>";
}

/**
 * Outputs all the commodities of a certain house
 * @param commoditues An array containing all the commodities of a certain house
 */
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

/**
 * Outputs the information for the owner of an house
 * @param owner_info An array containing all the info of the owner on an house
 */
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


/**
 * Outputs the comments for a certain house
 * @param comments an array containing the recent comments for a certain house
 */
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

/** 
 * Draws the rent button in the page for a certain house
 */
function draw_rent_button(){
    echo "<button type=\"button\">Rent</button>";
}


/**
 * Draws the message the owner button in the page for a certain house
 */
function draw_msg_button(){
    echo "<button type=\"button\">Message Owner</button>";
}

/**
 * Draws the house image in the page for a certain house
 * @param picpath the path to the main image for a certain house
 */
function draw_house_pics($picpath){
    echo "<img src=$picpath alt=\"House_Pic1\" />";
}

/**
 * Draws the page for a certain page
 * @param  house_info an array basic information about the house
 * @param city_info the city the house is on
 * @param country_info the country the house is on
 * @param commodities an array with the commodities of the house
 * @param owner_info an array containing the info for the owner of the house
 * @param comments an array containing the most recent comments for the house
 * @param picpath the path to the main image for the house
 */
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

/* END OF FUNCTIONS TO DRAW THE HOUSE PAGE */


/* START OF FUNCTIONS TO DRAW THE MY PROPERTIES PAGE */

/**
 * Draws the my properties page for a certain user
 * @param usr the user we want to draw the properties for
 */
function draw_my_properties($usr){

    $houses_owned = get_all_properties_for_a_user($usr);
    
    echo "<div id=\"my_properties\">";

    if($houses_owned != -1){
        for($i = 0; $i < count($houses_owned); $i = $i + 2){ 
            echo "<div class=\"my_properties1\">";
                draw_house_in_organized_fashion($houses_owned[$i]);
            echo "</div>"; 
            if($i+1 < count($houses_owned)){
                echo "<div class=\"my_properties2\">";
                    draw_house_in_organized_fashion($houses_owned[$i+1]);
                echo "</div>";   
            }
        }
    }
    else{
        die(header('Location: 404page.php')); 
    }
    echo "</div>"; 

}

/**
 * Draws the my reservations page for a certain user
 * @param usr the user we want to draw the reservations for
 */
function draw_my_reservations($usr){

    $houses_rented = get_all_reservations_for_a_user($usr);
    
    echo "<div id=\"my_reservations\">";

    if($houses_rented != -1){
        for($i = 0; $i < count($houses_rented); $i = $i + 2){ 
            
            echo "<div class=\"my_reservations1\">";
                draw_house_in_organized_fashion($houses_rented[$i]);
            echo "</div>"; 
            if($i+1 < count($houses_rented)){
                echo "<div class=\"my_reservations2\">";
                    draw_house_in_organized_fashion($houses_rented[$i+1]);
                echo "</div>";  
            }
        }
    }
    else{
        die(header('Location: 404page.php')); 
    }
    echo "</div>";  
}

?>