'use strict'


function encodeForAjax(data) {
    return Object.keys(data).map(function(k) {
        return encodeURIComponent(k) + '=' + encodeURIComponent(data[k])
    }).join('&')
}




function pressed_cancel_Button(rent_id) {
    let ourRequest = new XMLHttpRequest();
    console.log(rent_id);
    ourRequest.open("POST", "../actions/api_cancel_reservation.php", true);
    ourRequest.setRequestHeader('Content-Type', 'application/x-www-form-urlencoded');
    ourRequest.onload = cancel_reservation;
    ourRequest.send(encodeForAjax({ rent_id: rent_id }));
}


function cancel_reservation() {

    let ourData = JSON.parse(this.responseText);
    console.log("repsonse");
    console.log(ourData);
    if (ourData == -1)
        alert("Can't cancel that reservation because the occupation period already started");
    else if (ourData == true) {
        console.log('entrei aqui');
        reloadHtmlRequest();
    } else
        alert("Can't cancel that reservation");
}


function pressed_review_Button(rent_id) {

    var popup = document.getElementById("popup");

    let return_html_in_string_form = '<div id="popup_content"><span id="close">&times;</span><form>Rating: <br><input type="text" id="new_rating" name="new_rating" placeholder="Rating"><br>';
    return_html_in_string_form += '<span id=\"error_rating\" >  Rating between 1 and 5</span>Review: <br><input type="text" id="new_review" name="new_review" placeholder="Review"><br>';
    return_html_in_string_form += '<button id="create_review" type="button" onclick="pressed_create_review(' + rent_id + ')">Submit</button><br>';
    return_html_in_string_form += '</form></div>';

    popup.innerHTML = return_html_in_string_form;

    var popup = document.getElementById("popup");
    var x = document.getElementById("close");
    var error_rating = document.getElementById("error_rating");

    popup.style.display = "block";

    x.onclick = function() {
        popup.style.display = "none";
        error_rating.style.display = "none";
    }

    window.onclick = function(event) {
        if (event.target == popup) {
            popup.style.display = "none";
            error_rating.style.display = "none";
        }
    }
}

function pressed_create_review(rent_id) {
    var rating = document.getElementById("new_rating").value;
    var comment = document.getElementById("new_review").value;

    var today = new Date();
    var dd = String(today.getDate()).padStart(2, '0');
    var mm = String(today.getMonth() + 1).padStart(2, '0'); //January is 0!
    var yyyy = today.getFullYear();

    today = yyyy + '-' + mm + '-' + dd;

    if (rating > 1 && rating < 5) {
        let ourRequest = new XMLHttpRequest();
        console.log(rent_id);
        ourRequest.open("POST", "../actions/api_create_review.php", true);
        ourRequest.setRequestHeader('Content-Type', 'application/x-www-form-urlencoded');
        ourRequest.onload = create_review;
        ourRequest.send(encodeForAjax({ rent_id: rent_id, comment: comment, date: today, rating: rating }));
        location.reload();
    } else {
        error_rating.style.display = "block";
    }
}

function create_review() {
    console.log(this.responseText);
}

reloadHtmlRequest();

function reloadHtmlRequest() {
    let requestShowHouses = new XMLHttpRequest();
    requestShowHouses.open("GET", "../actions/api_show_reservations.php", true);
    requestShowHouses.setRequestHeader('Content-Type', 'application/x-www-form-urlencoded');
    requestShowHouses.onload = reloadHtml;
    requestShowHouses.send();
}

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

        div_to_hold_houses.setAttribute("style", " display: grid; grid-template-columns: 0.5 fr 2 fr 2 fr 2 fr 0.5 fr;");
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



        for (let i = 0; i < my_properties1.length; i++) {
            my_properties1[i].setAttribute("style", "text-align: center; margin-top: 3em; grid-column: 2; margin-left: 10%; margin-right: 10%;");
        }
        for (let i = 0; i < my_properties2.length; i++) {
            my_properties2[i].setAttribute("style", "text-align: center; margin-top: 3em; grid-column: 3; margin-left: 10%; margin-right: 10%;");
        }
        for (let i = 0; i < my_properties3.length; i++) {
            my_properties3[i].setAttribute("style", "text-align: center; margin-top: 3em; grid-column: 4; margin-left: 10%; margin-right: 10%;");
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


function draw_house_in_organized_fashion_Properties(house_data) {

    let house_id = house_data['Id'];
    let rent_id = house_data['RentId'];
    let review_added_or_not = house_data['review'];
    let return_html_in_string_form;

    return_html_in_string_form = draw_house_in_organized_fashion(house_data);

    return_html_in_string_form += '<button class="buttonsReservations_2" onClick="pressed_Message_Button(' + house_id + ')">Message Owner</button>';

    var today = new Date();
    var dd = String(today.getDate()).padStart(2, '0');
    var mm = String(today.getMonth() + 1).padStart(2, '0'); //January is 0!
    var yyyy = today.getFullYear();

    today = yyyy + '/' + mm + '/' + dd;
    //document.write(today);
    console.log(review_added_or_not)

    if (today > house_data['EndDate'] && review_added_or_not == 0) {
        return_html_in_string_form += '<button class = "buttonsReservations_1" onClick="pressed_review_Button(' + rent_id + ')"> Review </button>';
    }
    if (today < house_data['StartDate']) {
        return_html_in_string_form += '<button class = "buttonsReservations_1" onClick="pressed_cancel_Button(' + rent_id + ')"> Cancel </button>';
    } else if (today > house_data['EndDate']) {
        return_html_in_string_form += '<button class = "buttonsReservations_1" onClick="pressed_cancel_Button(' + rent_id + ')"> Arquive </button>';
    }


    return return_html_in_string_form;
}


function draw_house_in_organized_fashion(house_data) {

    let return_html_in_string_form;

    let pic = house_data["pic"];
    if (pic == null) {
        pic = '../assets/imagesHouses/noHouseImage.png';
    }
    return_html_in_string_form = '<img src=' + pic + ' width="330" height="230" />';
    return_html_in_string_form += '<section name="information">';
    let name = house_data["Name"];
    let id = house_data['Id'];
    return_html_in_string_form += '<p> <a href="housepage.php?house_id=' + id + '">' + name + '</a></p>';
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