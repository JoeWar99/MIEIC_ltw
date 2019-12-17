'use strict'

// function to encode information for an ajax request 

/**
 * function to encode information for an ajax request 
 * @param {*} data The data to encode 
 */
function encodeForAjax(data) {
    return Object.keys(data).map(function(k) {
        return encodeURIComponent(k) + '=' + encodeURIComponent(data[k])
    }).join('&')
}


/**
 * function meant to replace the alert given by javascript since some browsers have them disabled
 * @param {*} message the message we want to display with the alert
 */
function give_alert(message) {


    let error_popup = document.getElementById("error-popup");

    let return_html_in_string_form = '<div id="popup_content"> <span id="close">&times;</span> <h3>Alert</h3>  <p>' + message + '</p> <button id="close1">Ok</button> </div>';

    error_popup.innerHTML = return_html_in_string_form;

    let x = document.getElementById("close");
    let ok = document.getElementById("close1");

    error_popup.style.display = "block";

    ok.onclick = function() {
        error_popup.style.display = "none";
    }

    x.onclick = function() {
        error_popup.style.display = "none";
    }

    window.onclick = function(event) {
        if (event.target == error_popup) {
            error_popup.style.display = "none";
        }
    }
}

/**
 * function that impose a reaction to being pressed the cancel button for one reservation
 * also works when the person presses the arquive button , since both have the same impact.
 * A http request is sent to see if we can eliminate the reservation
 * @param {*} rent_id the id of the rent we want to cancel
 */
function pressed_cancel_Button(rent_id) {

    // preparing the xmlhttprequest()
    let ourRequest = new XMLHttpRequest();
    ourRequest.open("POST", "../actions/api_cancel_reservation.php", true);
    ourRequest.setRequestHeader('Content-Type', 'application/x-www-form-urlencoded');
    ourRequest.onload = cancel_reservation;
    ourRequest.send(encodeForAjax({ rent_id: rent_id }));
}

/**
 * function that parses the responses sent by the api_cancel_reservation.php, by the server
 */
function cancel_reservation() {

    let ourData = JSON.parse(this.responseText);

    // Means since the occupation period already started it is impossible to cancel the reservation
    // kind useless since when the occupation begins we stop giving the option to cancel the reservation, but just in case
    if (ourData == -1)
        give_alert("Can't cancel that reservation because the occupation period already started");

    // if the response sent was a positive one, means the reservation was canceled with sucess, so we reload the html in the page   
    else if (ourData == true) {
        reloadHtmlRequest();

    }
    // means some error occured in the query in api side, PDO exception
    else
        give_alert("Can't cancel that reservation, some error occured");
}

/**
 * function that process the action of the user pressing the review button for a reservation 
 * @param {*} rent_id the id of the rent we pressed the review button for
 */
function pressed_review_Button(rent_id) {

    // getting the div that represent the popup for the review of a reservation
    var popup = document.getElementById("popup_review");

    // configuring the review pop up inner html
    let return_html_in_string_form = '<div id="popup_content_review"><span id="close">&times;</span><form><span id=\"rating_text\">Rating: </span><br><input type="text" id="new_rating" name="new_rating" placeholder="Rating"><br>';
    return_html_in_string_form += '<span id=\"error_rating\" >  Rating between 1 and 5</span><span id=\"review_text\">Review: </span><br><textarea type="text" id="new_review" name="new_review" placeholder="Review"></textarea><br>';
    return_html_in_string_form += '<button id="create_review" type="button" onclick="pressed_create_review(' + rent_id + ')">Submit</button><br>';
    return_html_in_string_form += '</form></div>';
    popup.innerHTML = return_html_in_string_form;


    // configuring the options to be able to close the review pop up
    let x = document.getElementById("close");
    let error_rating = document.getElementById("error_rating");

    popup.style.display = "block";

    // closing the pop up by pressing the x on the top right corner of the popuo
    x.onclick = function() {
        popup.style.display = "none";
        error_rating.style.display = "none";
    }

    // closing the pop up by pressing the window outside of the pop up
    window.onclick = function(event) {
        if (event.target == popup) {
            popup.style.display = "none";
            error_rating.style.display = "none";
        }
    }
}


/**
 * function used in case the user pressed the submit button named create review on the review popup
 * @param {*} rent_id the id of the rent we are gonna have our review associated with
 */
function pressed_create_review(rent_id) {
    let rating = document.getElementById("new_rating").value;
    let comment = document.getElementById("new_review").value;
    let error_rating = document.getElementById("error_rating");
    let popup = document.getElementById("popup_review");

    // getting the current date
    let today = new Date();
    let dd = String(today.getDate()).padStart(2, '0');
    let mm = String(today.getMonth() + 1).padStart(2, '0'); //January is 0!
    let yyyy = today.getFullYear();
    today = yyyy + '-' + mm + '-' + dd;

    if (rating >= 0 && rating <= 5) {
        // if it is then we send a xmlhttprequest() to add the review to ur database
        let ourRequest = new XMLHttpRequest();
        ourRequest.open("POST", "../actions/api_create_review.php", true);
        ourRequest.setRequestHeader('Content-Type', 'application/x-www-form-urlencoded');
        ourRequest.onload = create_review;
        ourRequest.send(encodeForAjax({ rent_id: rent_id, comment: comment, date: today, rating: rating }));
        popup.style.display = "none";
    } else {
        error_rating.style.display = "block";
    }
}


/**
 * parsing the response from the server, if all went ok then the review was added and it returned true
 * if something went wrong then it return false and we give an alert
 */
function create_review() {
    let response = JSON.parse(this.responseText);
    if (response == true)
        reloadHtmlRequest();
    else
        give_alert("Something went wrong with reviewing, try again later");
}

// reloading the my reservations to show the updated reservations on the start of the script
reloadHtmlRequest();

/**
 * send a http request to get the information about the reservations for the user 
 */
function reloadHtmlRequest() {
    let requestShowHouses = new XMLHttpRequest();
    requestShowHouses.open("GET", "../actions/api_show_reservations.php", true);
    requestShowHouses.setRequestHeader('Content-Type', 'application/x-www-form-urlencoded');
    requestShowHouses.onload = reloadHtml;
    requestShowHouses.send();
}

/**
 * gets the response and parses it 
 */
function reloadHtml() {

    let ourData = JSON.parse(this.responseText);
    let div_to_hold_houses = document.getElementById("my_reservations");
    if (ourData == -1) {
        let article = document.createElement('houses')
        article.setAttribute('class', 'post')
        let houses = '<p id="error-no-properties"> No Reservations yet </p>';
        article.innerHTML = houses;
        div_to_hold_houses.innerHTML = article.innerHTML;

    } else {

        let article = document.createElement('houses')
        article.setAttribute('class', 'post')

        let houses = return_html_in_string_form(ourData);
        article.innerHTML = houses;
        div_to_hold_houses.innerHTML = article.innerHTML;

        let my_properties1 = document.getElementsByClassName("myproperties1");
        let my_properties2 = document.getElementsByClassName("myproperties2");
        let my_properties3 = document.getElementsByClassName("myproperties3");

        let buttonsReservations_1 = document.getElementsByClassName("buttonsReservations_1");
        let buttonsReservations_2 = document.getElementsByClassName("buttonsReservations_2");

        for (let i = 0; i < buttonsReservations_1.length; i++) {
            buttonsReservations_1[i].setAttribute("style", "font-size: 1.3em; margin-left: 0.3em; padding: 0.4em;");
        }

        for (let i = 0; i < buttonsReservations_2.length; i++) {
            buttonsReservations_2[i].setAttribute("style", "font-size: 1.3em; margin-left: 0.3em; padding: 0.4em;");
        }




        // for (let i = 0; i < my_properties1.length; i++) {
        //     if (i == 0)
        //         my_properties1[i].setAttribute("style", "text-align: center; padding: 1em;  grid-column: 2; margin-left: 10%; margin-right: 10%; background-color: turquoise; border-radius: 2em");
        //     else
        //         my_properties1[i].setAttribute("style", "text-align: center; padding: 1em; margin-top: 3em; grid-column: 2; margin-left: 10%; margin-right: 10%; background-color: turquoise; border-radius: 2em");

        // }
        // for (let i = 0; i < my_properties2.length; i++) {
        //     if (i == 0)
        //         my_properties2[i].setAttribute("style", "text-align: center; padding: 1em; grid-column: 3; margin-left: 10%; margin-right: 10%;");
        //     else
        //         my_properties2[i].setAttribute("style", "text-align: center; padding: 1em; margin-top: 3em; grid-column: 3; margin-left: 10%; margin-right: 10%;");
        // }
        // for (let i = 0; i < my_properties3.length; i++) {
        //     if (i == 0)
        //         my_properties3[i].setAttribute("style", "text-align: center; padding: 1em;  grid-column: 4; margin-left: 10%; margin-right: 10%;");
        //     else
        //         my_properties3[i].setAttribute("style", "text-align: center; padding: 1em; margin-top: 3em; grid-column: 4; margin-left: 10%; margin-right: 10%;");

        // }
    }

}


/**
 * returns in a string format the html that represents all the reservations for a user
 * @param {*} ourData houses data
 */
function return_html_in_string_form(ourData) {

    let house = "";


    for (let i = 0; i < ourData.length; i += 3) {

        house += '<div class="myproperties1">';
        house += draw_house_in_organized_fashion_Properties(ourData[i]);
        house += '</div>';

        if (i + 1 < ourData.length) {
            house += '<div class="myproperties2">';
            house += draw_house_in_organized_fashion_Properties(ourData[i + 1]);
            house += '</div>';

        }
        if (i + 2 < ourData.length) {
            house += '<div class="myproperties3">';
            house += draw_house_in_organized_fashion_Properties(ourData[i + 2]);
            house += '</div>';
        }
    }
    return house;
}

/**
 * returns the html that represents the info for a single house, the main image for that house, and the respective buttons message
 * owner and review and cancel/Arquive
 * @param {*} house_data the data for a specific house
 */
function draw_house_in_organized_fashion_Properties(house_data) {

    let house_id = house_data['Id'];
    let rent_id = house_data['RentId'];
    let review_added_or_not = house_data['review'];
    let return_html_in_string_form;

    return_html_in_string_form = draw_house_in_organized_fashion(house_data);

    return_html_in_string_form += '<button class="buttonsReservations_2" onClick="pressed_Message_Button(' + house_id + ')">Message Owner</button>';

    let today = new Date();
    let dd = String(today.getDate()).padStart(2, '0');
    let mm = String(today.getMonth() + 1).padStart(2, '0'); //January is 0!
    let yyyy = today.getFullYear();

    today = yyyy + '-' + mm + '-' + dd;


    if (today > house_data['EndDate'] && review_added_or_not == 0) {
        return_html_in_string_form += '<button class = "buttonsReservations_1" onClick="pressed_review_Button(' + rent_id + ')"> Review </button>';
    }

    if (today <= house_data['StartDate']) {
        return_html_in_string_form += '<button class = "buttonsReservations_1" onClick="pressed_cancel_Button(' + rent_id + ')"> Cancel </button>';
    } else if (today >= house_data['EndDate']) {
        return_html_in_string_form += '<button class = "buttonsReservations_1" onClick="pressed_cancel_Button(' + rent_id + ')"> Arquive </button>';
    }

    return return_html_in_string_form;
}

/**
 * returns all the info in html for a certain house and the image for that house
 * @param {*} house_data the info for a certain house
 */
function draw_house_in_organized_fashion(house_data) {

    let return_html_in_string_form;

    let pic = house_data["pic"];
    if (pic == null) {
        pic = '../assets/imagesHouses/noHouseImage.png';
    }
    return_html_in_string_form = '<img src=' + pic + ' width="330" height="230" />';
    return_html_in_string_form += '<section id="my_reservation" name="information">';
    let name = house_data["Name"];
    let id = house_data['Id'];
    return_html_in_string_form += '<p> <a id="see_house" href="housepage.php?house_id=' + id + '">' + name + '</a></p>';
    let addr = house_data["Address"];
    return_html_in_string_form += '<p>' + addr + '</p>';
    let price = house_data["PricePerDay"];
    return_html_in_string_form += '<p> Price: ' + price + '€ /night </p>';
    let rating = (Math.round(house_data["Rating"] * 100) / 100).toFixed(1);
    let cnt = house_data["cnt"];
    return_html_in_string_form += '<pre><img src=../assets/star.png width="18" height="15" />' + rating + '       ' + cnt + 'comments </pre>';
    return_html_in_string_form += '</section>';
    return_html_in_string_form += '<p> Reservation Period: ' + house_data['StartDate'] + ' <-> ' + house_data['EndDate'] + '<p>';


    return return_html_in_string_form;
}