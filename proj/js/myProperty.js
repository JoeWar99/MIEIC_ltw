// POP UPS



function encodeForAjax(data) {
    return Object.keys(data).map(function(k) {
        return encodeURIComponent(k) + '=' + encodeURIComponent(data[k])
    }).join('&')
}

document.getElementById('addProperty').addEventListener('click',
    function() {
        document.querySelector('.bg-modal').style.display = 'flex';
    });

document.querySelector('.close').addEventListener('click',
    function() {
        document.querySelector('.bg-modal').style.display = 'none';
    });


document.getElementById('addPicture').addEventListener('click',
    function() {
        document.querySelector('.bg-modal-1').style.display = 'flex';
    });

document.querySelector('.close1').addEventListener('click',
    function() {
        document.querySelector('.bg-modal-1').style.display = 'none';
    });

let properties_container = document.getElementById("my_properties");

function pressed_delete_Button(house_id) {

    let ourRequest = new XMLHttpRequest();
    ourRequest.open("POST", "../actions/api_deleteHouse.php", true);
    ourRequest.setRequestHeader('Content-Type', 'application/x-www-form-urlencoded');
    ourRequest.onload = reloadHtmlRequest;
    ourRequest.send(encodeForAjax({ houseId: house_id }));
}

reloadHtmlRequest();


function reloadHtmlRequest() {
    let requestShowHouses = new XMLHttpRequest();
    requestShowHouses.open("GET", "../actions/api_show_houses.php", true);
    requestShowHouses.setRequestHeader('Content-Type', 'application/x-www-form-urlencoded');
    requestShowHouses.onload = reloadHtml;
    requestShowHouses.send();
}

function reloadHtml() {
    let ourData = JSON.parse(this.responseText);
    console.log(ourData);
    let div_to_hold_houses = document.getElementById("my_properties");
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

    for (let i = 0; i < my_properties1.length; i++) {
        my_properties1[i].setAttribute("style", "text-align: center; margin-top: 3em; grid-column: 2; margin-left: 20%; margin-right: 20%;");
    }
    for (let i = 0; i < my_properties2.length; i++) {
        my_properties2[i].setAttribute("style", "text-align: center; margin-top: 3em; grid-column: 3; margin-left: 20%; margin-right: 20%;");
    }
    for (let i = 0; i < my_properties3.length; i++) {
        my_properties3[i].setAttribute("style", "text-align: center; margin-top: 3em; grid-column: 4; margin-left: 20%; margin-right: 20%;");
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

    return_html_in_string_form += '<button class="buttonsPropertyOwned" method="POST" action="../actions/action_register.php">Edit</button>';

    return_html_in_string_form += '<button class="buttonsPropertyOwned" onClick="pressed_delete_Button(' + house_id + ')">Delete</button>';

    return return_html_in_string_form;
}


function draw_house_in_organized_fashion(house_data) {

    let return_html_in_string_form;

    let pic = house_data["pic"];
    return_html_in_string_form = '<img src=' + pic + 'width="330" height="230" />';
    return_html_in_string_form = '<section name="information">';
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


// if ($houses_owned != -1) {
//     for ($i = 0; $i < count($houses_owned); $i = $i + 2) {
//         echo "<div class=\"my_properties1\">";
//         draw_house_in_organized_fashion_Properties($houses_owned[$i]);
//         echo "</div>";
//         if ($i + 1 < count($houses_owned)) {
//             echo "<div class=\"my_properties2\">";
//             draw_house_in_organized_fashion_Properties($houses_owned[$i + 1]);
//             echo "</div>";
//         }
//         if ($i + 2 < count($houses_owned)) {
//             echo "<div class=\"my_properties3\">";
//             draw_house_in_organized_fashion_Properties($houses_owned[$i + 2]);
//             echo "</div>";
//         }
//     }
// } else {
//     die(header('Location: 404page.php'));