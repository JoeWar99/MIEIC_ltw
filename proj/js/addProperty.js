// GETTING ALL INPUT TEXT OBJECTS


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


house_name.addEventListener("input", house_name_verify, true);
price_per_day.addEventListener("input", price_per_day_verify, true);
adress.addEventListener("input", adress_verify, true);
city.addEventListener("input", city_verify, true);
country.addEventListener("input", country_verify, true);
capacity.addEventListener("input", capacity_verify, true);
postal_code.addEventListener("input", postal_code_verify, true);


function Validate() {

    let returnValue = false;
    return true;
    if (!house_name_verify()) {
        returnValue = false;
    }

    if (!price_per_day_verify()) {
        returnValue = false;
    }

    if (!adress_verify()) {
        returnValue = false;
    }

    if (!city_verify()) {
        returnValue = false;
    }

    if (!country_verify()) {
        returnValue = false;
    }

    if (!capacity_verify()) {
        returnValue = false;
    }

    if (!postal_code_verify()) {
        returnValue = false;
    }
    return returnValue;
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

    if (country.value == "") {
        country.style.border = "1px solid red";
        country_error.style.fontSize = "small";
        country_error.style.textAlign = "center";
        country_error.textContent = "Country is required";
        return false;
    } else {
        country.style.border = border_style;
        country_error.innerHTML = ""
        return true;
    }

}


function city_verify() {

    if (city.value == "") {
        city.style.border = "1px solid red";
        city_error.style.fontSize = "small";
        city_error.style.textAlign = "center";
        city_error.textContent = "City is required";
        return false;
    } else {
        city.style.border = border_style;
        city_error.innerHTML = ""
        return true;
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

    console.log(price_per_day.value);


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
    var preview = document.querySelector('#preview' + aux_number);

    preview.innerHTML = '<img src="../assets/imagesHouses/noHouseImage.png" alt="no image" width="200" height="150">';


}


function previewImages(object) {
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


        let image = new Image();
        image.height = 150;
        image.title = file.name;
        image.src = this.result;


        let button = document.createElement('button');
        button.setAttribute('onclick', 'button_delete(' + number + ')');
        button.type = "button";
        button.innerHTML = "Delete Image";

        preview.innerHTML = "";
        preview.appendChild(image);
        preview.appendChild(button);

    });

    reader.readAsDataURL(file);

};