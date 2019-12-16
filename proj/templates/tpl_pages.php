<?php
include_once('../database/db_functions.php'); 
include_once('tpl_common.php');



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
                    echo "<span id=\"inputs\">Location: </span><input id=\"input_location\" name=\"location\" type=\"text\" placeholder=\"Location\" required=\"required\">";
                    echo "<div id=\"location_error\" class=\"valError\"> </div>";
                echo "</div>";
                
                echo "<div>";
                    echo "<span id=\"inputs\">Start Date: </span><input id=\"start_time\" name=\"start\" type=\"date\" required=\"required\">";
                    echo "<div id=\"start_error\" class=\"valError\"> </div>";
                echo "</div>";

                echo "<div>";
                    echo "<span id=\"inputs\">End Date: </span><input id=\"end_time\" name=\"end\" type=\"date\" required=\"required\"> <br>";
                    echo "<div id=\"end_error\" class=\"valError\"> </div>";
                echo "</div>";

                echo "<span id=\"inputs\">How Many People: </span><select id=\"guest_no\" name=\"people\">";
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
function draw_house_in_organized_fashion($house)
{

    $pic = get_house_top_pic($house['Id']);
    echo "<img src=$pic width=\"330\" height=\"230\" />";
    echo "<section id=\"trending_houses\" name=\"information\">";
    $name = $house["Name"];
    $id = $house['Id'];
    echo "<p><a id=\"see_house\" href=\"housepage.php?house_id=$id\"> $name </a></p>";
    $addr = $house["Address"];
    echo "<p> $addr </p>";
    $price = $house["PricePerDay"];
    echo "<p> Price: $price € /night </p>";
    $rating = $house["Rating"];
    $cnt = count_comments($house['Id']);
    echo "<p>";
    echo round($rating, 2);
    draw_rating_star(); 
    echo "<span>  $cnt comments</span>";    
    echo "</section>";
}

/**
 * Draws the trending section in the homepage
 */
function draw_trending_houses()
{

    $result = get_top_rated_houses();
    echo "<div id=\"sample_house\">";
    for ($i = 0; $i < count($result); $i = $i + 3) {
        echo "<div class=\"sample_house1\">";
        draw_house_in_organized_fashion($result[$i]);
        echo "</div>";
        echo "<div class=\"sample_house2\">";
        draw_house_in_organized_fashion($result[$i + 1]);
        echo "</div>";
        echo "<div class=\"sample_house3\">";
        draw_house_in_organized_fashion($result[$i + 2]);
        echo "</div>";
    }
    echo "</div>";
}

/**
 * Draws the homepage
 */
function draw_homepage()
{

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
function draw_house_base_info($house_info)
{
    echo "<div id=\"baseinfo\">";
    $rating = $house_info['Rating'];
    echo "<span> $rating";
    draw_rating_star();
    echo "</span><br>";
    $capacity = $house_info['Capacity'];
    echo "<span id=\"capacity\">Room for $capacity guests</span><br>";
    echo "</div>";
}

/**
 * Outputs the description a specific house
 * @param house_info An array containing all the information related to an house
 */
function draw_house_description($house_info)
{
    echo "<div id=\"description_house\">";
    h2("Description");
    $description = $house_info['Description'];
    echo $description;
    echo "</div>";
}

/**
 * Outputs all the commodities of a certain house
 * @param commoditues An array containing all the commodities of a certain house
 */
function draw_house_commodities($commodities)
{
    echo "<div id=\"Commodities\">";
    h2("Commodities");
    echo "<ul>";
    foreach ($commodities as $commodity) {
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
function draw_house_owners($owner_info)
{
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
function draw_house_comments($comments)
{
    echo "<div id=\"Comments\">";
    h2("Comments");
    foreach ($comments as $comment) {
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
function draw_rent_button($hid, $ppd, $capacity){
    echo "<button id=\"rent_house_button\" type=\"button\" >Rent</button>";
}



/**
 * Draws the message the owner button in the page for a certain house
 */
function draw_msg_button(){
    echo "<button id=\"owner_message_button\" type=\"button\">Message Owner</button><br>";
}

/**
 * Draws the house image in the page for a certain house
 * @param picpath the path to the main image for a certain house
 */
function draw_house_pics($picpath){
    echo "<img src=$picpath alt=\"House_Pic1\" />";
}

function draw_rent_form($hid, $tid, $ppd){?>
    <div id="popup">
    <form id="rent_form" style="visibility:hidden;">
    <div id=checkin>
    <h4 id="check_in_text">Check-in:</h4>
    <input id="start_date" name="start_date" type="date" required="required">
    <div id="checkin_error">
    </div>
    </div>

    <div id="checkout">
    <h4 id="check_out_text">Check-out:</h4>
    <input id="end_date" name="end_date" type="date" required="required">
    <div id="checkout_error">
    </div>
    </div>

    <br>
    <input id="ppd" name="ppd" value=<?=$ppd?>  readonly style="visibility:hidden">
    <input id="hid" name="hid" value= <?=$hid?> readonly style="visibility:hidden">
    <input id="tid" name="tid" value= <?=$tid?> readonly style="visibility:hidden">
    <br>
    <button type="submit" id="rent_but" formaction="../actions/action_rent.php" formmethod="post"> RENT </button>
    </form>
    </div>
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
function draw_housepage($house_info, $city_info, $country_info, $commodities, $owner_info, $comments, $picpath, $house_id){
    echo "<div id=\"housepage\">";
    echo "<div id=\"housepage1\">";
    $name = $house_info['Name'];
    h1($name);
    $city = $city_info['Name']; $country = $country_info['Name'];
    h3($city .", " . $country); 
    $photos = get_houses_photos($house_id);

    draw_house_base_info($house_info);
    draw_house_description($house_info);
    draw_house_commodities($commodities);
    draw_house_owners($owner_info);
    echo "</div>";
    echo "<div id=\"housepage2\">";
    draw_rent_button($house_info['Id'], $house_info['PricePerDay'], $house_info['Capacity']);
    draw_msg_button();
    echo "<button id=\"button_left\" onclick=\"mudar(-1)\">&#10094;</button>";
    echo "<button id=\"button_right\" onclick=\"mudar(1)\">&#10095;</button>";
    echo "<div>";
    foreach($photos as $photo){
        draw_image_slide($photo["path"]);
    }
    echo "</div>";
    echo "</div>";
    draw_house_comments($comments);
    echo "</div>";
}

function draw_image_slide($photo){
    echo "<img class=\"slide\" src=$photo>";
}


function draw_search_page($city_id,$country_id, $start_date, $end_date, $guest_no, $house_list){

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


/* START OF FUNCTIONS TO DRAW THE MY PROPERTIES PAGE */

/**
 * Draws the my properties page for a certain user
 * @param usr the user we want to draw the properties for
 */
function draw_my_properties($usr)
{
    // $timezone = date_default_timezone_get();
    // echo "The current server timezone is: " . $timezone;

    echo "<div id=\"MyPropertiesHeader\">";
    echo "<p id=\"MyPropertiesTitle\"> My Properties </p>";


    echo "<button id= \"addProperty\" action=\"javascript:void(0)\">Add Property</button>";
    echo "</div>";
    echo "<div id=\"my_properties\">";
    echo "</div>";
}

/**
 * Draws the my reservations page for a certain user
 * @param usr the user we want to draw the reservations for
 */
function draw_my_reservations($usr)
{
    echo "<p id=\"MyReservationsTitle\"> My Reservations </p>";
    echo "<div id=\"my_reservations\">";
    echo "</div>";
    echo "<div id=\"popup_review\">";
    echo "</div>";
}



function draw_add_property($usr)
{
    echo "<div id=\"MyPropertiesHeader\">";
    echo "<p id=\"MyPropertiesTitle\"> Add Property </p> ";
    echo "</div>";
    ?>

    <div id = "pop-up-comodities">
    </div>

    <form id="add-propertyForm" name="addPropertyForm" action="#" method="post" enctype="multipart/form-data">
        <div id="add-property-content">

            <div id="add-property-form-images">
                <p id="my-images"> Images </p>

                <div id="file-input-grid">

                    <div class="file-input-box">
                        <p> Main Image </p>

                        <div id="preview0">
                            <img src="../assets/imagesHouses/noHouseImage.png" alt="no image" width="200" height="150">
                        </div>
                        <div id="input-0">
                            <label>
                                <input id="file-input0" name="image0" class="InputAddProperty" type="file" placeholder="House Name">
                                <p class="btn-upload-image"> upload Image </p>
                            </label>
                        </div>
                    </div>


                    <div class="file-input-box">
                        <p> Image 1 </p>

                        <div id="preview1">
                            <img src="../assets/imagesHouses/noHouseImage.png" alt="no image" width="200" height="150">
                        </div>
                        <div id="input-1">
                            <label>
                                <input id="file-input1" name="image1" class="InputAddProperty" type="file" placeholder="House Name">
                                <p class="btn-upload-image"> upload Image </p>
                            </label>

                        </div>

                    </div>

                    <div class="file-input-box">
                        <p> Image 2 </p>

                        <div id="preview2">
                            <img src="../assets/imagesHouses/noHouseImage.png" alt="no image" width="200" height="150">
                        </div>
                        <div id="input-2">
                            <label>
                                <input id="file-input2" name="image2" class="InputAddProperty" type="file" placeholder="House Name">
                                <p class="btn-upload-image"> upload Image </p>
                            </label>
                        </div>
                    </div>

                    <div class="file-input-box">
                        <p> Image 3 </p>

                        <div id="preview3">
                            <img src="../assets/imagesHouses/noHouseImage.png" alt="no image" width="200" height="150">
                        </div>
                        <div id="input-3">
                            <label>
                                <input id="file-input3" name="image3" class="InputAddProperty" type="file" placeholder="House Name">
                                <p class="btn-upload-image"> upload Image </p>
                            </label>
                        </div>

                    </div>

                    <div class="file-input-box">
                        <p> Image 4 </p>
                        
                        <div id="preview4">
                            <img src="../assets/imagesHouses/noHouseImage.png" alt="no image" width="200" height="150">
                        </div>
                        <div id="input-4">
                            <label>
                                <input id="file-input4" name="image4" class="InputAddProperty" type="file" placeholder="House Name">
                                <p class="btn-upload-image"> upload Image </p>
                            </label>

                        </div>
                    </div>

                    <div class="file-input-box">
                        
                    <p> Image 5 </p>

                        <div id="preview5">
                            <img src="../assets/imagesHouses/noHouseImage.png" alt="no image" width="200" height="150">
                        </div>
                        <div id="input-5">
                            <label>
                                <input id="file-input5" name="image5" class="InputAddProperty" type="file" placeholder="House Name">
                                <p class="btn-upload-image"> upload Image </p>
                            </label>
                        </div>

                    </div>

                </div>
            </div>

            <div id="add-property-form-text">

                <p id="my-info"> Info </p>

                <input id="house-name" name="HouseName" class="InputAddProperty" type="text" placeholder="House Name">
                <div id="HouseNameError" class="valErrorP"> </div> <br>

                <input id="price-per-day" name="PricePerDay" class="InputAddProperty" type="number" placeholder="Price Per Day">
                <div id="PricePerDayError" class="valErrorP"> </div> <br>

                <input id="adress" name="Adress" class="InputAddProperty" type="text" placeholder="Adress">
                <div id="AdressError" class="valErrorP"> </div> <br>

                <textarea class="InputAddPropertyD" name="description" rows="4" cols="50" placeholder="Description"></textarea>

                <p class="form_place_holder"> Comodities </p>
                <div id = "commoditiesAdd">
                    <input value="Add new comodity" name="addComodityButton" id="addComodityButton" type="button" onclick="pressed_add_comodity();">
                </div>


                <input id="postal-code" name="PostalCode" class="InputAddProperty" type="text" placeholder="Postal Code">
                <div id="PostalCodeError" class="valErrorP"> </div> <br>

                <input id="city" name="City" class="InputAddProperty" type="text" placeholder="City">
                <div id="CityError" class="valErrorP"> </div> <br>

                <input id="country" name="Country" class="InputAddProperty" type="text" placeholder="Country">
                <div id="CountryError" class="valErrorP"> </div> <br>

                <input id="capacity" name="Capacity" class="InputAddProperty" type="number" placeholder="Capacity">
                <div id="CapacityError" class="valErrorP"> </div> <br>

            </div>
        </div>
        <input value="Add Property" name="submitButton" id="btnR2" type="button" onclick="Validate();">

    </form>

    
<?php


}


function draw_edit_property($usr, $house_id)
{   
    $house_id = intval($house_id);
    echo "<div id=\"MyPropertiesHeader\">";
    echo "<p id=\"MyPropertiesTitle\"> Add Property </p> ";
    echo "</div>";

    
    $house_information = get_house_information($house_id);
    
    
    if($house_information == false){
        echo "Some error ocurred";
    }
    
    else{
        
        $city_info = get_city_by_id($house_information['CityId']);
        $city_name = $city_info['Name'];
        $country_name = get_country_by_city_id($city_info['Id']);
        
        ?>

<div id = "pop-up-comodities">
</div>

<form>
<input id="house_id" type="hidden" name="HouseId" value= <?php echo $house_id ?> />
</form>

    <form id="add-propertyForm" name="addPropertyForm" action="#" method="post" enctype="multipart/form-data">
        <div id="add-property-content">

            <div id="add-property-form-images">
                <p id="my-images"> Images </p>

                <div id="file-input-grid">

                    <div class="file-input-box">
                        <p> Main Image </p>

                        <div id="preview0">
                            <img src="../assets/imagesHouses/noHouseImage.png" alt="no image" width="200" height="150">
                        </div>
                        <div id="input-0">
                            <label>
                                <input id="file-input0" name="image0" class="InputAddProperty" type="file" placeholder="House Name">
                                <p class="btn-upload-image"> upload Image </p>
                            </label>
                        </div>
                    </div>


                    <div class="file-input-box">
                        <p> Image 1 </p>

                        <div id="preview1">
                            <img src="../assets/imagesHouses/noHouseImage.png" alt="no image" width="200" height="150">
                        </div>
                        <div id="input-1">
                            <label>
                                <input id="file-input1" name="image1" class="InputAddProperty" type="file" placeholder="House Name">
                                <p class="btn-upload-image"> upload Image </p>
                            </label>

                        </div>

                    </div>

                    <div class="file-input-box">
                        <p> Image 2 </p>

                        <div id="preview2">
                            <img src="../assets/imagesHouses/noHouseImage.png" alt="no image" width="200" height="150">
                        </div>
                        <div id="input-2">
                            <label>
                                <input id="file-input2" name="image2" class="InputAddProperty" type="file" placeholder="House Name">
                                <p class="btn-upload-image"> upload Image </p>
                            </label>
                        </div>
                    </div>

                    <div class="file-input-box">
                        <p> Image 3 </p>

                        <div id="preview3">
                            <img src="../assets/imagesHouses/noHouseImage.png" alt="no image" width="200" height="150">
                        </div>
                        <div id="input-3">
                            <label>
                                <input id="file-input3" name="image3" class="InputAddProperty" type="file" placeholder="House Name">
                                <p class="btn-upload-image"> upload Image </p>
                            </label>
                        </div>

                    </div>

                    <div class="file-input-box">
                        <p> Image 4 </p>
                        
                        <div id="preview4">
                            <img src="../assets/imagesHouses/noHouseImage.png" alt="no image" width="200" height="150">
                        </div>
                        <div id="input-4">
                            <label>
                                <input id="file-input4" name="image4" class="InputAddProperty" type="file" placeholder="House Name">
                                <p class="btn-upload-image"> upload Image </p>
                            </label>

                        </div>
                    </div>

                    <div class="file-input-box">
                        
                    <p> Image 5 </p>

                        <div id="preview5">
                            <img src="../assets/imagesHouses/noHouseImage.png" alt="no image" width="200" height="150">
                        </div>
                        <div id="input-5">
                            <label>
                                <input id="file-input5" name="image5" class="InputAddProperty" type="file" placeholder="House Name">
                                <p class="btn-upload-image"> upload Image </p>
                            </label>
                        </div>

                    </div>

                </div>
            </div>

            <div id="add-property-form-text">

                <p id="my-info"> Info </p>

                <p class="form_place_holder"> House Name </p>
                <input id="house-name" name="HouseName" class="InputAddProperty" type="text" value="<?php echo $house_information['Name'] ?>"  placeholder="House Name">
                <div id="HouseNameError" class="valErrorP"> </div> <br>

                <p class="form_place_holder"> Price per day </p>
                <input id="price-per-day" name="PricePerDay" class="InputAddProperty" type="number" value="<?php echo $house_information['PricePerDay'] ?>" placeholder="Price Per Day">
                <div id="PricePerDayError" class="valErrorP"> </div> <br>

                <p class="form_place_holder"> Adress </p>
                <input id="adress" name="Adress" class="InputAddProperty" type="text" value="<?php echo $house_information['Address'] ?>" placeholder="Adress">
                <div id="AdressError" class="valErrorP"> </div> <br>

                <p class="form_place_holder"> Description </p>
                <textarea class="InputAddPropertyD" name="description" rows="4" cols="50" placeholder="Description"> <?php echo $house_information['Description'] ?> </textarea>

                <p class="form_place_holder"> Comodities </p>
                <div id = "commoditiesAdd">
                    <input value="Add new comodity" name="addComodityButton" id="addComodityButton" type="button" onclick="pressed_add_comodity();">
                </div>

                <p class="form_place_holder"> Postal Code </p>
                <input id="postal-code" name="PostalCode" class="InputAddProperty" type="text" value="<?php echo $house_information['PostalCode'] ?>" placeholder="Postal Code">
                <div id="PostalCodeError" class="valErrorP"> </div> <br>
        
                <p class="form_place_holder"> City </p>
                <input id="city" name="City" class="InputAddProperty" type="text" value= "<?php echo $city_name ?>"  placeholder="City">
                <div id="CityError" class="valErrorP"> </div> <br>

                <p class="form_place_holder"> Country </p>
                <input id="country" name="Country" class="InputAddProperty" type="text" value= "<?php echo $country_name?>" placeholder="Country">
                <div id="CountryError" class="valErrorP"> </div> <br>

                <p class="form_place_holder"> Capacity </p>
                <input id="capacity" name="Capacity" class="InputAddProperty" type="number" value="<?php echo $house_information['Capacity'] ?>" placeholder="Capacity">
                <div id="CapacityError" class="valErrorP"> </div> <br>

            </div>
        </div>
        <input value="Submit edit" name="submitButton" id="btnR2" type="button" onclick="Validate(<?php echo $house_id ?>);">

    </form>
<?php
    }


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
    echo "<p id=\"profile_title\"> My Profile </p>";
    echo "<div id=\"edit_profile\">";
        echo "<div id=\"image_div\">";
        echo "<img id=\"profile_img\" src=$photo alt=\"profile_picture\" height=\"400\" width=\"400\"><br>"; 
        echo "<form action=\"../actions/change_photo.php\" method=\"post\" enctype=\"multipart/form-data\">";
        echo "<label <input type=\"file\" id=\"choose_photo\" name=\"choose_photo\"></input> Choose Image</label>";
        echo "<input type=\"submit\" id=\"change_photo\" value=\"Change\"></input> <br>";
        echo "</form>";
        echo "</div>"; 
        echo "<div id=\"profile_info\">";
        echo "<span><b>Name:</b> $name</span><br>";
        echo "<span><b>Username:</b> $usr</span><br>";
        echo "<span><b>Email:</b> $email</span><br>";
        echo "<span><b>Date of birth:</b> $date</span><br>";
        echo "<button id=\"edit_pro\">Edit Profile</button><br>";
        echo "</div>";
            echo "<div id=\"popup\">";
                echo "<div id=\"popup_content\">";
                echo "<span id=\"close\">&times;</span>";
                echo "<span id=\"edit_text\">Edit Profile </span><br>";
                echo "<form>";
                    echo "<span id=\"username_text\">New Username: </span><br>";
                    echo "<input type=\"text\" id=\"new_username\" name=\"new_username\" placeholder=\"New Username\">";
                    echo "<button id=\"change_username\" type=\"button\">Change Username</button><br>";
                    echo "<span id=\"error_change_username\">  New Username not valid</span>";
                    echo "<span id=\"error_username_size\">  New Username must have at least 6 characters and no special characters</span><br>";
                    echo "<span id=\"password_text\">New Password: </span><br>";
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