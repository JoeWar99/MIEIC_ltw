/*document.querySelector('.buttonsReservations_2').addEventListener('click',
    function() {
        document.querySelector('.bg-modal').style.display = 'flex';
        document.querySelector
    });*/

let messages = document.getElementById("modal-content");

document.querySelector('.close').addEventListener('click',
    function() {
        document.querySelector('.bg-modal').style.display = 'none';
    });


function pressed_Message_Button(house_id) {
    document.querySelector('.bg-modal').style.display = 'flex';
}


function pressed_delete_Button(house_id) {

    let ourRequest = new XMLHttpRequest();
    ourRequest.open("POST", "../actions/api_deleteHouse.php", true);
    ourRequest.setRequestHeader('Content-Type', 'application/x-www-form-urlencoded');
    ourRequest.onload = delete_house;
    ourRequest.send(encodeForAjax({ houseId: house_id }));
}

function delete_house() {
    let ourData = JSON.parse(this.responseText);
    console.log(ourData);
    if (ourData == -1)
        alert("Cant Delete That house there's reservation in progress or in the future");
    else
        reloadHtmlRequest();

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
        console.log(document)

        let houses = '<p id="error-no-properties"> No Reservations yet </p>';

        article.innerHTML = houses;

        console.log(article);

        div_to_hold_houses.innerHTML = article.innerHTML;

    } else {

        div_to_hold_houses.setAttribute("style", " display: grid; grid-template-columns: 0.5 fr 2 fr 2 fr 2 fr 0.5 fr;");
        let article = document.createElement('houses')
        article.setAttribute('class', 'post')
        console.log(document)

        let houses = return_html_in_string_form(ourData);

        article.innerHTML = houses;

        console.log(article);

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
    }

}


function return_html_in_string_form(ourData) {

    let house = "";

    console.log(ourData.length);

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
    let return_html_in_string_form;

    return_html_in_string_form = draw_house_in_organized_fashion(house_data);

    return_html_in_string_form += '<button class="buttonsReservations_2" onClick="pressed_Message_Button(' + house_id + ')">Message Owner</button>';
    return_html_in_string_form += '<button class = "buttonsReservations_1" > Review </button>';
    return_html_in_string_form += '<button class = "buttonsReservations_1" > Cancel </button>';

    return return_html_in_string_form;
}


function draw_house_in_organized_fashion(house_data) {

    let return_html_in_string_form;

    let pic = house_data["pic"];
    if (pic == null) {
        pic = '../assets/imagesHouses/noHouseImage.png';
    }
    console.log('pic?');
    console.log(pic);
    return_html_in_string_form = '<img src=' + pic + ' width="330" height="230" />';
    return_html_in_string_form += '<section name="information">';
    let name = house_data["Name"];
    let id = house_data['Id'];
    return_html_in_string_form += '<p> <a href="housepage.php?house_id=' + id + '">' + name + '</a></p>';
    let addr = house_data["Address"];
    return_html_in_string_form += '<p>' + addr + '</p>';
    let price = house_data["PricePerDay"];
    return_html_in_string_form += '<p> Price: ' + price + '€ /night </p>';
    let rating = house_data["Rating"];
    let cnt = house_data["cnt"];
    return_html_in_string_form += '<pre><img src=../assets/star.png width="18" height="15" />' + rating + '       ' + cnt + 'comments </pre>';
    return_html_in_string_form += '</section>';

    return return_html_in_string_form;


}