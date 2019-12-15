// GETTING ALL INPUT TEXT OBJECTS
'use strict'

let house_name = document.getElementById("house-name");
let price_per_day = document.getElementById("price-per-day");
let adress = document.getElementById("adress");
let city = document.getElementById("city");
let country = document.getElementById("country");
let capacity = document.getElementById("capacity");
let postal_code = document.getElementById("postal-code");



// GETTING ALL ERROR DISPLAY OBJECTS
let house_name_error = document.getElementById("HouseNameError");
let price_per_day_error = document.getElementById("PricePerDayError");
let adress_error = document.getElementById("AdressError");
let postal_code_error = document.getElementById("PostalCodeError");
let city_error = document.getElementById("CityError");
let country_error = document.getElementById("CountryError");
let capacity_error = document.getElementById("CapacityError");

on_load();


function on_load() {

    let house_id = document.getElementById("house_id").value;
    on_load_page_place_images(house_id);

}

function on_load_page_place_images(house_id) {

    let ourRequest = new XMLHttpRequest();
    ourRequest.open("POST", "../actions/api_edit_photos.php", true);
    ourRequest.setRequestHeader('Content-Type', 'application/x-www-form-urlencoded');
    ourRequest.onload = function() {
        on_response(this, house_id);
    };
    ourRequest.send(encodeForAjax({ houseId: house_id }));


}

let array_of_images = [0, 0, 0, 0, 0, 0];


function on_response(object, house_id) {

    let ourData = JSON.parse(object.responseText);
    console.log(ourData);

    let number = 0;


    for (let i = 0; i < ourData.length; i++) {
        if (ourData[i]['path'].includes('../assets/imagesHouses/houseImage_' + house_id + '_0')) {
            number = 0;
        } else if (ourData[i]['path'].includes('../assets/imagesHouses/houseImage_' + house_id + '_1')) {
            number = 1;
        } else if (ourData[i]['path'].includes('../assets/imagesHouses/houseImage_' + house_id + '_2')) {
            number = 2;
        } else if (ourData[i]['path'].includes('../assets/imagesHouses/houseImage_' + house_id + '_3')) {
            number = 3;
        } else if (ourData[i]['path'].includes('../assets/imagesHouses/houseImage_' + house_id + '_4')) {
            number = 4;
        } else if (ourData[i]['path'].includes('../assets/imagesHouses/houseImage_' + house_id + '_5')) {
            number = 5;
        }

        var preview = document.querySelector('#preview' + number);
        console.log(this);

        // preview.setAttribute("style", " display: grid; grid-template-rows: 1fr 0.5fr;");

        let image = new Image();
        image.height = 150;
        image.src = ourData[i]['path'];

        let element_input = document.getElementById("input-" + number);
        element_input.style.display = "none";

        array_of_images[number] = 2;
        let button = document.createElement('button');
        button.setAttribute('onclick', 'button_delete(' + number + ')');
        button.type = "button";
        button.innerHTML = "Delete Image";
        button.setAttribute('style', 'margin-top: 5%; width:40%; height = 10%;');

        let br = document.createElement('br');

        preview.innerHTML = "";
        preview.appendChild(image);
        preview.appendChild(br);
        preview.appendChild(button);

    }






}





house_name.addEventListener("input", house_name_verify, true);
price_per_day.addEventListener("input", price_per_day_verify, true);
adress.addEventListener("input", adress_verify, true);
country.addEventListener('input', country_verify, true);
city.addEventListener('input', city_verify, true);
capacity.addEventListener("input", capacity_verify, true);
postal_code.addEventListener("input", postal_code_verify, true);


function encodeForAjax(data) {
    return Object.keys(data).map(function(k) {
        return encodeURIComponent(k) + '=' + encodeURIComponent(data[k])
    }).join('&')
}

function Validate($house_id) {

    let returnValue = true;

    if (!house_name_verify()) {
        returnValue = false;
    }

    if (!price_per_day_verify()) {
        returnValue = false;
    }

    if (!adress_verify()) {
        returnValue = false;
    }


    if (!capacity_verify()) {
        returnValue = false;
    }

    if (!postal_code_verify()) {
        returnValue = false;
    }

    if (!return_value_country || !return_value_city) {
        returnValue = false;
    }

    if (returnValue == false) {
        return false;
    } else {
        let form = document.getElementById('add-propertyForm');
        let formData = new FormData(form);
        formData.append('houseId', $house_id);

        let ourRequest = new XMLHttpRequest();
        ourRequest.open("POST", "../actions/api_update_house.php", true);
        ourRequest.onload = receive_add_property_response;
        formData.append('File0', array_of_images[0]);
        formData.append('File1', array_of_images[1]);
        formData.append('File2', array_of_images[2]);
        formData.append('File3', array_of_images[3]);
        formData.append('File4', array_of_images[4]);
        formData.append('File5', array_of_images[5]);
        ourRequest.send(formData);
        return true;
    }
}

function receive_add_property_response() {
    let ourData = JSON.parse(this.responseText);
    if (ourData == -1)
        alert("Some error ocurred");
    else
        window.location = "../pages/myProperties.php";
}

let border_style = capacity.style.border;

function capacity_verify() {

    if (capacity.value == "") {
        capacity.style.border = "1px solid red";
        capacity_error.style.fontSize = "small";
        capacity_error.style.textAlign = "center";
        capacity_error.textContent = "capacity is required";
        return false;
    } else if (capacity.value < 0) {
        console.log('entrei aqui');
        capacity.style.border = "1px solid red";
        capacity_error.style.fontSize = "small";
        capacity_error.style.textAlign = "center";
        capacity_error.textContent = "Capacity can't be a negative value";
        return false;
    } else {
        capacity.style.border = border_style;
        capacity_error.innerHTML = ""
        return true;
    }

}


function country_verify() {
    let country_name = country.value;
    let city_name = city.value;

    country_name = country_name.trim();
    city_name = city_name.trim();

    let ourRequest = new XMLHttpRequest();
    ourRequest.open("POST", "../actions/api_check_city_country.php", true);
    ourRequest.setRequestHeader('Content-Type', 'application/x-www-form-urlencoded');
    ourRequest.onload = request_response_country;
    ourRequest.send(encodeForAjax({ country: country_name, city: city_name }));
}

let return_value_country = true;
let return_value_city = true;

function request_response_country() {
    let ourData = JSON.parse(this.responseText);
    console.log("repsonse");
    console.log(ourData);

    if (ourData == '-1') {
        country.style.border = "1px solid red";
        country_error.style.fontSize = "small";
        country_error.style.textAlign = "center";
        if (country.value == "")
            country_error.textContent = "Country is required";
        else
            country_error.textContent = "Invalid Country";
        return_value_country = false;
    } else if (ourData == "-2") {

        city.style.border = "1px solid red";
        city_error.style.fontSize = "small";
        city_error.style.textAlign = "center";
        country.style.border = border_style;
        country_error.innerHTML = "";
        if (city.value == "")
            city_error.textContent = "City is required";
        else
            city_error.textContent = "Invalid City for the country";
        return_value_country = true;
        return_value_city = false;

    } else if (ourData == "0") {
        city.style.border = border_style;
        city_error.innerHTML = "";
        country.style.border = border_style;
        country_error.innerHTML = "";
        return_value_city = true;
        return_value_country = true;
    }
}


function city_verify() {

    let country_name = country.value;
    let city_name = city.value;

    country_name = country_name.trim();
    city_name = city_name.trim();

    let ourRequest = new XMLHttpRequest();
    ourRequest.open("POST", "../actions/api_check_city_country.php", true);
    ourRequest.setRequestHeader('Content-Type', 'application/x-www-form-urlencoded');
    ourRequest.onload = request_response_city;
    ourRequest.send(encodeForAjax({ country: country_name, city: city_name }));


}

function request_response_city() {
    let ourData = JSON.parse(this.responseText);
    console.log("repsonse");
    console.log(ourData);

    if (country.value != "") {
        if (ourData == '-1') {
            country.style.border = "1px solid red";
            country_error.style.fontSize = "small";
            country_error.style.textAlign = "center";
            if (country.value == "")
                country_error.textContent = "Country is required";
            else
                country_error.textContent = "Invalid Country";
            return_value_country = false;
        } else if (ourData == "-2") {

            city.style.border = "1px solid red";
            city_error.style.fontSize = "small";
            city_error.style.textAlign = "center";
            country.style.border = border_style;
            country_error.innerHTML = "";
            if (city.value == "")
                city_error.textContent = "City is required";
            else
                city_error.textContent = "Invalid City for the country";
            return_value_country = true;
            return_value_city = false;

        } else if (ourData == "0") {
            city.style.border = border_style;
            city_error.innerHTML = "";
            country.style.border = border_style;
            country_error.innerHTML = "";
            return_value_city = true;
            return_value_country = true;
        }
    } else if (city.value == "") {
        city.style.border = "1px solid red";
        city_error.style.fontSize = "small";
        city_error.style.textAlign = "center";
        city_error.textContent = "City is required";

    }
}




function adress_verify() {

    if (adress.value == "") {
        adress.style.border = "1px solid red";
        adress_error.style.fontSize = "small";
        adress_error.style.textAlign = "center";
        adress_error.textContent = "Adress is required";
        return false;
    } else {
        adress.style.border = border_style;
        adress_error.innerHTML = ""
        return true;
    }

}

function postal_code_verify() {

    if (postal_code.value == "") {
        postal_code.style.border = "1px solid red";
        postal_code_error.style.fontSize = "small";
        postal_code_error.style.textAlign = "center";
        postal_code_error.textContent = "Postal Code is required";
        return false;
    } else {
        postal_code.style.border = border_style;
        postal_code_error.innerHTML = ""
        return true;
    }

}

function house_name_verify() {

    if (house_name.value == "") {
        house_name.style.border = "1px solid red";
        house_name_error.style.fontSize = "small";
        house_name_error.style.textAlign = "center";
        house_name_error.textContent = "House Name is required";
        return false;
    } else {
        house_name.style.border = border_style;
        house_name_error.innerHTML = ""
        return true;
    }

}

function price_per_day_verify() {

    if (price_per_day.value == "") {
        price_per_day.style.border = "1px solid red";
        price_per_day_error.style.fontSize = "small";
        price_per_day_error.style.textAlign = "center";
        price_per_day_error.textContent = "Price per day is required";
        return false;
    } else if (price_per_day.value < 0) {
        console.log('entrei aqui');
        price_per_day.style.border = "1px solid red";
        price_per_day_error.style.fontSize = "small";
        price_per_day_error.style.textAlign = "center";
        price_per_day_error.textContent = "Price per day can't be a negative value";
        return false;
    } else {
        price_per_day.style.border = border_style;
        price_per_day_error.innerHTML = ""
        return true;
    }
}


// IMAGES

let number;

document.querySelector('#file-input0').addEventListener("change", function() {
    number = 0;
    previewImages(this);
}, true);
document.querySelector('#file-input1').addEventListener("change", function() {
    number = 1;
    previewImages(this);
}, true);

document.querySelector('#file-input2').addEventListener("change", function() {
    number = 2;
    previewImages(this);
}, true);

document.querySelector('#file-input3').addEventListener("change", function() {
    number = 3;
    previewImages(this);
}, true);

document.querySelector('#file-input4').addEventListener("change", function() {
    number = 4;
    previewImages(this);
}, true);

document.querySelector('#file-input5').addEventListener("change", function() {
    number = 5;
    previewImages(this);
}, true);


function button_delete(aux_number) {
    let preview = document.querySelector('#preview' + aux_number);
    array_of_images[aux_number] = 0;
    let element_input = document.getElementById("input-" + aux_number);
    element_input.innerHTML = "";
    element_input.style.display = "";

    console.log('entrei aqui shit');

    let label = document.createElement('label');

    let p = document.createElement('p');
    p.innerHTML = "upload Image";
    p.setAttribute("class", 'btn-upload-image');

    let input = document.createElement('input');
    input.setAttribute('id', 'file-input' + aux_number);
    input.setAttribute('name', 'image' + aux_number);
    input.setAttribute('class', 'InputAddProperty');
    input.setAttribute('type', 'file');

    input.addEventListener("change", function() {
        number = aux_number;
        previewImages(this);
    }, true);

    label.appendChild(input);
    label.appendChild(p);

    element_input.appendChild(label);

    preview.innerHTML = '<img src="../assets/imagesHouses/noHouseImage.png" alt="no image" width="200" height="150">';
}

function previewImages(object) {
    console.log(object.files);
    if (object.files) {
        [].forEach.call(object.files, readAndPreview);
    }
}

function readAndPreview(file) {

    // Make sure `file.name` matches our extensions criteria
    if (!/\.(jpe?g|png|gif)$/i.test(file.name)) {
        return alert(file.name + " is not an image");
    } // else...

    let reader = new FileReader();



    reader.addEventListener("load", function() {

        var preview = document.querySelector('#preview' + number);
        console.log(this);

        // preview.setAttribute("style", " display: grid; grid-template-rows: 1fr 0.5fr;");

        let image = new Image();
        image.height = 150;
        image.title = file.name;
        image.src = this.result;

        let element_input = document.getElementById("input-" + number);
        element_input.style.display = "none";

        array_of_images[number] = 1;
        let button = document.createElement('button');
        button.setAttribute('onclick', 'button_delete(' + number + ')');
        button.type = "button";
        button.innerHTML = "Delete Image";
        button.setAttribute('style', 'margin-top: 5%; width:40%; height = 10%;');

        let br = document.createElement('br');

        preview.innerHTML = "";
        preview.appendChild(image);
        preview.appendChild(br);
        preview.appendChild(button);

    });

    reader.readAsDataURL(file);

}