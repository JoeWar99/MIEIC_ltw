"use strict";

let form = "search_form";

// GETTING ALL INPUT TEXT OBJECTS
let location_text = document.getElementById("location_input");
let start_date_text = document.getElementById("start_input");
let end_date_text = document.getElementById("end_input");


// GETTING ALL ERROR DISPLAY OBJECTS
let location_error = document.getElementById("location_error");
let start_date_error = document.getElementById("start_error");
let end_date_error = document.getElementById("end_error");

// SETTING ALL EVENT LISTENERS
location_text.addEventListener("input", location_verify, true);
start_date_text.addEventListener("input", date_verify, true);
end_date_text.addEventListener("input", date_verify, true);

function Validate() {
    let returnValue = true;

    if (!location_verify()) returnValue = false;
    else if (!locations_aux.includes(location_text.value)) {
        location_text.style.border = "1px solid red";
        location_error.style.fontSize = "small";
        location_error.style.textAlign = "center";
        location_error.style.display = "block";
        location_error.style.color = "red";
        location_error.textContent = "Location not in the database";
        returnValue = false;
    }

    if (!date_verify()) returnValue = false;

    if (returnValue == false) {
        return returnValue;
    } else {
        return returnValue;
    }

}

function location_verify() {
    if (location_text.value == "") {
        location_text.style.border = "1px solid red";
        location_error.style.fontSize = "small";
        location_error.style.textAlign = "center";
        location_error.style.color = "red";
        location_error.textContent = "location is required";
        location_error.style.display = "block";
        return false;
    } else {
        location_text.style.border = "none";
        location_error.innerHTML = "";
        location_error.style.display = "none";
        return true;
    }
}

function date_verify() {


    if (start_date_text.value != "" && end_date_text.value == "") {
        end_date_text.style.border = "1px solid red";
        end_date_error.style.fontSize = "small";
        end_date_error.style.textAlign = "center";
        end_date_error.style.color = "red";

        end_date_error.textContent = "Check-out date is required if Check-in is defined";
        end_date_error.style.display = "block";
        return false;

    } else if (end_date_text.value != "" && start_date_text.value == "") {
        start_date_text.style.border = "1px solid red";
        start_date_error.style.fontSize = "small";
        start_date_error.style.textAlign = "center";
        start_date_error.style.color = "red";
        start_date_error.textContent = "Check-in date is required if Check-in is defined";
        start_date_error.style.display = "block";
        return false;

    } else if (start_date_text.value > end_date_text.value && start_date_text.value != "" && end_date_text.value != "") {
        start_date_text.style.border = "1px solid red";
        start_date_error.style.fontSize = "small";
        start_date_error.style.textAlign = "center";
        start_date_error.style.color = "red";

        start_date_error.textContent = "Check-in date must be before Check-out date";
        start_date_error.style.display = "block";
    } else if (start_date_text.value == end_date_text.value && start_date_text.value != "" && end_date_text.value != "") {
        start_date_text.style.border = "1px solid red";
        start_date_error.style.fontSize = "small";
        start_date_error.style.textAlign = "center";
        start_date_error.style.color = "red";

        start_date_error.textContent = "Check-out date is equal to Check-in date";

        start_date_error.style.display = "block";
    } else if (end_date_text.value < start_date_text.value && start_date_text.value != "" && end_date_text.value != "") {
        end_date_text.style.border = "1px solid red";
        end_date_error.style.fontSize = "small";
        end_date_error.style.textAlign = "center";
        end_date_error.style.color = "red";

        end_date_error.textContent = "Check-out date must be after Check-in";

        end_date_error.style.display = "block";
        return false;
    } else {
        end_date_text.style.border = "none";
        end_date_error.innerHTML = "";
        end_date_error.style.display = "none";
        start_date_text.style.border = "none";
        start_date_error.innerHTML = "";
        start_date_error.style.display = "none";
        return true;
    }




}



onload();


function onload() {
    // preparing the xmlhttprequest()
    let ourRequest = new XMLHttpRequest();
    ourRequest.open("GET", "../actions/api_get_locations.php", true);
    ourRequest.onload = get_locations;
    ourRequest.send();
}

let locations_aux = [];


function get_locations() {
    let locations = JSON.parse(this.responseText);
    locations_aux = [];

    for (let i = 0; i < locations.length; i++) {
        locations_aux.push(locations[i]['location']);
    }
    console.log(locations);
    if (locations != -1) {
        autocomplete(document.getElementById("location_input"), locations_aux);
    }

}



function autocomplete(inp, arr) {
    /*the autocomplete function takes two arguments,
    the text field element and an array of possible autocompleted values:*/
    let currentFocus;
    /*execute a function when someone writes in the text field:*/
    inp.addEventListener("input", function(e) {
        let a, b, i, val = this.value;
        /*close any already open lists of autocompleted values*/
        closeAllLists();
        if (!val) { return false; }
        currentFocus = -1;
        /*create a DIV element that will contain the items (values):*/
        a = document.createElement("DIV");
        a.setAttribute("id", this.id + "autocomplete-list");
        a.setAttribute("class", "autocomplete-items");
        /*append the DIV element as a child of the autocomplete container:*/
        this.parentNode.appendChild(a);
        /*for each item in the array...*/
        for (i = 0; i < arr.length; i++) {
            /*check if the item starts with the same letters as the text field value:*/
            if (arr[i].substr(0, val.length).toUpperCase() == val.toUpperCase()) {
                /*create a DIV element for each matching element:*/
                b = document.createElement("DIV");
                /*make the matching letters bold:*/
                b.innerHTML = "<strong>" + arr[i].substr(0, val.length) + "</strong>";
                b.innerHTML += arr[i].substr(val.length);
                /*insert a input field that will hold the current array item's value:*/
                b.innerHTML += "<input type='hidden' value='" + arr[i] + "'>";
                /*execute a function when someone clicks on the item value (DIV element):*/
                b.addEventListener("click", function(e) {
                    /*insert the value for the autocomplete text field:*/
                    inp.value = this.getElementsByTagName("input")[0].value;
                    /*close the list of autocompleted values,
                    (or any other open lists of autocompleted values:*/
                    closeAllLists();
                });
                a.appendChild(b);
            }
        }
    });
    /*execute a function presses a key on the keyboard:*/
    inp.addEventListener("keydown", function(e) {
        let x = document.getElementById(this.id + "autocomplete-list");
        if (x) x = x.getElementsByTagName("div");
        if (e.keyCode == 40) {
            /*If the arrow DOWN key is pressed,
            increase the currentFocus variable:*/
            currentFocus++;
            /*and and make the current item more visible:*/
            addActive(x);
        } else if (e.keyCode == 38) { //up
            /*If the arrow UP key is pressed,
            decrease the currentFocus variable:*/
            currentFocus--;
            /*and and make the current item more visible:*/
            addActive(x);
        } else if (e.keyCode == 13) {
            /*If the ENTER key is pressed, prevent the form from being submitted,*/
            e.preventDefault();
            if (currentFocus > -1) {
                /*and simulate a click on the "active" item:*/
                if (x) x[currentFocus].click();
            }
        }
    });

    function addActive(x) {
        /*a function to classify an item as "active":*/
        if (!x) return false;
        /*start by removing the "active" class on all items:*/
        removeActive(x);
        if (currentFocus >= x.length) currentFocus = 0;
        if (currentFocus < 0) currentFocus = (x.length - 1);
        /*add class "autocomplete-active":*/
        x[currentFocus].classList.add("autocomplete-active");
    }

    function removeActive(x) {
        /*a function to remove the "active" class from all autocomplete items:*/
        for (let i = 0; i < x.length; i++) {
            x[i].classList.remove("autocomplete-active");
        }
    }

    function closeAllLists(elmnt) {
        /*close all autocomplete lists in the document,
        except the one passed as an argument:*/
        let x = document.getElementsByClassName("autocomplete-items");
        for (let i = 0; i < x.length; i++) {
            if (elmnt != x[i] && elmnt != inp) {
                x[i].parentNode.removeChild(x[i]);
            }
        }
    }
    /*execute a function when someone clicks in the document:*/
    document.addEventListener("click", function(e) {
        closeAllLists(e.target);
    });
}