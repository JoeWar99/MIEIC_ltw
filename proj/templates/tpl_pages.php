<?php 
include_once('../database/db_functions.php');
include_once('tpl_common.php');
 ?>

<?php



/* START OF FUNCTIONS TO DRAW THE HOMEPAGE */

/**
 * Draws the search box in the homepage
 */
function draw_searchbox(){
    echo "<div id=\"searchbox\">";
        echo "<header>";
            h2("Find me a cozy place...");
        echo "</header>";
            echo "<form name=\"search_form\">";
                
                echo "<div>";
                    echo "<input name=\"location\" id=\"location\" type=\"text\" placeholder=\"Location\" required=\"required\">";
                    echo "<div id=\"location_error\" class=\"valError\"> </div>";
                echo "</div>";
                
                echo "<div>";
                    echo "<input name=\"start\" id=\"start\" type=\"date\" required=\"required\">";
                    echo "<div id=\"start_error\" class=\"valError\"> </div>";
                echo "</div>";

                echo "<div>";
                    echo "<input name=\"end\" id=\"end\" type=\"date\" required=\"required\"> <br>";
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

function draw_rating_star(){
    echo "<img src=../assets/star.png width=\"18\" height=\"15\" />";
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
    echo "<p> Price: $price € /night </p>";
    $rating = $house["Rating"];
    $cnt = count_comments($house['Id']);
    echo "<p> $rating";
    draw_rating_star(); 
    echo "$cnt comments</p>";
    echo "</section>";
}


/**
 * Draws the trending section in the homepage
 */
function draw_trending_houses(){
  
    $result = get_top_rated_houses();
    echo "<div id=\"sample_house\">";
        for($i = 0; $i < count($result); $i = $i + 3){ 
        echo "<div class=\"sample_house1\">";
            draw_house_in_organized_fashion($result[$i]);
        echo "</div>";  
        echo "<div class=\"sample_house2\">";
            draw_house_in_organized_fashion($result[$i+1]);
        echo "</div>";  
        echo "<div class=\"sample_house3\">";
            draw_house_in_organized_fashion($result[$i+2]);
        echo "</div>";  
        }
    echo "</div>";
}

function draw_homepage(){  

    echo "<div id=\"homePage\">";
        draw_searchbox();
        echo "<div id=\"trending\">";
        echo "<p> Trending </p>";
        echo "</div>";
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
        echo "<li> $rating";
        draw_rating_star();
        echo "</li>";
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
        h2("Description");
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
        h2("Commodities");
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
        h2("Managed by");
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

/** 
 * Draws the rent button in the page for a certain house
 */
function draw_rent_button(){
    echo "<button id=\"rent_button\" type=\"button\" >Rent</button>";
}


/**
 * Draws the message the owner button in the page for a certain house
 */
function draw_msg_button(){
    echo "<form method\"GET\" action=\"../pages/myMessages.php\">";
    echo "<button id=\"message_button\" type=\"submit\">Message Owner</button>";
    echo "</form>";
}

/**
 * Draws the house image in the page for a certain house
 * @param picpath the path to the main image for a certain house
 */
function draw_house_pics($picpath){
    echo "<img src=$picpath alt=\"House_Pic1\" />";
}

function draw_rent_form($hid, $tid, $ppd){?>
    <form id="rent_form" style="visibility:hidden;">
    <div id=checkin>
    <h4>Check-in:</h4>
    <input id="start_date" name="start_date" type="date" required="required">
    <div id="checkin_error">
    </div>
    </div>

    <div id="checkout">
    <h4>Check-out:</h4>
    <input id="end_date" name="end_date" type="date" required="required">
    <div id="checkout_error">
    </div>
    </div>

    <br>
    <input id="ppd" name="ppd" value=<?=$ppd?>  readonly style="visibility:hidden">
    <input id="hid" name="hid" value= <?=$hid?> readonly style="visibility:hidden">
    <input id="tid" name="tid" value= <?=$tid?> readonly style="visibility:hidden">
    <br>
    <button type="submit" formaction="../actions/action_rent.php" formmethod="post"> RENT </button>
    </form>
<?php   
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
    echo "<div id=\"housepage\">";
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
    echo "</div>";
}

function draw_search_page($city_id, $country_id, $start_date, $end_date, $guest_no, $house_list){

    h2("Showing results for places in: ". get_city_by_id($city_id)['Name'] . ", " . get_country_by_id($country_id)['Name']);
    $tmp1 = explode("-", $start_date);
    $tmp2 = explode("-", $end_date);
    h3($tmp1[2] . "/" . $tmp1[1] . "/" . $tmp1[0] . " - " . $tmp2[2] . "/" . $tmp2[1] . "/" . $tmp2[0]);
    
    if ($house_list != false) draw_house_list($house_list);
    else {
        echo "<p>";
            echo "No results matched your search, try to broaden your paramenters.";
        echo "</p>";
    }
}

/* END OF FUNCTIONS TO DRAW THE HOUSE PAGE */

/* MESSAGES */
function draw_my_contacts($contacts){

    if(!$contacts) echo "<p>Nothing to see here...</p>";
    else {
        echo "<form id=\"user_select_form\">";
        echo "<select id=\"select_user\" name=\"select_user\">";
        foreach($contacts as $id){
            $usrname = get_name_from_id($id);
            echo "<option value=" . $usrname['Username'] .  ">" .  $usrname['Username'] . "</option>";
            
        }
        echo "</select>";

        foreach($contacts as $id){
            $usrname = get_name_from_id($id);
            echo "<input id=". $usrname['Username'] ." value=\"". intval($id). "\" style=\"visibility:hidden\">";
        }
        echo "</form>";
    }
}

function draw_my_messages($contacts, $usrid){
    draw_my_contacts($contacts);
    ?>
    <div id="messages_area">
    </div>

    <form id="message_form">
    <textarea rows="2" cols="50" name="message"></textarea>
    <input id="my_id" name="my_id" value= <?=$usrid?> readonly style="visibility:hidden">
    <input id="their_id" name="their_id" value= <?=intval($contacts[0])?> style="visibility:hidden">
    </form>
<?php
}

/* END OF MESSAGES */
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

/* START OF FUNCTIONS TO DRAW THE EDIT PROFILE PAGE */

function draw_editpage($usr){
    $name = get_name_from_usr($usr);
    $email = get_email_from_usr($usr);
    $date = get_date_from_usr($usr);
    $description = get_description_from_usr($usr);
    if($description == NULL) $description = "Description";
    $photo = get_photo_from_usr($usr);
    if($photo == NULL) $photo = "..\assets\profile.jpg";
    echo "<p> My Profile </p>";
    echo "<div id=\"edit_profile\">";
        echo "<div id=\"image_div\">";
        echo "<img id=\"profile_img\" src=$photo alt=\"profile_picture\" height=\"400\" width=\"400\"><br>"; 
        echo "<form action=\"../actions/change_photo.php\" method=\"post\" enctype=\"multipart/form-data\">";
        echo "<label> <input type=\"file\" id=\"choose_photo\" name=\"choose_photo\"></input> Choose Image</label>";
        echo "<input type=\"submit\" id=\"change_photo\" value=\"Change\"></input> <br>";
        echo "</form>";
        echo "</div>"; 
        echo "<div id=\"profile_info\">";
        echo "<span>Name: $name</span><br>";
        echo "<span>Username: $usr</span><br>";
        echo "<span>Email: $email</span><br>";
        echo "<span>Date of birth: $date</span><br>";
        echo "<button id=\"edit_pro\">Edit Profile</button><br>";
        echo "</div>";
            echo "<div id=\"popup\">";
                echo "<div id=\"popup_content\">";
                echo "<span id=\"close\">&times;</span>";
                echo "<form>";
                    echo "New Username: <br>";
                    echo "<input type=\"text\" id=\"new_username\" name=\"new_username\" placeholder=\"New Username\">";
                    echo "<button id=\"change_username\" type=\"button\">Change Username</button><br>";
                    echo "<span id=\"error_change_username\">  New Username not valid</span>";
                    echo "<span id=\"error_username_size\">  New Username must have at least 6 characters and no special characters</span><br>";
                    echo "New Password: <br>";
                    echo "<input type=\"password\" id=\"new_password\" name=\"new_password\" placeholder=\"New Password\"><br>";
                    echo "<input type=\"password\" id=\"new_password2\" name=\"new_password\" placeholder=\"Confirm Password\">";
                    echo "<button id=\"change_password\" type=\"button\">Change Password</button><br>";
                    echo "<span id=\"error_pass\" >  Password must have a minimum of six characters and contain at least one uppercase letter, one lowercase letter and one number</span>";
                    echo "<span id=\"error_pass2\" >  Passwords don't match</span>";
                    echo "</form>";
            echo "</div>";
        echo "</div>";
        echo "<div id=\"description_div\">";
        echo "<input type=\"text\" id=\"description\" name=\"description\" placeholder=\"$description\"><br>";
        echo "<button id=\"edit_des\" type=\"button\">Change Description</button><br>";
        echo "</div>";
        echo "</div>";

}

?>